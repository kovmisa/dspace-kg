<?php 

function randomPassword() {
    $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
    $pass = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < 8; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass); //turn the array into a string
}

require_once("vendor/autoload.php"); 

/* Start to develop here. Best regards https://php-download.com/ */

$author_array=explode("\r\n",file_get_contents('./list_files.txt'));
foreach ($author_array as $value)
{
	//echo $value.'<br><br>';


$reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReaderForFile('./excell/'.$value);
$reader->setReadDataOnly(true);
$spreadsheet = $reader->load('./excell/'.$value);
$all = $spreadsheet->getSheetNames();
for ($x = 1; $x < count($all); $x+=1) {
   // echo "The number is: $all[$x] <br>";
	$spreadsheet_f=$spreadsheet->getSheet($x)->toArray();
	
$highestRow = $spreadsheet->getSheet($x)->getHighestRow();
//echo '<br><br>'.$highestRow.'<br><br>';
  	for ($i_red = 4; $i_red < $highestRow; $i_red++) 
{
	//echo trim($spreadsheet_f[$i_red][8 ]).'<br>';
	if (trim($spreadsheet_f[$i_red][4 ])!='') 
	{
	echo trim($spreadsheet_f[$i_red][3 ]).','.trim($spreadsheet_f[$i_red][1 ]).','.trim($spreadsheet_f[$i_red][4 ])."<br>";
	file_put_contents('./izvrsi-dspace','user --add --email '.trim($spreadsheet_f[$i_red][4 ]).' -g \''.trim($spreadsheet_f[$i_red][3 ]).'\' -s \''.trim($spreadsheet_f[$i_red][1]).'\' --password '.randomPassword()."\n", FILE_APPEND);
	}
}
	
	
} 



//print_r($all);

}