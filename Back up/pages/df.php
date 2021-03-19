<?php 

    require_once 'require/database.php';
    $q = "SELECT * FROM post INNER JOIN user_assign_role ON post.user_assign_role_id=user_assign_role.user_assign_role_id INNER JOIN user_role ON user_role.user_role_id=user_assign_role.user_role_id INNER JOIN USER ON user.user_id=user_assign_role.user_id WHERE post_type='Discussion Forum' ORDER BY post.post_id DESC LIMIT 4";
    $db->_result($q);
    $res = $db->result;

?>
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <h1 class="w3-teal" align="center">Discussion Forum</h1>
          </div>
          
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="conten ">
      <div class="container-fluid w3-sand">
        <button class="w3-btn w3-padding w3-margin w3-blue"><a href="#" onclick="_discussion_forum()" class="w3-text-white">Create Thread</a></button>

        <?php 
          if ($db->result->num_rows) {
            
              while ($post = mysqli_fetch_assoc($db->result)) {

                ?>
                  <div class="row">
          
          <!-- /.col -->
          <div class="col-12">
            <div class="cards">
              
              <div class="card-body">
                <div class="tab-content">
                  <div class="active tab-pane" id="activity">
                   

                   

                    <!-- Post -->
                    <div class="post">
                      <div class="user-block">
                        <img class="img-circle img-bordered-sm" src="<?php echo $post['user_image']; ?>" alt="User Image">
                        <span class="username">
                          <a href="#"><?php echo $post['first_name']." ".$post['last_name']." (".$post['user_role'].")"; ?></a>
                          <!-- <a href="#" class="float-right btn-tool"><i class="fas fa-times"></i></a> -->
                        </span>
                        <span class="description"><?php echo $post['added_on']; ?></span>
                      </div>
                      <!-- /.user-block -->
                      <b><h4><?php echo $post['post_title']; ?></h4></b>
                      <p><?php echo $post['post_description']; ?>..<a href="#" onclick="_detail(<?php echo $post['post_id'];?>,2)">Show more</a></p>
                    </div>
                    <!-- /.post -->
                  </div>
            

            
                </div>
                <!-- /.tab-content -->
              </div><!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
                <?php
              }
          }
        ?>
        
        
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
