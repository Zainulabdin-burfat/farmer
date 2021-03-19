<?php 
	require_once '../require/database.php';

	echo "<pre>";

	print_r($_POST);
	$email = $_POST['email'];
	$password = hash("md5",$_POST['password']);
	$role = $_POST['role'];

	$db->_result("SELECT * FROM user WHERE user_email='".$email."' AND user_password='".$password."'");
	// print_r($db->result);
	if ($db->result->num_rows) {
		$user=mysqli_fetch_assoc($db->result);
		$u= $user['user_id'];
		$db->_result("SELECT * FROM user_assign_role INNER JOIN user ON user.user_id=user_assign_role.user_id INNER JOIN user_role ON user_role.user_role_id=user_assign_role.user_role_id WHERE user_assign_role.user_id=$u AND user_role.user_role='$role' AND is_active=1 AND is_approved=1");
		if ($db->result->num_rows) {
			echo "role matched";
			$_SESSION['user'] = mysqli_fetch_assoc($db->result);
			// print_r($_SESSION);
			header("location:../index.php?msg=Logged in Successfully");
		}else{
			header("location:login.php?msg=role not matched/inactive user");
			echo "role not matched/inactive user";
		}
	}else{
		header("location:login.php?msg=Invalid email/password");
		echo "Invalid email/password";
	}
?>