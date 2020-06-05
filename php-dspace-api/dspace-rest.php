<?php
//ini_set('display_errors', 0);
//ini_set('display_startup_errors', 0);
//error_reporting(E_ALL);

$author_array=explode("\r\n",file_get_contents('./scopus-jornal.csv'));


foreach ($author_array as $value)
{
	$authors_t[explode('|||',$value)[0]]=explode('|||',$value)[1];
}

function deleteItem($url, $cookie) {
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_COOKIE, $cookie);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
	curl_setopt($ch, CURLOPT_URL, $url);
	$data = curl_exec($ch);
	curl_close($ch);
	return $data;
	
}

function editItem($url,$params, $cookie) {
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_COOKIE, $cookie);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
	curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
	curl_setopt($ch, CURLOPT_URL, $url);
	$data = curl_exec($ch);
	curl_close($ch);
	return $data;
	
}


function deleteBitstream($url, $cookie) {
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_COOKIE, $cookie);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
	curl_setopt($ch, CURLOPT_URL, $url);
	$data = curl_exec($ch);
	curl_close($ch);
	return $data;
	
}

function getBitstream($url, $cookie) {
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_COOKIE, $cookie);
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$data = curl_exec($ch);
	curl_close($ch);
//print_r(json_decode($data,true));
	return json_decode($data,true);
	
}

function postBitstream($url, $fileName,$cookie) {

if (!file_exists('file/'.$fileName)) { return false;}
	$c = curl_init($url);
	$params["file"] = new CurlFile('file/'.$fileName);
	$options = array(	
		CURLOPT_HTTPHEADER => array("Accept: application/json"),
		CURLOPT_POST => true,
		CURLOPT_POSTFIELDS => $params,
		CURLOPT_RETURNTRANSFER => true,
	);

		$options[CURLOPT_COOKIE] = $cookie;
	
	curl_setopt_array($c, $options);
	$response = curl_exec($c);
	$http_code = curl_getinfo($c, CURLINFO_HTTP_CODE);
	curl_close($c);
	//print_r($response);
	if ($http_code == 200) {
		echo '<br> do _upload<br>';
		return json_decode($response);
	} else {
		return false;
	}
}


function postMetadata($url,$metadata,$cookie) 
{
	$c = curl_init($url);
	$options = array(	
		CURLOPT_HTTPHEADER => array("Content-Type: application/json"),
		CURLOPT_POST => true,
		CURLOPT_POSTFIELDS => $metadata,
		CURLOPT_RETURNTRANSFER => true,
	);
 $options[CURLOPT_USERAGENT]= "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.0)"; 
		$options[CURLOPT_COOKIE] = $cookie;
	
	curl_setopt_array($c, $options);
	$response = curl_exec($c);
	$http_code = curl_getinfo($c, CURLINFO_HTTP_CODE);
	curl_close($c);
	//print_r($response);
	if ($http_code == 200) {
		echo '<br> add metadata<br>';
		return json_decode($response);
	} else {
		return false;
	}
}




function get_data_curl($url) {

	
	$ch = curl_init();
	$timeout = 30;
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
	curl_setopt($ch,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.117 Safari/537.36');
	$data = curl_exec($ch);
	curl_close($ch);
	return $data;
}

$ch = curl_init(); 
    curl_setopt($ch, CURLOPT_URL, "https://scidar.kg.ac.rs/rest/login"); 
	curl_setopt($ch, CURLOPT_POST, 1);
    //curl_setopt($ch, CURLOPT_USERPWD, urlencode('imi.servis@gmail.com').':'.urlencode('!dspaceclean'));
	curl_setopt($ch, CURLOPT_POSTFIELDS,"email=".urlencode('mail_admin_korisnika')."&password=".urlencode('lozinka'));
   // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); 
    //curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2); 
    curl_setopt($ch, CURLOPT_HEADER, 1); 
    curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.0)"); 
	curl_setopt($ch, CURLOPT_RETURNTRANSFER,1); 
    $result =curl_exec ($ch);
preg_match_all('/^Set-Cookie: (.*?);/m', $result, $m);
//print_r($m[1]);
foreach ($m[1] as $key => $child) 
{


//echo $child;
;
}
curl_close($ch);


//print_r( postBitstream('https://scidar.kg.ac.rs/rest/items/299236cc-c82a-4402-ab20-39d68c09007d/bitstreams?name=misa.pdf','misa.pdf', $child));
//exit();

$ch = curl_init(); 
//master
//ab56d0d3-f88c-422f-9450-bbf507813a7f
//Primary research outputs
//484b3bcb-b857-41be-a5fc-ad91712e368a
//offset=100&limit=900
curl_setopt($ch, CURLOPT_URL, "https://scidar.kg.ac.rs/rest/collections/484b3bcb-b857-41be-a5fc-ad91712e368a/items?offset=2000&limit=1010"); 
curl_setopt($ch, CURLOPT_COOKIE, $child);
curl_setopt($ch, CURLOPT_RETURNTRANSFER,1); 
$result_new=curl_exec($ch);
//print_r($result_new);

	curl_close($ch);
$result_array=json_decode($result_new,true);
$ch = curl_init(); 
foreach ($result_array as $entry) 
{
echo '<br>========================<br>'	;
//print_r($entry);
	//echo $entry['uuid'].'';

//'[{"key":"dc.relation.ispartof", "value":"Journal", "language": null}]'


	
	
//	brisanje kolekcije
if (false)
{	
deleteItem('https://scidar.kg.ac.rs/rest/items/'.$entry['uuid'],$child);
continue;
}
//off
curl_setopt($ch, CURLOPT_URL, "https://scidar.kg.ac.rs/rest/items/".$entry['uuid']."/metadata"); 
curl_setopt($ch, CURLOPT_COOKIE, $child);
curl_setopt($ch, CURLOPT_RETURNTRANSFER,1); 
$result_new=curl_exec($ch);
$result_array_item=json_decode($result_new,true);


if (false)
{	
$bitstreem_id=getBitstream('https://scidar.kg.ac.rs/rest/items/'.$entry['uuid'].'/bitstreams',$child)[0]['uuid'];
if (empty($bitstreem_id) )
{	
echo "<br>delete<br>";
//deleteItem('https://scidar.kg.ac.rs/rest/items/'.$entry['uuid'],$child);
//echo 'https://scidar.kg.ac.rs/rest/bitstreams/'.$bitstreem_id;
//print_r(deleteBitstream('https://scidar.kg.ac.rs/rest/bitstreams/'.$bitstreem_id,$child));
continue;	
}
continue;
}
//print_r($result_array_item);
$n_of_authors=0;
foreach ($result_array_item as $entry_item) 
{
	
	
	if ($entry_item['key']=='dc.contributor.author')
	{	
$n_of_authors=$n_of_authors+1;
	}
	if (false)
	{	
	if ($entry_item['key']=='dc.identifier.doi')
	//if ($entry_item['key']=='dc.identifier.scopus')
	//if ($entry_item['key']=='dc.identifier.uri')
	{ 
		//echo '<br>'$entry_item['value'].' do _upload<br>';
		$filename = str_replace('/', '-', $entry_item['value']).'.pdf';
		//echo str_replace(':18080/jspui','',$entry_item['value']).'<br>';
		//editItem('https://scidar.kg.ac.rs/rest/items/'.$entry['uuid'].'/metadata','[{"key":"dc.identifier.uri", "value":"'.str_replace(':18080/jspui','',$entry_item['value']).'", "language": null}]', $child);
			//if (in_array($filename,$bad_array)) 
	//{	
//echo "<br>obrisi<br>";
	//deleteBitstream('https://scidar.kg.ac.rs/rest/items/'.$entry['uuid'].'/bitstreams/'.$bitstreem_id,$child);
	//}	
	
//add metadata
if (false)
{	
echo $authors_t[$entry_item['value']];
if ($authors_t[$entry_item['value']]!='') 
{	
	if (postMetadata('https://scidar.kg.ac.rs/rest/items/'.$entry['uuid'].'/metadata','[{"key":"dc.relation.ispartof", "value":"'.$authors_t[$entry_item['value']].'", "language": null}]',$child)==false) echo '<br>not ok.<br>';
}
}	
	if (postBitstream('https://scidar.kg.ac.rs/rest/items/'.$entry['uuid'].'/bitstreams?name='.urlencode($filename),$filename, $child)) {echo 'ok<br>';} else {echo 'not ok.<br>';};
	}
	
}	

}
if ($n_of_authors>50) 
{;
	//echo $entry['uuid'].'<br>';
	//deleteItem('https://scidar.kg.ac.rs/rest/items/'.$entry['uuid'],$child);
}
	
	
}	

curl_close($ch);

echo 'end';
?>
