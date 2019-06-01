<?php  
function db_conn(){
	$db_conn = new mysqli('localhost', 'group7', '!group7User', 'microwave');
	if ($db_conn->connect_errno) {
	  	 printf ("Could not connect to database server \n Error: ".$db_conn->connect_errno ."\n Report: ".$db_conn->connect_error."\n");
	}else{
		return $db_conn;
	}

}
?>