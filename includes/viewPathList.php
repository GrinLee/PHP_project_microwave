<?php 
function formViewPathData(){
$db_conn = db_conn();
// bring file name form fileInfo and then create some options for selection tag using file name.
?>

<div>
	<form method="POST">
		<label id="lb01">Choose path to view</label>
		<!-- when a option is selected, send the selected value to index.php using get method.
			  This value will be saved session
		-->
		<select id="myList" onchange="window.location='index.php?path='+this.value">
			<option>path data</option>
			<?php 
			$qry = "SELECT file_name from fileInfo;";
			$result = $db_conn->query($qry);

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
		<input type="submit" name="button" value="main menu">&nbsp;
		<input type="submit" name="button" value="reset path data">
	</form><br/>
</div>
<div>
<?php
	// bring the data of selected option(path name) from sesssion. 
 	$table = "";
	if(isset($_SESSION['path'])){
		$table = $_SESSION['path'];
	}
	// bring the data from table that is same of selected path name.
	$qry = "SELECT * FROM path_$table;";
	$result = $db_conn->query($qry);
	if ($result){
   	$row = $result->fetch_assoc();
?>
	<h3>Path Information</h3>
	<table>
		<tr>
			<td style="width:150px"><b>Path Name</b></td>
			<td style="width:300px"><?php echo $row['path_name']; ?></td>
		</tr>
		<tr>
			<td><b>Frequency</b></td>
			<td><?php echo $row['path_frequency']; ?></td>
		</tr>
		<tr>
			<td><b>Description</b></td>
			<td><?php echo $row['path_description']; ?></td>
		</tr>
		<tr>
			<td><b>Note</b></td>
			<td><?php echo $row['path_note']; ?></td>
		</tr>
	</table><br/>
<?php 
	$qry = "SELECT * FROM end_$table;";
	$result = $db_conn->query($qry);
 ?>
 	<div>
		<h3>Endpoint Information</h3>
		<table>
			<tr>
				<td>Distance From Start End Point</td>
				<td>Ground Height</td>
				<td>Antenna Height</td>
			</tr>
			<?php 
				if ($result->num_rows > 0){
				 	while ($row = $result->fetch_assoc()){ ?>
				 		<tr>
		       			<td><?php echo $row['end_distance']; ?></td>
		       			<td><?php echo $row['end_ground_height']; ?></td>
		       			<td><?php echo $row['end_antenna_height']; ?></td>
		       		</tr>
				<?php }
				}
			?>
		</table><br/>
	</div>
<?php
	$qry = "SELECT * FROM mid_$table;";
	$result = $db_conn->query($qry);
?>
	<div>
		<h3>Midpoint Information</h3>
		<table>
			<tr>
				<td>Distance From Start End Point</td>
				<td>Ground Height</td>
				<td>Terrian Type</td>
				<td>Obstruction Height</td>
				<td>Obstruction Type</td>
			</tr>
			<?php 
				if ($result->num_rows > 0){
				 	while ($row = $result->fetch_assoc()){ ?>
				 		<tr>
		       			<td><?php echo $row['mid_distance']; ?></td>
		       			<td><?php echo $row['mid_ground_height']; ?></td>
		       			<td><?php echo $row['mid_terrain_type']; ?></td>
		       			<td><?php echo $row['mid_obstruction_height']; ?></td>
		       			<td><?php echo $row['mid_obstruction_type']; ?></td>
		       		</tr>
				<?php }
				}
			?>
		</table><br/>
	</div>
</div>
	
<?php
   }
}
?>