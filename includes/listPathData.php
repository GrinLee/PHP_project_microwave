<?php 
function formListPathData(){
$db_conn = db_conn();
// bring file name form fileInfo and then create some options for selection tag using file name.
?>

<div>
	<form method="POST">
		<label id="lb01">Choose a path to info</label>
		<input type="submit" name="button" value="main menu" style="float:right;"></br>
		<!-- when a option is selected, send the selected value to index.php using get method.
			  This value will be saved session
		-->
		<select id="csvFile" onchange="window.location='index.php?path='+this.value">
			<option>CSV File</option>
			<?php 
			$qry = "SELECT file_name from fileInfo;";
			$result = $db_conn->query($qry);

			if ($result->num_rows > 0){
			 	while ($row = $result->fetch_assoc()){
			   	foreach($row as $k=>$v){
			   		$path = $v;
			   		$path = explode(".", $path);
			   		$path = $path[0];
			   		$_SESSION['file_name'] = $path;
						print "<option>".$path."</option>";
					}
			   }
			} 
		?>
		</select>&nbsp;
		<select id="path_info" onchange="window.location='index.php?path_menu='+this.value">
			<option>Path Data</option>
			<?php
				if(isset($_SESSION['path'])){ 
			?>	
				<option>path</option>
				<option>end</option>
				<option>mid</option>
			<?php } ?>
		</select>

		<select id="path_no" onchange="window.location='index.php?path_no='+this.value">
			<option>Path No</option>	
			<?php 
			if(isset($_SESSION['path_menu'])){
				$fname = $_SESSION['path_menu']._.$_SESSION['path'];
				$_SESSION['table_name'] = $fname;
				$id = $_SESSION['path_menu'];

				$qry = "SELECT ".$id."_id from $fname;";
				$result = $db_conn->query($qry);

				if ($result->num_rows > 0){
				 	while ($row = $result->fetch_assoc()){
					   	foreach($row as $k=>$v){	   		
							print "<option>".$v."</option>";
						}
					 }
				}else if($result->num_rows = 0){
					echo "<script>alert(\"enter the title\");</script>";
				}
			}
			?>
		</select>
	</form><br/></br>
</div>
<?php
	if(isset($_SESSION['path']) && !isset($_SESSION['path_menu']) && !isset($_SESSION['path_no'])){
			formShowAll();
	}else if(isset($_SESSION['path']) && isset($_SESSION['path_menu']) && !isset($_SESSION['path_no'])){
			formShowPath();
	}else if(isset($_SESSION['path']) && isset($_SESSION['path_menu']) && isset($_SESSION['path_no'])){
		formShowPathNo();
	}

}
?>