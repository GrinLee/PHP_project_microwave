<?php 
function formAddFile(){
	$db_conn = db_conn();
	$acceptedExt = array('csv');
	$isValid = true;

	// insert information that are name, size, date, and type, to table of fileInfo. 
	if ($_SERVER['REQUEST_METHOD'] == 'POST'){

		foreach($_FILES['pic']['error'] as $i=>$v){
			if ($_FILES['pic']['error'][$i] == 0 && $_FILES['pic']['size'][$i] > 0){
			
				$ext = strtolower(pathinfo($_FILES['pic']['name'][$i], PATHINFO_EXTENSION));

				if (!file_exists($_FILES['pic']['tmp_name'][$i])){ 
					echo "<h4>The file doesn't exist!</h4>";
					$isValid = false; 
					failAddFile();

				}else if (!in_array($ext, $acceptedExt)){
					echo "<h4>That file type isn't accepted!</h4>";
					$isValid = false;
					failAddFile();
				} 
			}else{
				print "<h4>Your text file failed.</h4>";
				$isValid = false;
				failAddFile();
			}	

			if($isValid){
				chmod($_FILES['pic']['tmp_name'][$i], 0777);

				if(!is_dir('uploads')){ mkdir("uploads", 0777); }
	         
		          $fn = $db_conn->real_escape_string(trim($_FILES['pic']['name'][$i]));
		          $fn = explode(".", $fn);
		          $fn = $fn[0];
	        		$newName = "uploads/$fn.".rand(10000, 99999) . ".". $ext;
				$success = move_uploaded_file($_FILES['pic']['tmp_name'][$i], $newName);

				if ($success){
					$fileName = $db_conn->real_escape_string(trim($_FILES['pic']['name'][$i]));
					$fileSize = $db_conn->real_escape_string(trim($_FILES['pic']['size'][$i]));
					$fileType = $db_conn->real_escape_string(trim($_FILES['pic']['type'][$i]));

					// check to prevent to upload a duplicated file
					$qry = "SELECT * FROM fileInfo WHERE file_name = '$fileName';";
					$result = $db_conn->query($qry);

					if($result->num_rows > 0){
						// if this file is duplicated, print out following 
						echo "This file was already uploaded";
						failAddFile();
					}else{
						// if this file is duplicated, insert this data to table.
						$qry = "INSERT INTO fileInfo SET file_name = '$fileName', store_file_name = '$newName', file_size = '$fileSize', file_type ='$fileType';"; 

						$db_conn->query($qry); 

						succssUpload();
					}

					

				}else{
					failAddFile();
				} 
			}

		}
	}	
}

function succssUpload(){
	$db_conn = db_conn();
	$qry1 = "SELECT * FROM fileInfo";
	$result = $db_conn->query($qry1);

	if ($result->num_rows > 0){
	 	while ($row = $result->fetch_assoc()){
	 		print "<tr>";
	 		$pathName = $row['file_name'];
	 		$pathName = explode(".", $pathName);
	 		$fname = $pathName[0];
	 		$fileName = $row['store_file_name'];
	   }
	} else {
		echo "Nothing to output\n";
	}
	// create table for inserting the data of csv file
	$qry = "CREATE TABLE path_$fname (
                 path_id INT(11) NOT NULL AUTO_INCREMENT,
                 path_name VARCHAR(100) NOT NULL,
                 path_frequency DOUBLE(8,4) NOT NULL,
                 path_description VARCHAR(255) NOT NULL,
                 path_note TEXT,
                 PRIMARY KEY (path_id)
                );";
     $db_conn->query($qry);

     $qry = "CREATE TABLE end_$fname (
                 end_id INT(11) NOT NULL AUTO_INCREMENT,
                 end_distance DOUBLE(8,4) NOT NULL,
                 end_ground_height DOUBLE(10,4) NOT NULL,
                 end_antenna_height DOUBLE(8,4) NOT NULL,
                 PRIMARY KEY (end_id)
                 );";
   	$db_conn->query($qry);

   	$qry = "CREATE TABLE mid_$fname  (
               mid_id int(11) NOT NULL AUTO_INCREMENT,
               mid_distance double(8,4) NOT NULL,
               mid_ground_height double(10,4) NOT NULL,
               mid_terrain_type varchar(50) NOT NULL,
               mid_obstruction_height double(8,4) NOT NULL,
               mid_obstruction_type varchar(50) NOT NULL,
               PRIMARY KEY (mid_id)
               );";
     $db_conn->query($qry);

	// bring the csv file, and insert above table
	if($fileName){
		$file_data = fopen($fileName, 'r');  
		while($row = fgetcsv($file_data)){
	         $rowA[] = $row;
	     }

		$path_name = $db_conn->real_escape_string(trim($rowA[0][0]));
	     $path_leng = $db_conn->real_escape_string(trim($rowA[0][1]));
	     $descript = $db_conn->real_escape_string(trim($rowA[0][2]));
	     $note = $rowA[0][3];
	    
	     $qry = "INSERT INTO path_$fname
	            (path_name, path_frequency, path_description, path_note)
	            VALUES ('$path_name', '$path_leng', '$descript', '$note');";

	     $db_conn->query($qry);

	     for($i = 1; $i<= 2; $i++){
	          $distStart = $db_conn->real_escape_string(trim($rowA[$i][0]));
	          $grouHeight = $db_conn->real_escape_string(trim($rowA[$i][1]));
	          $anteHeight = $db_conn->real_escape_string(trim($rowA[$i][2]));
	        
	          $qry = "INSERT INTO end_$fname
	                 (end_distance, end_ground_height, end_antenna_height)
	                 VALUES ('$distStart', '$grouHeight', '$anteHeight');"; 
	             
	          $db_conn->query($qry);  
	     }

	     for($i = 3; $i<count($rowA); $i++){
	          $distStart2 = $db_conn->real_escape_string(trim($rowA[$i][0]));
	          $grouHeight2 = $db_conn->real_escape_string(trim($rowA[$i][1]));
	          $terrType = $db_conn->real_escape_string(trim($rowA[$i][2]));
	          $obstHeight = $db_conn->real_escape_string(trim($rowA[$i][3]));
	          $obstType = $db_conn->real_escape_string(trim($rowA[$i][4]));
	                 
	          $qry = "INSERT INTO mid_$fname
	             (mid_distance, mid_ground_height, mid_terrain_type, mid_obstruction_height, mid_obstruction_type)
	             VALUES ('$distStart2', '$grouHeight2', '$terrType', '$obstHeight', '$obstType');";    
	           $db_conn->query($qry);  
	     }

		successInsert();
	}
}

function successInsert(){
	echo "<h4>success uploaing the file</h4>";
?>	
	<br/>
	<form method="post">
		<input type="submit" name="button" value="main menu">
		<input type="submit" name="button" value="view path data">
	</form>
<?php
}

function failAddFile(){
?>	<br/>
	<form method="post">
		<input type="submit" name="button" value="back uploading file">
	</form>
<?php
}
?>