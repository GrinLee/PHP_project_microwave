<?php  
function formShowPathNo(){
	$db_conn = db_conn();
	$table = $_SESSION['table_name'];
	$no = $_SESSION['path_no'];
	$id = $_SESSION['path_menu'];

	$qry = "SELECT * FROM $table WHERE ".$id."_id = '$no';";
	$result = $db_conn->query($qry);
	$row = $result->fetch_assoc();

	if($_SESSION['path_menu'] == "end"){
 ?>
	<h3>Endpoint Information</h3>
	<form method="POST" action="includes/updatePath.php">
	<table>
		<tr>
			<td>Distance From Start End Point</td>
			<td><?php echo $row['end_distance']; ?></td>
		</tr>
		<tr>
			<td>Ground Height</td>
			<td><input type="text" name="eGHeight" value="<?php echo $row['end_ground_height']; ?>"></td>
		</tr>
		<tr>
			<td>Antenna Type</td>
			<td><input type="text" name="eAHeight" value="<?php echo $row['end_antenna_height']; ?>">
				<input type="hidden" name="pathNo" value="<?php echo $no; ?>"></td>
		</tr>
	</table>
	<div>
		<input type="submit" name="edit" value="Edit End Point">
	</div>
	</form>
<?php 
	}else if($_SESSION['path_menu'] == "mid"){
 ?>
	<h3>Midpoint Information</h3>
	<form method="POST" action="includes/updatePath.php">
	<table>
		<tr>
			<td>Distance From Start End Point</td>
			<td><?php echo $row['mid_distance']; ?></td>
		</tr>
		<tr>
			<td>Ground Height</td>
			<td><input type="text" name="mGHeight" value="<?php echo $row['mid_ground_height']; ?>"></td>
		</tr>
		<tr>
			<td>TerrainType</td>
			<td><input type="text" name="mTType" value="<?php echo $row['mid_terrain_type']; ?>"></td>
		</tr>
		<tr>
			<td>Obstruction Height</td>
			<td><input type="text" name="mOHeigt" value="<?php echo $row['mid_obstruction_height']; ?>"></td>
		</tr>
		<tr>
			<td>Obstruction Type</td>
			<td><input type="text" name="mOType" value="<?php echo $row['mid_obstruction_type']; ?>">
			<input type="hidden" name="pathNo" value="<?php echo $no; ?>"></td>
		</tr>
	</table>
	<div>
		<input type="submit" name="edit" value="Edit Mid Point">
	</div>
	</form>
<?php
	}
}
?>