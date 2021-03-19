<?php 
	require_once '../require/database.php';

	if (isset($_POST['action']) && $_POST['action'] == "manage_users") {

		$db->_select("user");

		if ($db->result->num_rows) {
			?>
			<style type="text/css">
				/* The switch - the box around the slider */
.switch {
  position: relative;
  display: inline-block;
  width: 60px;
  height: 34px;
}

/* Hide default HTML checkbox */
.switch input {
  opacity: 0;
  width: 0;
  height: 0;
}

/* The slider */
.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 26px;
  width: 26px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: #2196F3;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
}
			</style>
			<div class="content-wrapper">
		    	<div class="container-fluid">
					<div class="row">
						<div class="card-body">
							<div class="card">
				 	           <!-- /.card -->
						    	<div id="users" class="col-12">
						       		<h2>Manage Users</h2>
							       	<span id="manage_user_msg"></span>
							       	
							       	<table class="table-dark table-striped w3-center" style="width: 100%;">
			       						<thead>
			       			
								       		<tr>
								       			<th>User ID</th>
								       			<th>First Name</th>
								       			<th>Last Name</th>
								       			<th>Email</th>
								       			<th>Is Active</th>
								       			<th>Is Approved</th>
								       		</tr>
			       						</thead>
			       						<tbody>
			       			
			       							<?php
			       		
								       			while ($user = mysqli_fetch_assoc($db->result)) {
								       				?>
								       					<tr>
								       						<td><?php echo $user['user_id']; ?></td>
								       						<td><?php echo $user['first_name']; ?></td>
								       						<td><?php echo $user['last_name']; ?></td>
								       						<td><?php echo $user['user_email']; ?></td>

								       						<td>
								       							<label class="switch">
								       								<?php 
								       									if ($user['is_active']==1) {
								       										?>
											       								<input onclick="active(this,<?php echo $user['user_id']; ?>)" checked type="checkbox" name="<?php echo "Active";?>">
								       										<?php
								       									}else{
								       										?>
											       								<input onclick="active(this,<?php echo $user['user_id']; ?>)" type="checkbox" name="<?php echo "Inactive";?>">
								       										<?php
								       									}
								       								?>
								       								<span class="slider round"></span>
								       							</label>
						            						</td>

								       						<td>
								       							<label class="switch">
								       								<?php 
								       									if ($user['is_approved']==1) {
								       										?>
								       											
											       								<input  disabled onclick="is_approved(this,<?php echo $user['user_id']; ?>)" checked type="checkbox" name="<?php echo "Approved";?>">
								       										<?php
								       									}else{
								       										?>
											       								<input onclick="is_approved(this,<?php echo $user['user_id']; ?>)" type="checkbox" name="<?php echo "Inapproved";?>">
								       										<?php
								       									}
								       								?>
								       								<span class="slider round"></span>
								       							</label>
						            						</td>
								       					</tr>
								       				<?php
								       			}
								       		?>
							       		</tbody>
							       	</table>
		      					</div>
		     				</div>
		      			</div>
		      		</div>
		  		</div>
			</div>
			<?php			
		}else{
			echo "not ok";
		}

	}/* If closed Manage user*/


	/* Approve New User*/
	if (isset($_POST['action']) && $_POST['action'] == "update_user") {

		$id = $_POST['id'];

		if ($_POST['status'] == "Inapproved") {
			$q = "UPDATE user SET is_approved=1 WHERE user_id=".$id;
		}
	
		$db->_result($q);
		if ($db->result) {
			echo "ok";
		}else{
			echo "not ok";
		}
	}


	/* USer status active/inactive*/
	if (isset($_POST['action']) && $_POST['action'] == "active_user") {

		$id = $_POST['id'];
		$status = $_POST['status'];

		if ($status == 'Active') {	
			$q = "UPDATE user SET is_active=0 WHERE user_id=".$id;
		}
		if ($status == 'Inactive') {	
			$q = "UPDATE user SET is_active=1 WHERE user_id=".$id;
		}

		$db->_result($q);
		if ($db->result) {
			echo "Status updated";
		}else{
			echo "Status not updated";
		}
	}
?>
