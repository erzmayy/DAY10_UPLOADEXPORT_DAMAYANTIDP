<?php

include "koneksi.php";

require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

if(isset($_POST['import'])){ 
	$nama_file_baru = $_POST['namafile'];
    $path = 'tmp/' . $nama_file_baru;
    $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
    $spreadsheet = $reader->load($path); 
    $sheet = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

	$numrow = 1;
	foreach($sheet as $row){
		
		$nim = $row['A']; 
		$nama = $row['B']; 
		$jenis_kelamin = $row['C']; 
		$telp = $row['D']; 
		$alamat = $row['E']; 

		if($nim == "" && $nama == "" && $jenis_kelamin == "" && $telp == "" && $alamat == "")
			continue; 

		
		if($numrow > 1){
			
			$query = "INSERT INTO siswa VALUES('" . $nim . "','" . $nama . "','" . $jenis_kelamin . "','" . $telp . "','" . $alamat . "')";

			
			mysqli_query($connect, $query);
		}

		$numrow++; 
	}

    unlink($path); 
}

header('location: index.php'); 
