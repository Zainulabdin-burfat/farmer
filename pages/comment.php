<?php 

	require_once '../require/database.php';

	if (isset($_POST['action']) && $_POST['action'] == "knowledge_base") {
		
		$db->_result("INSERT INTO post_reply(message,user_assign_role_id,post_id) VALUES('".htmlspecialchars($_POST['comment'],true)."','".$_POST['user_id']."','".$_POST['post_id']."')");
		if ($db->result) {
			echo "true";
		}else{
			echo "false";
		}
	}

?>