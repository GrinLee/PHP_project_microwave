<?php 
session_start();
require_once("../db_connect.php");
$db_conn = db_conn();

$table = $_SESSION['table_name'];
$temp = explode("_", $table);
$id = $temp[0]."_id";
if(isset($_POST['pathNo'])){
	$no = $_POST['pathNo'];
}

if($_SERVER['REQUEST_METHOD'] == "POST"){

	$error_msg = formValidation();

    	if (count($error_msg) > 0){
		display_error($error_msg);
		echo "<script>history.back(-1);</script>";

	}else{

		if(isset($_POST['pFrequency'])){
			$pFrequency = $db_conn->real_escape_string(trim($_POST['pFrequency']));
			$pDescript = $db_conn->real_escape_string(trim($_POST['pDescript']));
			$pnote = $db_conn->real_escape_string(trim($_POST['pnote']));

			$qry = "UPDATE $table SET path_frequency = '$pFrequency',
				path_description = '$pDescript', path_note = '$pnote';";
			$result = $db_conn->query($qry);
			var_dump($result);
			
			if($result){

				echo "<script>alert(\"Updating was successful\");</script>";
				echo "<script>history.back(-1);</script>";
			}else{
				echo "<script>alert(\"Updating was failed\");</script>";
				echo "<script>history.back(-1);</script>";
			}
		}else if(isset($_POST['eGHeight'])){
			$eGHeight = $db_conn->real_escape_string(trim($_POST['eGHeight']));
			$eAHeight = $db_conn->real_escape_string(trim($_POST['eAHeight']));

			$qry = "UPDATE $table SET end_ground_height = '$eGHeight',
					end_antenna_height = '$eAHeight' WHERE $id = '$no';";

			$result = $db_conn->query($qry);
			if($result){

				echo "<script>alert(\"Updating was successful\");</script>";
				echo "<script>history.back(-1);</script>";
			}else{
				echo "<script>alert(\"Updating was failed\");</script>";
				echo "<script>history.back(-1);</script>";
			}
		}else if(isset($_POST['mGHeight'])){
			$mGHeight = $db_conn->real_escape_string(trim($_POST['mGHeight']));
			$mTType = $db_conn->real_escape_string(trim($_POST['mTType']));
			$mOHeigt = $db_conn->real_escape_string(trim($_POST['mOHeigt']));
			$mOType = $db_conn->real_escape_string(trim($_POST['mOType']));

			$qry = "UPDATE $table SET mid_ground_height = '$mGHeight', 
						mid_terrain_type = '$mTType', mid_obstruction_height = '$mOHeigt',
						mid_obstruction_type = '$mOType' WHERE $id = '$no'; ";
			$result = $db_conn->query($qry);
			if($result){

				echo "<script>alert(\"Updating was successful\");</script>";
				echo "<script>history.back(-1);</script>";
			}else{
				echo "<script>alert(\"Updating was failed\");</script>";
				echo "<script>history.back(-1);</script>";
			}
		}
	}
}


function formValidation(){
	$err_msgs = array();

//	check the valid data of path info
	if(isset($_POST['pFrequency'])){

		if(!isset($_POST['pFrequency'])){
			$err_msgs[] = "No contact type specified";	
		}else{
			$pFrequency = trim($_POST['pFrequency']);
			if(strlen($pFrequency) == 0){
				$err_msgs[] = "The path frequency file must not be empty";
			}else{
				if(preg_match("/[0-9]+/", $pFrequency) == false){
					$err_msgs[] = "Only allow number";
				}
			}
		}

		if(!isset($_POST['pDescript'])){
			$err_msgs[] = "No contact type specified";	
		}else{
			$pDescript = trim($_POST['pDescript']);
			if(strlen($pDescript) == 0){
				$err_msgs[] = "The path Description file must not be empty";
			}else if(strlen($pDescript) > 255){
				$err_msgs[] = "The path Description file is too long";
			}
		}

		if(!isset($_POST['pnote'])){
			$err_msgs[] = "No contact type specified";	
		}else{
			$pnote = trim($_POST['pnote']);
			if(strlen($pnote) == 0){
				$err_msgs[] = "The path Description file must not be empty";
			}
		}
	}

//	check the valid data of end point
	if(isset($_POST['eGHeight'])){

		if(!isset($_POST['eGHeight'])){
			$err_msgs[] = "No contact type specified";	
		}else{
			$eGHeight = trim($_POST['eGHeight']);
			if(strlen($eGHeight) == 0){
				$err_msgs[] = "The ground height file must not be empty";
			}else{
				if(preg_match("/[0-9]+/", $eGHeight) == false){
					$err_msgs[] = "Only allow number";
				}
			}
		}

		if(!isset($_POST['eAHeight'])){
			$err_msgs[] = "No contact type specified";	
		}else{
			$eAHeight = trim($_POST['eAHeight']);
			if(strlen($eAHeight) == 0){
				$err_msgs[] = "The antenna height file must not be empty";
			}else{
				if(preg_match("/[0-9]+/", $eAHeight) == false){
					$err_msgs[] = "Only allow number";
				}
			}
		}
	}

//	check the valid data of mid point
	if(isset($_POST['mGHeight'])){

		if(!isset($_POST['mGHeight'])){
			$err_msgs[] = "No contact type specified";	
		}else{
			$mGHeight = trim($_POST['mGHeight']);
			if(strlen($mGHeight) == 0){
				$err_msgs[] = "The ground height file must not be empty";
			}else{
				if(preg_match("/[0-9]+/", $mGHeight) == false){
					$err_msgs[] = "Only allow number";
				}
			}
		}

		if(!isset($_POST['mTType'])){
			$err_msgs[] = "No contact type specified";	
		}else{
			$mTType = trim($_POST['mTType']);
			if(strlen($mTType) == 0){
				$err_msgs[] = "The terrain type file must not be empty";
			}else if(strlen($mTType) > 50){
				$err_msgs[] = "The terrain type file is too long";
			}
		}

		if(!isset($_POST['mOHeigt'])){
			$err_msgs[] = "No contact type specified";	
		}else{
			$mOHeigt = trim($_POST['mOHeigt']);
			if(strlen($mOHeigt) == 0){
				$err_msgs[] = "The obstruction height file must not be empty";
			}else{
				if(preg_match("/[0-9]+/", $mOHeigt) == false){
				$err_msgs[] = "Only allow number";
			}
			}
		}

		if(!isset($_POST['mOType'])){
			$err_msgs[] = "No contact type specified";	
		}else{
			$mOType = trim($_POST['mOType']);
			if(strlen($mOType) == 0){
				$err_msgs[] = "The obstruction type file must not be empty";
			}else if(strlen($mOType) > 50){
				$err_msgs[] = "The obstruction type  file is too long";
			}
		}
	}
	return $err_msgs;
}	

function display_error($error_msg){
	
	echo "<p>\n";
		foreach($error_msg as $v){
			//echo $v."<br>\n";
			echo "<script>alert(\"$v.\");</script>";
		}
	echo "</p><br>\n";
}

?>