<?php
die; 
ini_set('memory_limit','-1');
ini_set('max_execution_time', '0');
$servername = "127.0.0.1";
$username = "zapbolib_hotel";
$password = "z]muycBfGuol";
$dbname = "zapbolib_hotel";
$conn = mysqli_connect($servername, $username, $password, $dbname);
if (mysqli_connect_errno()) {
    die("Connection failed: " . mysqli_connect_error());
} 
$data = '/home1/zapbolib/public_html/public/dump/'.$_POST['file'];

$handle = fopen($data, "r");
$test = file_get_contents($data);
   
if ($handle) {
    $counter = 0;
    //instead of executing query one by one,
    //let us prepare 1 SQL query that will insert all values from the batch
   // $sql ="insert into grnhotels(hotel_code, name, description, longitude, latitude, city_code,category, address,zip,atype, slug,dcode, created_at, updated_at,country) VALUES ";
    $sqls ="insert into hotel_locations(h_code, l_code, c_code, created_at, updated_at) VALUES ";
    while (($line = fgets($handle)) !== false) {
		$sqls .= "($line),";
		 
		  $counter++;
		
	}
	
     // $sql = substr($sql, 0, strlen($sql) - 1); 
     $sqls = substr($sqls, 0, strlen($sqls) - 1); 
	 
	  mysqli_query($conn, $sqls);
    /*  if (mysqli_query($conn, $sql) === TRUE) {
    } else {
     }  */
	 echo("Error description: " . mysqli_error($conn));
    fclose($handle);
} else {  
} 
//unlink CSV file once already imported to DB to clear directory
unlink($data);
?>