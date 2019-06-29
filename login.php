<?php
	session_start();
	include '../includes/db.php';
	if (isset($_POST['submit_login'])) {
		if (!empty($_POST['user_name'])&&!empty($_POST['password'])) {
			$get_user_name=mysqli_real_escape_string($conn,$_POST['user_name']);
			 $get_password=base64_encode(mysqli_real_escape_string($conn,$_POST['password']));
			$sql="SELECT * FROM users WHERE First_Name='$get_user_name' AND Password='$get_password'";


			if ($result=mysqli_query($conn, $sql)){
				
					if (mysqli_num_rows($result)>0){
						while ($rows=mysqli_fetch_assoc($result)) {
					$_SESSION['user']=$get_user_name;
					$_SESSION['password']=$get_password;
					$_SESSION['role']=$rows['Role'];
					$new=$rows['First_Name'];
					$new1=$rows['Password'];
				}
					if($get_user_name !==$new OR $get_password !==$new1){
						echo "incorrect";
					}

					;
					if ($rows['Role']=='Admin')
					{ header('Location: ../admin/index.php'); }
				    elseif  ($rows['Role']=='Student')
				    { header('Location: ../student/index.php');  }
				    elseif  ($rows['Role']=='Instructor')
				    { header('Location: ../instructor/index.php'); }
				    if ($rows['Role']=='Student_council')
				    { header('Location: ../student council/index.php'); }
				    if ($rows['Role']=='Finance_and_registrar')
				    { header('Location: ../finance and registeral/index.php'); }
				}else{
				header('Location: ../index.php');
				echo "incorrect";
				} 	
		}
	}else{
			header('Location: ../index.php?login_error=empty');

		}
	}else{
		echo "Username or Password is empty";
	}
}
?>