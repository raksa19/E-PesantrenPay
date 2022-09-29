<?php

include "../../vendor/autoload.php";

// $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
// $reader->setReadDataOnly(true);
// $reader->setLoadAllSheets();
// $spreadsheet = $reader->load("exampleExcel.xlsx");

// var_dump($spreadsheet);

$inputFileType = 'Xls';
$inputFileName = 'exampleExcel.xlsx';
$sheetname = 'Data Sheet #3';

/**  Define a Read Filter class implementing \PhpOffice\PhpSpreadsheet\Reader\IReadFilter  */
class MyReadFilter implements \PhpOffice\PhpSpreadsheet\Reader\IReadFilter
{
    public function readCell($column, $row, $worksheetName = '') {
        //  Read rows 1 to 7 and columns A to E only
        if ($row >= 1 && $row <= 7) {
            if (in_array($column,range('A','E'))) {
                return true;
            }
        }
        return false;
    }
}

/**  Create an Instance of our Read Filter  **/
$filterSubset = new MyReadFilter();

/**  Create a new Reader of the type defined in $inputFileType  **/
$reader = \PhpOffice\PhpSpreadsheet\IOFactory::load($inputFileName);
/**  Tell the Reader that we want to use the Read Filter  **/
$reader->setActiveSheetIndex(0);
/**  Load only the rows and columns that match our filter to Spreadsheet  **/
// $spreadsheet = $reader->load($inputFileName);
$no = 1;
// for($reader->getActiveSheet()->getCell('A'.$no)->getValue()){
//     var_dump($reader->getActiveSheet()->getCell('A'.$no)->getValue());
//     $no++;
// }
$total_row = $reader->getActiveSheet()->getCellByColumnAndRow(1, 6)->getRow();

// for ($i=1; $i <= $total_row; $i++){
//     echo $reader->getActiveSheet()->getCell('B'.$i)->getValue(). "\n";
// }
$fieldDatabase = ['nama', 'jenis_kelamin', 'ttl', 'kota', 'alamat', 'no_hp', 'nm_no'];
$coordinateColumn = ['A', 'B', 'C' ,'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M'];
$no_coordinate = 1;
$no_index = 1;
$i = 0;
$total_row = $reader->getActiveSheet()->getCellCollection()->getHighestRow();
$total_column = $reader->getActiveSheet()->getCellCollection()->getHighestRowAndColumn();

// while ($no_index <= sizeof($fieldDatabase)){

//     $getCell = $reader->getActiveSheet()->getCell($coordinateColumn[$i++]."1");
//     if (in_array($getCell->getValue(), $fieldDatabase)){
//         // echo $getCell->getValue()." ";
//         // echo $getCell->getCoordinate()."\n";

//         //membaca dari atas ke bawah dan dilanjut membaca ke kolom selanjutnya.
//         for ($l=2; $l <= $total_row; $l++){
//             $coordinate = $reader->getActiveSheet()->getCellCollection()->getCurrentColumn().$l;
//             echo $reader->getActiveSheet()->getCell($coordinate)->getValue();
//             echo "\n";
//         }

//         $no_index++;
//     }
    
// }

// $coordinate = $reader->getActiveSheet()->getCellCollection()->getCoordinates();
// for ($i=0; $i < sizeof($coordinate); $i++){
//     // $query = "insert into data_siswa values ('', '', '', '',)";
//     echo $reader->getActiveSheet()->getCell($coordinate[$i++])->getValue()."\n";
// }
$data = $reader->getActiveSheet()->toArray();

// for ($i=0; $i < sizeof($data); $i++){
    
//     if ($data[$i] != null){
//         print_r($data[$i]);
//     }
// }
$index_of = array();
$query = array();
$no_urut = 1;

foreach ($data as $key => $value){
    
    if ($value != null){
        $index_of['id_kelas'] = array_search('id_kelas', $value);
        $index_of['nama'] = array_search('nama', $value);
        $index_of['semester'] = array_search('semester', $value);
        $index_of['jenis_kelamin'] = array_search('jenis_kelamin', $value);
        $index_of['ttl'] = array_search('ttl', $value);
        $index_of['kota'] = array_search('kota', $value);
        $index_of['no_hp'] = array_search('no_hp', $value);
        $index_of['nm_no'] = array_search('nm_no', $value);
        $index_of['alamat'] = array_search('alamat', $value);
        break;
    }

}

// $index_of['nis'] = array_search('nis', $data[0]);
// $index_of['nama'] = array_search('nama', $data[0]);
// $index_of['jenis_kelamin'] = array_search('jenis_kelamin', $data[0]);
// $index_of['ttl'] = array_search('ttl', $data[0]);
// $index_of['kota'] = array_search('kota', $data[0]);


foreach($data as $key => $value){

    if ($key == 0){
        continue;
    }
    if ($value != null){
        $duaDigitTahun = substr(date_format(date_create($value[$index_of['ttl']]), "Y"), 2);
                $no_urutSiswa = sprintf('%03d', $no_urut++);
                $query[$no_index++] = "insert into data_siswa values ('".$duaDigitTahun."26363".$no_urutSiswa."', 
                '".$value[$index_of['id_kelas']]."', '".$value[$index_of['nama']]."', 
                '".$value[$index_of['semester']]."', '".$value[$index_of['jenis_kelamin']]."', 
                '".$value[$index_of['ttl']]."', '".$value[$index_of['kota']]."', 
                '".$value[$index_of['no_hp']]."', '".$value[$index_of['nm_no']]."', 
                '".$value[$index_of['alamat']]."')";
    }
}

var_dump($query);

// print_r($total_column);
// for ($l=2; $l <= $total_row; $l++){
//     for ($k=1; $k <= 6; $k++){
//         echo $coordinateColumn[$l].strval($k);
//     }
//     // echo $reader->getActiveSheet()->getCell($coordinateColumn[$i+1].strval($l))->getValue();
//     // echo "\n";
// }

// var_dump($reader->getActiveSheet()->getHighestDataColumn(6));
// var_dump($reader->getActiveSheet()->getCellCollection()->getHighestRow());

// while($reader->getActiveSheet()->getCellCollection()->getHighestColumn() != null){
//     var_dump($reader->getActiveSheet()->getCellCollection()->getHighestColumn());
// }