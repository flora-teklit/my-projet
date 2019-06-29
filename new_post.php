<?php 
//include 'includes/db.php';
// Create connection
$conn = new mysqli('127.0.0.1' ,'root','','forged_authentication');
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}else
{
	session_start();
	if ((isset($_SESSION['user'])&& isset($_SESSION['password']))==true) {
		$sel_sql="SELECT * FROM users WHERE First_Name='$_SESSION[user]' AND Password='$_SESSION[password]'";
		if ($run_sql=mysqli_query($conn,$sel_sql)) {
			if (mysqli_num_rows($run_sql)==1) {
			
			}else{
				header('Location: ../index.php');
			}
		}
	}else{
	   header('Location: ../index.php?You_First_need_to_login ');
	}
	
	if (isset($_POST['submit_post_button'])) {
	$campus=$_POST['campus'];
	$college = $_POST['college'];
	$department = $_POST['department'];

/*$res1=mysqli_query($conn,"SELECT * FROM campus where Campus_Name=$campus");
$row1=mysqli_fetch_array($res1);
if ($row1["Campus_Name"]!='') {
	$campusname=$row1["Campus_Name"];
}else{
	$campusname='ALL';
}

$res2=mysqli_query($conn,"SELECT * FROM college where collegeID=$college");
$row2=mysqli_fetch_array($res2);
if ($row2["College_Name"]!='') {
	$collegename=$row2["College_Name"];
}else{
	$collegename='ALL';
}

$res3=mysqli_query($conn,"SELECT * FROM department where departmentID=$department");
$row3=mysqli_fetch_array($res3);
if ($row3["Department_Name"]!='') {
	$departmentname=$row3["Department_Name"];
}else{
	$departmentname='ALL';
}*/


		$description = $_POST['description'];
		$deadline=$_POST['deadline'];
		$publish_date=$_POST['publish_date'];
		$category=$_POST['category'];
		$Posted_By=$_SESSION['user'];		
		$date_time = new DateTime();
		$nowd=$date_time->format('Y-m-d H:i:s');
		$title = $_POST['title'];
		$status= $_POST['status'];
		// Compress image
function compressImage($source, $destination, $quality) {

  $info = getimagesize($source);

  if ($info['mime'] == 'image/jpeg') 
    $image = imagecreatefromjpeg($source);

  elseif ($info['mime'] == 'image/gif') 
    $image = imagecreatefromgif($source);

  elseif ($info['mime'] == 'image/png') 
    $image = imagecreatefrompng($source);

  imagejpeg($image, $destination, $quality);

}


			$image_name=$_FILES['image']['name'];
			$image_size=$_FILES['image']['size'];
			$image_ext=pathinfo($image_name,PATHINFO_EXTENSION);
			$target_dir = "../uploads/";
			$target_file = $target_dir . basename($_FILES["image"]["name"]);
			$uploadOk = 1;
			$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
			if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
		&& $imageFileType != "gif" && $imageFileType != "JPG") {
		    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
		//echo "Sorry, your file is not an image.";
		    $uploadOk = 0;
		}
		
			if ($_FILES["image"]["size"] > 5000000) {
			    $uploadOk = 0;
			}
			if ($uploadOk == 0) {
			    echo "Sorry, your file was not uploaded.";
			     // Compress Image
			        
			}else{
				compressImage($_FILES['image']['tmp_name'],$target_file,60);
			move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
				$ins_sql="INSERT INTO certeficates (STU_ID,Description,File_Name,Graduation_date,Entrance_Date,Posted_Date,status,category,Posted_By,Campus,College,Department) VALUES('$title','$description','$image_name','$deadline','$publish_date','$nowd','$status','$category','$Posted_By','$campus','$college','$department')";
						if ($conn->query($ins_sql) === TRUE) 
{
							header('Location: post_list.php');
						}else
  {
    echo 'Error:' . $ins_sql . '<br>' . $conn->error;
  }
		}	
		

	}
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Admin Panel</title>
	<link rel="stylesheet" type="text/css" href="../bootstrap/css/bootstrap.css">
		<script type="text/javascript" src="../js/jquery.js"></script>
		<script type="text/javascript" src="../bootstrap/js/bootstrap.js"></script> 
		<!-- <script src="https://cloud.tinymce.com/stable/tinymce.min.js"></script> -->
		<script src="ckeditor/ckeditor.js"></script>
  <script>tinymce.init({ selector:'textarea' });</script>
</head>
<body>
	<?php include 'includes/header.php'; ?>
	<div style="width: 50px; height: 50px"></div>
	 <?php include 'includes/sidebar.php';?> 
	<div class="col-md-6">
				<div class="page-header"><h1></h1></div>
		<div class="container-fluid">
			<form class="form-horizontal" action="new_post.php" method="post" enctype="multipart/form-data">
				<div class="for-group">
					<label for="image">Upload an Image</label>
					<input id="image" type="file"  name="image" class="btn btn-primary" required>
				</div>
				<div class="form-group">
					<label for="title">ID</label>
					<input id="title" type="text" value="" class="form-control" name="title" required>
				</div>
				<div class="form-group">
					<label for="category">Category</label>
					<select id="category" name="category" class="form-control" required>
						<!--<option>Diploma</option>
						<option>Bachlor degree</option>
						<option>Masters program</option>-->
						<?php 
							$sel_sql="SELECT * FROM category";
							$run_sql=mysqli_query($conn,$sel_sql);
							while($c_rows=mysqli_fetch_assoc($run_sql)){
							//	if ($c_rows['category_name']=='home') {
									//continue;
								
								echo '<option value="'.$c_rows['category_name'].'">'.ucfirst($c_rows['category_name']).'</option>';
							}
						?>
						</select>
				</div>
				<div class="form-group">
					<label for="description">Description</label>
					<textarea id="description" name="description" class="ckeditor"></textarea>
				</div>

				<div class="form-group">
					<label for="publish_date">Entrance Date:</label>
					<input id="title" type="date" class="form-control" name="publish_date" required>
				</div>
				<div class="form-group">
					<label for="Deadline">Graduating year:</label>
					<input id="title" type="date" class="form-control" name="deadline" required>
				</div>


							<div class="form-group">
		                    <label for="Campus_ID" class="col-sm-2 control-label">Campus* </label>
		                    <div class="col-sm-6">
		                        <select class="form-control" id="campusid" name="campus" onchange="change_campus()">
									<?php 
							$sel_sql="SELECT * FROM campus";
							$run_sql=mysqli_query($conn,$sel_sql);
							while($c_rows=mysqli_fetch_assoc($run_sql)){
								//if ($c_rows['category_name']=='home') {
									//continue;
								
								echo '<option value="'.$c_rows['ID'].'">'.ucfirst($c_rows['Campus_Name']).'</option>';
							}
						?>
								</select>
		                        <span class="help-block"></span>
		                    </div>
		                </div>
		                <div class="form-group">
		                    <label for="college_ID" class="col-sm-2 control-label">College* </label>
		                    <div  class="col-sm-6" id="college">
		                        <select class="form-control" name="college">
								<?php 
							$sel_sql="SELECT * FROM college";
							$run_sql=mysqli_query($conn,$sel_sql);
							while($c_rows=mysqli_fetch_assoc($run_sql)){
								//if ($c_rows['category_name']=='home') {
									//continue;
								
								echo '<option value="'.$c_rows['ID'].'">'.ucfirst($c_rows['Name']).'</option>';
							}
						?>
								</select>
		                    </div>
		                </div>
		                <div class="form-group">
		                        <label for="department_ID" class="col-sm-2 control-label">Department* </label>
		                    <div class="col-sm-6"  id="department">
		                        <select class="form-control" name="department">
								<?php 
							$sel_sql="SELECT * FROM department";
							$run_sql=mysqli_query($conn,$sel_sql);
							while($c_rows=mysqli_fetch_assoc($run_sql)){
								//if ($c_rows['category_name']=='home') {
									//continue;
								
								echo '<option value="'.$c_rows['ID'].'">'.ucfirst($c_rows['Dept_Name']).'</option>';
							}
						?>
								</select>
		                    </div>
		                </div>




				<div class="for-group">
					<label for="status">Status</label>
					<select id="status" name="status" class="form-control">
						<option value="draft">Draft</option>
						<option value="published">Publish</option>	
				</div>
				<div class="form-group">
					<input id="edit_id" type="hidden" value="" class="form-control" name="edit_id" required>
				</div>
				<div style="width: 50px; height: 50px"></div>
				<div class="form-group">
					<input type="submit" class="btn btn-danger btn-block" name="submit_post_button">
				</div>
			</form>
		 </div>
	    <!-- }   
			}else{
				echo '<div class="alert alert-danger">please select a post to edit!<a href="index.php"></div>';
			}
		?> -->
	</div> 
<footer></footer>
					<script type="text/javascript">
					function change_campus(){
					var xmlhttp=new XMLHttpRequest();
					xmlhttp.open("GET","ajax.php?campus="+document.getElementById("campusid").value,false);
					xmlhttp.send(null);
					document.getElementById("college").innerHTML=xmlhttp.responseText;
						if (document.getElementById("campusid").value=="select") {
							document.getElementById("department").innerHTML="<select><option>select</option></select>";
						}
					}
					function change_college(){
					var xmlhttp=new XMLHttpRequest();
					xmlhttp.open("GET","ajax.php?college="+document.getElementById("college_ID").value,false);
					xmlhttp.send(null);
					document.getElementById("department").innerHTML=xmlhttp.responseText;
				
					}
					</script>
</body>
</html>
