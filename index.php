<?php
//error_reporting(E_ALL);
//ini_set('display_errors', 1);

$data = file_get_contents("https://example.com/index.php"); //url of the html table 
$DOM = new DOMDocument();
	$DOM->loadHTML($data);
	
	$Header = $DOM->getElementsByTagName('th'); //fetches the table head from the html table
	$Detail = $DOM->getElementsByTagName('td'); // feteches the table data from the html table

    //#Get header name of the table
	foreach($Header as $NodeHeader) 
	{
		$aDataTableHeaderHTML[] = trim($NodeHeader->textContent);
	}
	//print_r($aDataTableHeaderHTML); die();

	//#Get row data/detail table without header name as key
	$i = 0;
	$j = 0;
	foreach($Detail as $sNodeDetail) 
	{
		$aDataTableDetailHTML[$j][] = trim($sNodeDetail->textContent);
		$i = $i + 1;
		$j = $i % count($aDataTableHeaderHTML) == 0 ? $j + 1 : $j;
	}
	//print_r($aDataTableDetailHTML); die();
	
	//#Get row data/detail table with header name as key and outer array index as row number
	for($i = 0; $i < count($aDataTableDetailHTML); $i++)
	{
		for($j = 0; $j < count($aDataTableHeaderHTML); $j++)
		{
			$aTempData[$i][$aDataTableHeaderHTML[$j]] = $aDataTableDetailHTML[$i][$j];
		}
	}
	$item = $aTempData; unset($aTempData);
//	print_r($aDataTableDetailHTML); die();
	
	$host = 'localhost';
$user = 'database user';
$pass = 'database password';
$db = 'database name';

$con =  mysqli_connect($host,$user,$pass,$db );
	if (!empty($item)) {
    $values = array();
    foreach($item as $item){
        $values[] = "('{$item['item1']}', '{$item['item2']}')";
    
    }

    $values = implode(", ", $values);

    $sql = "INSERT INTO tablename VALUES {$values};" ;
    echo $sql;
    $result = mysqli_query($con, $sql );
    if ($result) {
        echo 'Successful inserts: ' . mysqli_affected_rows($con);
    } else {
        echo 'query failed: ' . mysqli_error($con);
    }
}
?>