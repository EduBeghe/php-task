<?php
  require 'vendor/autoload.php';
  use \PhpOffice\PhpSpreadsheet\IOFactory;

  $reader = IOFactory::createReader("Xlsx");
  $inputFileName = 'others/addresses.xlsx';
  $spreadsheet = $reader->load($inputFileName);
  $sheetData = $spreadsheet->getActiveSheet()->toArray();

	$ADDRESSES = array();

	for ($x = 1; $x <= count($sheetData) - 1; $x++) {
		$address = $sheetData[$x];
		array_push($ADDRESSES, "$address[1], $address[2], $address[3], $address[4], $address[5], $address[6]");
	};

