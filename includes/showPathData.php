<?php  
function formShowPath(){
	$db_conn = db_conn();
	$table = $_SESSION['table_name'];
	$qry = "SELECT * FROM $table;";
	$result = $db_conn->query($qry);
	$row = $result->fetch_assoc();

	if($_SESSION['path_menu'] == "path"){
?>
	<h3>Path Information</h3>
	<form method="POST" action="includes/updatePath.php">
	<table>
		<tr>
			<td><b>Path Name</b></td>
			<td>	<?php echo $row['path_name']; ?>	</td>
		</tr>
		<tr>
			<td><b>Frequency</b></td>
			<td>	<input type="text" name="pFrequency" value="<?php echo $row['path_frequency']; ?>">
			</td>
		</tr>
		<tr>
			<td><b>Description</b></td>
			<td>	<input type="text" name="pDescript" value="<?php echo $row['path_description']; ?>">
			</td>
		</tr>
		<tr>
			<td><b>Note</b></td>
			<td>	<input type="text" name="pnote" value="<?php echo $row['path_note']; ?>">
			</td>
		</tr>
	</table>
	<input type="submit" name="eidt" value="edit path">
	</form>
<?php 
	}else if($_SESSION['path_menu'] == "end"){
 ?>
	<h3>Endpoint Information</h3>
	<table>
		<tr>
			<td>Distance From Start End Point</td>
			<td>Ground Height</td>
			<td>Antenna Type</td>
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
<?php 
	}else if($_SESSION['path_menu'] == "mid"){
 ?>
	<h3>Midpoint Information</h3>
	<table>
		<tr>
			<td>Distance From Start End Point</td>
			<td>Ground Height</td>
			<td>Antenna Type</td>
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
<?php
	}
}
?>