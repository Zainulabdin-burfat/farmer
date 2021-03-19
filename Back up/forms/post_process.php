<?php 

	require_once '../require/database.php';
	echo "<pre>";
	print_r($_POST);
	print_r($_SESSION);

	if (isset($_POST['submit'])) {

		$id 			= $_SESSION['user']['user_assign_role_id'];
		$user_id		= $_SESSION['user']['user_id'];
		$category_id 	= $_POST['category'];
		$title 			= $_POST['title'];
		$desc 			= $_POST['desc'];
		$summary 		= $_POST['summary'];
		$post_type 		= 'Knowledge Base';

		$insert 		= "INSERT INTO post(category_id,user_assign_role_id,post_title,post_description,post_summary,post_type,added_on) 				VALUES('$category_id','$id','$title','$desc','$summary','$post_type','".time()."')";

		$db->_result($insert);
		$last_id = mysqli_insert_id($db->connection);
		if ($db->result) {
			echo "Post added";
		}else{
			echo "Post not added";
		}


		if (isset($_FILES['file'])) {

			echo $file_name = "images/$user_id/".$_FILES['file']['name'];
			echo $tmp_name = $_FILES['file']['tmp_name'];

			$extension = pathinfo($_FILES['file']['name']);
			$extension = $extension['extension'];

			if ($extension == 'jpg' || $extension == 'PNG') {
				$extension = 'picture';
			}

			if (move_uploaded_file($tmp_name,"../".$file_name)) {

				if ($db->result) {
					echo "Blog Added";
					echo $insert = "INSERT INTO post_attachment(post_id,file_name,file_type) VALUES('$last_id','$file_name','$extension')";
					$db->_result($insert);
					if ($db->result) {
						echo "Blog Attachments Added";
						header('location:../index.php?action=blog&msg=File uploaded Successfully ..!');
					}else{
						echo "Blog Attachments not Added";
					}
				}else{
					echo "Blog not Added";
				}

			}else{
				echo "else";
				header('location:../index.php?action=blog&msg=File not uploaded');
			}
		}

		header('location:../index.php?action=blog&msg=File uploaded Successfully ..!');

	}

?>