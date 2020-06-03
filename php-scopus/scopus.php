<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);



require 'Scopus/Guzle/autoload.php';
require 'Scopus/SearchQuery.php';
require 'Scopus/ScopusApi.php';
require 'Scopus/Response/SearchResults.php';
require 'Scopus/Response/BaseLinks.php';
require 'Scopus/Response/EntryLinks.php';
require 'Scopus/Response/AbstractCoredata.php';
require 'Scopus/Response/IAbstract.php';

require 'Scopus/Response/Entry.php';
require 'Scopus/Response/Abstracts.php';
require 'Scopus/Response/IAuthorName.php';
require 'Scopus/Response/IAuthor.php';
require 'Scopus/Response/AuthorName.php';
require 'Scopus/Response/EntryAuthor.php';
require 'Scopus/Response/AuthorProfile.php';

require 'Scopus/Response/Author.php';
require 'Scopus/Response/Affiliation.php';
use Scopus\ScopusApi;

function get_data_curl($url) 
{

	$url=str_replace(' ','%20',$url);
	$ch = curl_init();
	$timeout = 5;
	//curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false);
	
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
	curl_setopt($ch,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.117 Safari/537.36');
	$data = curl_exec($ch);
	curl_close($ch);
	return $data;
}
function downloadPDF($source,$filename)
{
	$source=str_replace(' ','%20',$source);
if (file_exists("./file/".$filename)) { echo 'file exists.<br>';return true;}
$timeout = 30;	
$ch = curl_init();
curl_setopt($ch, CURLOPT_COOKIESESSION, 1);
curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookie.txt');
curl_setopt($ch, CURLOPT_COOKIEFILE, 'cookie.txt');
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.0)"); 
curl_setopt($ch, CURLOPT_URL, $source);
curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
//curl_setopt($ch, CURLOPT_SSLVERSION,3);
$data = curl_exec ($ch);
$error = curl_error($ch); 
if( isset($error)) print_r($error);

$type=curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
if (substr(strtolower($type),0,15)!='application/pdf') 
{	
echo '<br>'.$type.'<br>';
$filename=$filename.'.html';
}
curl_close ($ch);

$destination = "./file/".$filename;
$file = fopen($destination, "w+");
fputs($file, $data);
fclose($file);
}

if (false)
{
$author_array=explode("\r\n",file_get_contents('./file/bad/listmyfolder.txt'));
foreach ($author_array as $value)
{
	
	$value=str_replace('.pdf','',$value);
	$haystack=$value;
	$needle="-";
	$pos = strpos($haystack, $needle);
if ($pos !== false) {
    $newstring = substr_replace($haystack, '/', $pos, strlen($needle));
}

	$valuee=$newstring;
	

	$unpaywall='https://api.unpaywall.org/v2/'.$valuee.'?email=YOUR_EMAIL';
	echo $unpaywall.'<br>';
	$unpaywall_array=json_decode(get_data_curl($unpaywall),true);
	$pdf_link=$unpaywall_array['best_oa_location']['url_for_pdf'];
	$filename=$value.'.pdf';
	echo $pdf_link.'<br>';
	if ($pdf_link!='') {downloadPDF($pdf_link,$filename);} else {$filename="";}
	echo "<br>==========================================================<br>";
	
	
	
}
echo "end";
exit();
	
}





$author_array=explode("\r\n",file_get_contents('./authors.csv'));
foreach ($author_array as $value)
{
	$authors_t[explode('|',$value)[0]]=explode('|',$value)[1];
}



//vec ubaceni radovi
//-------------------------------------------------
$author_array=explode("\r\n",file_get_contents('output0-5000.csv'));
foreach ($author_array as $value)
{
	$scopus_array=explode("\",\"",$value);
	
	//echo $scopus_array[8].'<br>';
$finished_scopus_id[]=$scopus_array[8];

}
//echo "end";
//exit();
//-------------------------------




//print_r($authors_t);



//require './vendor/autoload.php';

// replace with your API key
$apiKey = "1c82792e8ef68e468cc8aa55a5a32ad9";
//branko novi sad key
//$apiKey = "2af9ded2f6e1b20cfb33af2333cfffcd";
//missa2
$apiKey = "aecc0a5e546c4d85b40469fd3d3f934c";
//missa3
$apiKey = "433442e57c3cd39acb9069c69e521709";
$id_colection="123456789/7294";

$api = new ScopusApi($apiKey);
file_put_contents('./output.csv','"id","collection","dc.title","dc.description.abstract","dc.identifier.doi","dc.identifier.issn","dc.contributor.author","dc.type","dc.identifier.scopus","dc.date.issued"'."\r\n");

// Scopus Search API
//199 milosev rad
for ($x = 0; $x <= 5000; $x=$x+10)
{
$results = $api
    ->query("AF-ID(60068809)")
    ->start($x)
    ->count(10)
    ->viewComplete()
    ->search();

//var_dump($results);
$i=0;
foreach ($results->getEntries() as $entry) {
	
	if (in_array($entry->getScopusId(),$finished_scopus_id)) continue;
    $abstractUrl = $entry->getLinks()->getSelf();
	//var_dump($entry);
	
    echo $abstractUrl."<br>";
    // Abstract Retrieval API
   // $abstract = $api->retrieve($abstractUrl);
	//var_dump($abstract);

	
    echo $entry->getTitle()."<br>";
	
	echo $entry->getJornal()."<br>";
	if (false)
	{	
	file_put_contents('./scopus-jornal.csv',$entry->getScopusId().'|||'.$entry->getJornal()."\r\n", FILE_APPEND);
	continue;
	}
	//echo $entry->getDoi()."<br>";
	//echo $entry->getIdentifier()."<br>";
	//echo $entry->getCoverDisplayDate()."<br>";
	echo $entry->getCoverDate()."<br>";
	
	//echo $entry->publicationItemIndifier()."<br>";
	//echo $entry->getIssn()."<br>";
	//echo $entry->getDescription()."<br>";
	//echo $entry->getAuthkeywords()."<br>";
	//echo $entry->getSubtypeDescription()."<br>";
	//echo print_r($entry->getAffiliations())."<br>";

	$unpaywall='https://api.unpaywall.org/v2/'.$entry->getDoi().'?email=YOUR_EMAIL';
	$unpaywall_array=json_decode(get_data_curl($unpaywall),true);
	//var_dump($unpaywall_array);
	//exit();
	$pdf_link=$unpaywall_array['best_oa_location']['url_for_pdf'];
	$filename=$entry->getDoi().'.pdf';
$filename = str_replace('/', '-', $filename);
	if ($pdf_link!='') {downloadPDF($pdf_link,$filename);} else {$filename="";}
	echo "<br>==========================================================<br>";
	//exit();
    //var_dump($entry);

    $authors = $entry->getAuthors();
	$author_out="";
	$author_orc_id="";
    foreach ($authors as $author) {
        $authorUrl = $author->getUrl();
        //var_dump($author);
		if (!isset($authors_t[$authorUrl]))
		{

        // Author Retrieval API
        $author = $api->retrieve($authorUrl);
        //echo $author->getProfile()->getPreferredName()->getGivenName()." ".$author->getProfile()->getPreferredName()->getSurname()."<br>";
		if ($author->getProfile()->getNameVariants()[0]==null) 
		{	
		$author_temp=$author->getProfile()->getPreferredName()->getIndexedName();
		}
		else
		{
			$author_temp=$author->getProfile()->getNameVariants()[0]->getIndexedName();
		}	

		
		$orcid=$author->getOrcId();
		if ($orcid=="") $orcid="#NODATA#" ;
		$author_orc_id=$author_orc_id.'||'.$orcid;
		$author_out=$author_out.'||'.$author_temp.($orcid=="#NODATA#" ?'':'::'.$orcid.'::600');
		
       // var_dump($author->getProfile()->getNameVariants()[0]->getIndexedName());
	   
		echo "============================================================================<br>";
		
			file_put_contents('./authors.csv',''.$authorUrl.'|'.$author_temp.($orcid=="#NODATA#" ?'':'::'.$orcid.'::600')."\r\n", FILE_APPEND);


		}
		else
		{
			
			//echo '<br>Ok author<br>';
			$author_out=$author_out.'||'.$authors_t[$authorUrl];
		}	
    }
	
	file_put_contents('./output.csv','"+","'.$id_colection.'","'.$entry->getTitle().'","'.$entry->getDescription().'","'.$entry->getDoi().'","'.$entry->getIssn().'","'.$author_out.'","'.$entry->getSubtypeDescription().'","'.$entry->getScopusId().'","'.$entry->getCoverDate()."\"\r\n", FILE_APPEND);
$i=$i+1;
}
}
echo 'end';