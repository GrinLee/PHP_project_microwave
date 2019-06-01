<?php  
function formReset(){
$db_conn = db_conn();

$qry = "SELECT file_name from fileInfo;";
$result = $db_conn->query($qry);
?>

<div>
	<form method="POST">
		<label id="lb01">Choose path to reset</label>
		<select id="myList" onchange="window.location='index.php?reset='+this.value">
			<option>path data</option>
			<?php 
			if ($result->num_rows > 0){
			 	while ($row = $result->fetch_assoc()){
			   	foreach($row as $k=>$v){
			   		$path = $v;
			   		$path = explode(".", $path);
			   		$path = $path[0];
						print "<option>".$path."</option>";
					}
			   }
			} else {
				echo "Nothing to output\n";
			}
			?>
		</select>&nbsp;&nbsp;&nbsp;
		<input type="submit" name="button" value="main menu">
	</form>
</div>
<div>
<?php
	if(isset($_SESSION['reset'])){
		$table = $_SESSION['reset'];
		$fileName = $table . '.csv';

		$qry1 = "Drop table $table;";
		$result1 = $db_conn->query($qry1);
	   $qry2 = "DELETE FROM fileInfo WHERE file_name = '$fileName';";
	   $result2 = $db_conn->query($qry2);

	   if ($result1 && $result2){
	      echo "<br/><h4>Success deleting the path data</h4>";
		} else {
			echo "<br/><h4>Fail deleting the path data</h4>";
		}
	}
?>	
</div>
<?php
}
?>