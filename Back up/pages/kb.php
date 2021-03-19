<?php 
    require_once 'require/database.php';
   $q = "SELECT * FROM post INNER JOIN user_assign_role ON post.user_assign_role_id=user_assign_role.user_assign_role_id INNER JOIN user_role ON user_role.user_role_id=user_assign_role.user_role_id INNER JOIN post_attachment ON post_attachment.post_id=post.post_id INNER JOIN USER ON user.user_id=user_assign_role.user_id WHERE post_type='Knowledge Base' ORDER BY post.post_id DESC LIMIT 3";
    $db->_result($q);
    $res = $db->result;

?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <h1 align="center" class="w3-card-4 w3-teal">Knowledge Base</h1>
          </div>
          
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <button class="w3-btn w3-padding w3-margin w3-blue"><a href="#" onclick="_knowledge_base()" class="w3-text-white">Create Post</a></button>
      <div class="row w3-card-4">
        <?php 
          if ($res->num_rows) {
            
              while ($post = mysqli_fetch_assoc($res)) {
                // print_r($post);
                // $time = "SELECT added_on FROM post WHERE post_id=".$post['post_id'];
                // $r = mysqli_query($db->connection,$time);
                // $t = mysqli_fetch_assoc($r);
                // $t = date('h:i',$t['added_on']);
                // echo time();
                // $query = "SELECT count(file_type) FROM user_assign_role_id WHERE post_id='".$post['post_id']."' AND file_type='picture'";
                        // $result = mysqli_query($db->connection,$query);
                        // $pics = mysqli_fetch_assoc($result);
                ?>
          
          <!-- /.col -->
          <div class="col-12">
            <div class="card">
              
              <div class="card-body">
              
                   

                    <!-- Post -->
                    <div class="post">
                      <div class="user-block">
                        <img class="img-circle img-bordered-sm" src="<?php echo $post['user_image']; ?>" alt="User Image">
                        <span class="username">
                          <a href="#"><?php echo $post['first_name']." ".$post['last_name']." (".$post['user_role'].")"; ?></a>
                          <!-- <a href="#" class="float-right btn-tool"><i class="fas fa-times"></i></a> -->
                        </span>
                        <span class="description"><?php //echo "Posted ".$pics['count(file_type)']." photos - ";echo $t; ?></span>
                      </div>
                      <!-- /.user-block -->
                      <b><h4><?php echo $post['post_title']; ?></h4></b>
                      <p><?php echo $post['post_description']; ?>..<a href="#" onclick="_detail(<?php echo $post['post_id'];?>,1)">Show more</a></p>
                      <div class="row mb-3">
                        <div class="col-sm-6">

                    <?php 
                      if ($post['file_type'] == 'picture' ) {

                            ?>
                              <img style="width: 400px;height: 300px;" class="img-fluid" src="<?php echo $post['file_name']; ?>" alt="Photo">
                            <?php
                          } ?>
                        </div>
                        <!-- /.col -->
                        
                        <!-- /.col -->
                      </div>
                      <!-- /.row -->

                  

                    </div>
                    <!-- /.post -->
               
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
             
