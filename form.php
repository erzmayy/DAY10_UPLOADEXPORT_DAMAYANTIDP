<?php

require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>Import Data PhpSpreadsheet</title>

    <script src="js/jquery.min.js"></script>

    <script>
        $(document).ready(function() {
            $("#kosong").hide();
        });
    </script>
</head>

<body>
    <h3>Form Import </h3>

    <form method="post" action="form.php" enctype="multipart/form-data">
        <a href="Format.xlsx">Download Format</a> &nbsp;|&nbsp;
        <a href="index.php">Back</a>
        <br><br>

        <input type="file" name="file">
        <button type="submit" name="preview">Preview</button>
    </form>
    <hr>

    <?php
    if (isset($_POST['preview'])) {
        $tgl_sekarang = date('YmdHis'); 
        $nama_file_baru = 'data' . $tgl_sekarang . '.xlsx';

        if (is_file('tmp/' . $nama_file_baru)) 
            unlink('tmp/' . $nama_file_baru); 

        $ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION); 
        $tmp_file = $_FILES['file']['tmp_name'];

        if ($ext == "xlsx") {
          
            move_uploaded_file($tmp_file, 'tmp/' . $nama_file_baru);

            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            $spreadsheet = $reader->load('tmp/' . $nama_file_baru); // Load file yang tadi diupload ke folder tmp
            $sheet = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

            echo "<form method='post' action='import.php'>";
            echo "<input type='hidden' name='namafile' value='" . $nama_file_baru . "'>";

            echo "<div id='kosong' style='color: red;margin-bottom: 10px;'>
					Semua data belum diisi, Ada <span id='jumlah_kosong'></span> data yang belum diisi.
                </div>";

            echo "<table border='1' cellpadding='5'>
					<tr>
						<th colspan='5' class='text-center'>Preview Data</th>
					</tr>
					<tr>
						<th>nim</th>
						<th>Nama</th>
						<th>Jenim Kelamin</th>
						<th>Telepon</th>
						<th>Alamat</th>
					</tr>";

            $numrow = 1;
            $kosong = 0;
            foreach ($sheet as $row) { 
                $nim = $row['A']; 
                $nama = $row['B']; 
                $jenim_kelamin = $row['C']; 
                $telp = $row['D']; 
                $alamat = $row['E']; 

                if ($nim == "" && $nama == "" && $jenim_kelamin == "" && $telp == "" && $alamat == "")
                    continue; 

                if ($numrow > 1) {
                    $nim_td = (!empty($nim)) ? "" : " style='background: #E07171;'"; 
                    $nama_td = (!empty($nama)) ? "" : " style='background: #E07171;'"; 
                    $jk_td = (!empty($jenim_kelamin)) ? "" : " style='background: #E07171;'"; 
                    $telp_td = (!empty($telp)) ? "" : " style='background: #E07171;'";
                    $alamat_td = (!empty($alamat)) ? "" : " style='background: #E07171;'"; 

                    if ($nim == "" or $nama == "" or $jenim_kelamin == "" or $telp == "" or $alamat == "") {
                        $kosong++; 
                    }

                    echo "<tr>";
                    echo "<td" . $nim_td . ">" . $nim . "</td>";
                    echo "<td" . $nama_td . ">" . $nama . "</td>";
                    echo "<td" . $jk_td . ">" . $jenim_kelamin . "</td>";
                    echo "<td" . $telp_td . ">" . $telp . "</td>";
                    echo "<td" . $alamat_td . ">" . $alamat . "</td>";
                    echo "</tr>";
                }

                $numrow++; 
            }

            echo "</table>";

          
            if ($kosong > 0) {
    ?>
                <script>
                    $(document).ready(function() {
                        $("#jumlah_kosong").html('<?php echo $kosong; ?>');

                        $("#kosong").show(); 
                    });
                </script>
    <?php
            } else { 
                echo "<hr>";

                echo "<button type='submit' name='import'>Import</button>";
            }

            echo "</form>";
        } else { 
            echo "<div style='color: red;margin-bottom: 10px;'>
					Masukan File Xls
                </div>";
        }
    }
    ?>
</body>

</html>