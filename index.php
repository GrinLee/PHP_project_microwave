<?php 
// Group 7 : Kwon, Jaechil / Lee, Kunho / Kim, Joon / Bhavsar, Kunj / Chopra, Rishabh / Goudarzi Boroujerdi, Mozhgan

	session_start(); 
	if (!isset($_SESSION['mode'])){
		$_SESSION['mode'] = "Menu";
	}

	require_once("./includes/addFile.php");
	require_once("./includes/displayForm.php");
	require_once("./includes/listPathData.php"); 
	require_once("./includes/mainMenu.php"); 
	require_once("./includes/showPathData.php"); 
	require_once("./includes/showPathList.php"); 
	require_once("./includes/showPathNo.php");
	require_once("./includes/resetPathData.php");
	require_once("./includes/viewPathList.php");
	require_once("./includes/viewPathCal.php");
	require_once("./includes/calCurvature.php");
	require_once("db_connect.php");
	$db_conn = db_conn();
?>
<!DOCTYPE html>
<html>
<head>
	<title>Group7 Project</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous"> 
	<script type="text/javascript" src="./js/main.js"></script>
	<link href="https://fonts.googleapis.com/css?family=Mukta" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="./css/main.css">
</head>
<body>
<?php
if($_SERVER['REQUEST_METHOD'] == 'GET'){
	// send the path by get method from listPathData.php when a option is selected
	if(isset($_GET['path'])){
		$_SESSION['path'] = $db_conn->real_escape_string(trim($_GET['path']));
	}

	if(isset($_GET['factor'])){
		$_SESSION['factor'] = $db_conn->real_escape_string(trim($_GET['factor']));
	}
	// send the reset by get method from restPathData.php when a option is selected
	if(isset($_GET['reset'])){
		$_SESSION['reset'] = $db_conn->real_escape_string(trim($_GET['reset']));
	}

	// send the path menu by get method from listPathData.php when a menu is chose
	if (isset($_GET['path_menu'])){
		$_SESSION['path_menu'] = $db_conn->real_escape_string(trim($_GET['path_menu']));
	}

	if (isset($_GET['path_no'])){
		$_SESSION['path_no'] = $db_conn->real_escape_string(trim($_GET['path_no']));
	}

	// send the mode by get method from mainMenu.php when a menu is clicked
	if (isset($_GET['mode'])){
		$_SESSION['mode'] = $db_conn->real_escape_string(trim($_GET['mode']));
	}
}

// when click a button, sesstion mode will be changed for showing the button function
if($_SERVER['REQUEST_METHOD'] == 'POST'){
	if (isset($_POST['button']) && ($_POST['button'] == "upload")){
		$_SESSION['mode'] = "Add";
	}else if(isset($_POST['button']) && ($_POST['button'] == "main menu")){
		$_SESSION['mode'] = "Menu";
	}else if(isset($_POST['button']) && ($_POST['button'] == "back uploading file")){
		$_SESSION['mode'] = "Add";
	}else if(isset($_POST['button']) && ($_POST['button'] == "view path data")){
		$_SESSION['mode'] = "View";
	}else if(isset($_POST['button']) && ($_POST['button'] == "reset path data")){
		$_SESSION['mode'] = "Reset";
	}else if(isset($_POST['button']) && ($_POST['button'] == "calculation")){
		$_SESSION['mode'] = "Calculate";
	}else if(isset($_POST['button']) && ($_POST['button'] == "calculation list")){
		$_SESSION['mode'] = "ListCal";
	}
}



if($_SESSION['mode'] == "Add"){ 
	formAddFile();
} else if($_SESSION['mode'] == "View"){ 
	formViewPathData();
} else if($_SESSION['mode'] == "Reset"){ 
	formReset();
} else if($_SESSION['mode'] == "Display"){ 
	formDisplay();
} else if($_SESSION['mode'] == "Menu"){ 
	formMenuList();
} else if($_SESSION['mode'] == "ListCal"){ 
	formViewCalList();
} else if($_SESSION['mode'] == "Calculate"){ 
	formResultCalculation();
} else if($_SESSION['mode'] == "List"){ 
	formListPathData();
}
?>
</body>
</html>