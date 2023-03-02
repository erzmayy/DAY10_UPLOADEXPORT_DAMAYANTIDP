<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>Import Data PhpSpreadsheet</title>

</head>

<body>
    <h3>Data Import</h3>

    <a href="form.php">Import Data</a><br><br>

    <table border="1" cellpadding="5">
        <tr>
            <th>No</th>
            <th>nim</th>
            <th>Nama</th>
            <th>Jenim Kelamin</th>
            <th>Telepon</th>
            <th>Alamat</th>
        </tr>
        <?php
        // file koneksi.php
        include "koneksi.php";

        
        $sql = mysqli_query($connect, "SELECT * FROM siswa");

        $no = 1; 
        while ($data = mysqli_fetch_array($sql)) { 
            echo "<tr>";
            echo "<td>" . $no . "</td>";
            echo "<td>" . $data['nim'] . "</td>";
            echo "<td>" . $data['nama'] . "</td>";
            echo "<td>" . $data['jenis_kelamin'] . "</td>";
            echo "<td>" . $data['telp'] . "</td>";
            echo "<td>" . $data['alamat'] . "</td>";
            echo "</tr>";

            $no++;
        }
        ?>
    </table>
</body>

</html>