<?php 
function formViewCalList(){
$db_conn = db_conn();

// bring file name form fileInfo and then create some options for selection tag using file name.
?>
<script type="text/javascript">
	function moveIndex(path, factor){
		if(path == 0){
			window.location = "index.php?factor="+factor;
		}else{
			window.location = "index.php?path="+path;
		}
	}
</script>
<div>
	<form method="POST">
		<label id="lb01">Choose a path to calculate</label>
		<!-- when a option is selected, send the selected value to index.php using get method.
			  This value will be saved session
		-->
		<select id="myList" onchange="moveIndex(this.value, 0)">
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
		</select><br /><br />

		<label id="lb01">Each Curvature to use</label>
		<select id="curveFactor" onchange="moveIndex(0, this.value)">
			<option>Curve Factor</option>
			<option>4/3</option>
			<option>1</option>
			<option>2/3</option>
			<option>infinity</option>
		</select><br /><br />
		<input type="submit" name="button" value="calculation">&nbsp;
		<input type="submit" name="button" value="main menu">
	</form>
</div>
<?php } ?>