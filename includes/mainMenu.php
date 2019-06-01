<?php
function formMenuList(){
?>

<!DOCTYPE html>
<html>
<head>
	<title>Group7 Project_Part 1</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous"> 
	<script type="text/javascript" src="./js/main.js"></script>
	<link href="https://fonts.googleapis.com/css?family=Mukta" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="./css/main.css">
</head>
<body>
	<h2>Part 1</h2>
	<ul>
		<li><a href="index.php?mode=Display">Upload Path Data File</a></li>
		<li><a href="index.php?mode=View">View Path Data</a></li>
		<li><a href="index.php?mode=Reset">Reset Path Data</a></li>
	</ul>

	<h2>Part 2</h2>
	<ul>
		<li><a href="index.php?mode=List">Edit Path Data</a></li>
	</ul>

	<h2>Part 3</h2>
	<ul>
		<li><a href="index.php?mode=ListCal">Calculate Path</a></li>
	</ul>
</body>
</html>
<?php 
}
?>