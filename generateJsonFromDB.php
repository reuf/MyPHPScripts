<?php

$servername = "localhost";
$username = "root";
$password = "root";

// try {
// 	$conn = new PDO("mysql:host=$servername;dbname=test", $username, $password);
// 	echo "Connected successfully";
// } catch(PDOException $e){
// 	echo $e->getMessage();
// }

//connection to the database
$dbhandle = mysql_connect($hostname, $username, $password)
 or die("Unable to connect to MySQL");
echo "Connected to MySQL<br>";

//select a database to work with
$selected = mysql_select_db("test",$dbhandle)
  or die("Could not select test");

$sveSkole = array();

$fetchSkole = mysql_query("SELECT * FROM skola");

while ($row = mysql_fetch_array($fetchSkole, MYSQL_ASSOC)) {
    $jednaSkola['name'] = $row['name'];
    $jednaSkola['value'] = $row['value'];
    $class = $row['class'];

    $fetchNazivInstitucije = mysql_query("SELECT * FROM naziv_institucije WHERE class='" . mysql_real_escape_string($class)."'");
    $naziviInstitucija = array();
    while ($row_1 = mysql_fetch_array($fetchNazivInstitucije, MYSQL_ASSOC)) {
	    $jedanNazivInstitucije['name'] = $row_1['name'];
	    $jedanNazivInstitucije['value'] = $row_1['value'];
	    $class_1 = $row_1['value'];

	    $fetchSpecijalizacija = mysql_query("SELECT * FROM specijalizacija WHERE class='" . mysql_real_escape_string($class_1)."'");
		$specijalizacije = array();
	    while ($row_2 = mysql_fetch_array($fetchSpecijalizacija, MYSQL_ASSOC)) {
		    $jedna_specijalizacija['name'] = $row_2['name'];
		    $jedna_specijalizacija['value'] = $row_2['value'];

		    array_push($specijalizacije,$jedna_specijalizacija);
		}
		$jedanNazivInstitucije['options']=$specijalizacije;
	    array_push($naziviInstitucija,$jedanNazivInstitucije);
	}
    $fetchStrucnaSprema = mysql_query("SELECT * FROM strucna_sprema WHERE class='" . mysql_real_escape_string($class)."'");
    $strucneSpreme = array();
    while ($row_1_1 = mysql_fetch_array($fetchStrucnaSprema, MYSQL_ASSOC)) {
	    $jednaStrucnaSprema['name'] = $row_1_1['name'];
	    $jednaStrucnaSprema['value'] = $row_1_1['value'];
    	array_push($strucneSpreme,$jednaStrucnaSprema);
	}
    $jednaSkola['options'] = $naziviInstitucija;
	$jednaSkola['options2'] = $strucneSpreme;
    array_push($sveSkole,$jednaSkola);
}
$fp = fopen('results.json', 'w');
fwrite($fp, json_encode($sveSkole,JSON_UNESCAPED_UNICODE));
fclose($fp);
echo json_encode($sveSkole);
//$conn->close();
?>
