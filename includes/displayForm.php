<?php
function formDisplay(){
?>
	<content>
		<h3>Select and upload the file contaning the necesary path data</h3><br/><br/>
		<form method="POST" enctype="multipart/form-data">
			<label></label>
			<input type="file" name="pic[]" multiple="multiple">
			<input type="submit" name="button" value="upload">
			<input type="submit" name="button" value="main menu">
		</form>
	</content>
<?php 
}
?>