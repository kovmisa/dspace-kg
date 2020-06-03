<?php 
require_once("vendor/autoload.php"); 

/* Start to develop here. Best regards https://php-download.com/ */

$author_array=explode("\r\n",file_get_contents('./list_files.txt'));
foreach ($author_array as $value)
{
	echo $value.'<br><br>';


$reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReaderForFile('./excell/'.$value);
$reader->setReadDataOnly(true);
$spreadsheet = $reader->load('./excell/'.$value);
$all = $spreadsheet->getSheetNames();
for ($x = 1; $x < count($all); $x+=1) {
    echo "The number is: $all[$x] <br>";
	$spreadsheet_f=$spreadsheet->getSheet($x)->toArray();
	
$highestRow = $spreadsheet->getSheet($x)->getHighestRow();
echo '<br><br>'.$highestRow.'<br><br>';
  	for ($i_red = 4; $i_red < $highestRow; $i_red++) 
{
	//echo trim($spreadsheet_f[$i_red][8 ]).'<br>';
	if (trim($spreadsheet_f[$i_red][8 ])!='' and trim($spreadsheet_f[$i_red][10 ])!='') 
	{
	echo trim($spreadsheet_f[$i_red][8 ]).','.trim($spreadsheet_f[$i_red][10 ])."<br>";
	file_put_contents('./sifre.csv',trim($spreadsheet_f[$i_red][8 ]).','.trim($spreadsheet_f[$i_red][10 ])."\r\n", FILE_APPEND);
	}
}
	
	
} 



//print_r($all);

}