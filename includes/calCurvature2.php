<?php 
function formResultCalculation(){
include('phpgraphlib-master/phpgraphlib.php');
$db_conn = db_conn();
if(isset($_SESSION['path'])){
	$table = $db_conn->real_escape_string(trim($_SESSION['path']));
	$factor = $db_conn->real_escape_string(trim($_SESSION['factor']));
}

// calculate Fghz value
$qry = "SELECT * FROM path_$table;";
$result = $db_conn->query($qry);
$row = $result->fetch_assoc();
$Fghz = $row['path_frequency'];

// calculate D value
$qry = "SELECT * FROM end_$table ORDER BY end_id DESC limit 1;";
$result = $db_conn->query($qry);
$row = $result->fetch_assoc();
$D = $row['end_distance'];

//calculate Path Attenuation(PA)
$PA = 92.4 + (20*log($Fghz, 10)) +(20*log($D,10)) ;

// calculate h, F1, ApparentGroundHeight, and TotalApparentHeigh value for each curvature factor
$h = array();
$F1 = array();
$appGroundHeight = array();
$totalAppHeight = array();

$qry = "SELECT * FROM mid_$table;";
$result = $db_conn->query($qry);
if ($result->num_rows > 0){
 	while ($row = $result->fetch_assoc()){ 
 		$d1 = $row['mid_distance'];

 		if($factor == '4/3'){
 			$c = 17;
 		}else if($factor == '1'){
 			$c = 12.75;
 		}else if($factor == '2/3'){
 			$c = 8.5;
 		}
 		// calculta h value
 		if($factor == "infinity"){
 			$hh =0;
 		}else{
 			$hh = ($d1*($D-$d1))/$c;
 		}
 		// calculate F1 value
 		$f1 = ($d1*($D-$d1))/($Fghz*$D);
 		$f1 = 17.3*sqrt($f1);
 		// calculate ApparentGroundHeight and TotalApparentHeigh value
 		$AGH = $row['mid_ground_height'] + $row['mid_obstruction_height'] + $hh;
 		$TAH = $AGH + $f1;

 		array_push($h, round($hh, 4));
 		array_push($F1, round($f1, 4));
 		array_push($appGroundHeight, round($AGH, 4));
 		array_push($totalAppHeight, round($TAH, 4));
	}

// create the graph
/*
$graph = new PHPGraphLib(650,200);
$graph->addData($h, $appGroundHeight, $F1);
$graph->setTitle('PPM Per Container');
//$graph->setTitle($table.' with curvature '.$factor);
$graph->setBars(false);
$graph->setLine(true);
$graph->setDataPoints(true);
$graph->setDataPointColor('maroon');
$graph->setDataValues(true);
$graph->setDataValueColor('maroon');
$graph->setGoalLine(.0025);
$graph->setGoalLineColor('red');
$graph->createGraph();
*/
}

?>
<div>
	<h3>Calculation Result of <font color="blue"><?php echo $table ;?></font> for a curvature of <font color="blue"><?php echo $factor; ?></font></h3>
	<form method="POST">
		<input type="submit" name="button" value="main menu">&nbsp;
		<input type="submit" name="button" value="calculation list">
	</form><br/>
	<h5>Path Attenuation(dB): <?php echo round($PA, 1); ?></h5>
</div><br/>
<?php
// Create path, end, mid tables

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
	</table><br/>
</div>
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
			<td>Curvature Height</td>
			<td>Apparent Ground and Obstruction Height</td>
			<td>1st Freznel Zone</td>
			<td>Total Clearance Height</td>
		</tr>
		<?php 
			if ($result->num_rows > 0){
				$c = 0;
			 	while ($row = $result->fetch_assoc()){ ?>
			 		<tr>
	       			<td><?php echo $row['mid_distance']; ?></td>
	       			<td><?php echo $row['mid_ground_height']; ?></td>
	       			<td><?php echo $row['mid_terrain_type']; ?></td>
	       			<td><?php echo $row['mid_obstruction_height']; ?></td>
	       			<td><?php echo $row['mid_obstruction_type']; ?></td>
	       			<td><?php echo $h[$c]; ?></td>
	       			<td><?php echo $appGroundHeight[$c]; ?></td>
	       			<td><?php echo $F1[$c]; ?></td>
	       			<td><?php echo $totalAppHeight[$c]; ?></td>
	       		</tr>
			<?php 
					$c++;
				}
			}
		?>
	</table><br/>
</div>	
<?php
   }
}
?>