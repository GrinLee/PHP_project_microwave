<?php  
function formShowAll(){
	$db_conn = db_conn();
	$table = $_SESSION['path']; // this parameter is table name.
	$qry = "SELECT * FROM path_$table;";
	$result = $db_conn->query($qry);
	$row = $result->fetch_assoc();
?>
<div>
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
	</table>
</div>
<?php
	// bring the pathe data using the sent table name
	$qry = "SELECT * FROM end_$table;";
	$result = $db_conn->query($qry);
?>
<div>
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
</div>
<?php
}
?>