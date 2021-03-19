<?php 
  if (isset($_POST['action']) && $_POST['action'] == 'discussion_forum') {
    require_once '../require/database.php';
    $q = "SELECT * FROM post INNER JOIN user_assign_role ON post.user_assign_role_id=user_assign_role.user_assign_role_id INNER JOIN user_role ON user_role.user_role_id=user_assign_role.user_role_id INNER JOIN USER ON user.user_id=user_assign_role.user_id WHERE post_type='Discussion Forum' ORDER BY post.post_id DESC ";
    $db->_result($q);
    $res = $db->result;

  if (isset($_SESSION['user'])) {
?>
  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Create Thread</h1>
          </div>
        </div>
          <div class="card-body">
      
      <div id="post">
        <form action="forms/post_process.php" method="POST" enctype="multipart/form-data">
          
        <table>
          <tr>
            <td>Title</td>
            <td><input type="text" class="form-control" name="title"></td>
          </tr>
          <tr>
            <td>Description</td>
            <td><input type="text" class="form-control" name="desc"></td>
          </tr>
          <tr>
            <td>Summary</td>
            <td><textarea name="summary" class="form-control" cols="30" rows="5"></textarea></td>
          </tr>
         
          <tr>
            <td><input type="submit" class="btn-success" name="forum" value="POST"></td>
          </tr>
        </table>
        </form>
      </div>
    </div>
      </div><!-- /.container-fluid -->



    </section>
  </div>
<?php } ?>
    
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
            <h1 class="w3-teal w3-padding-16" align="center">Discussion Forum</h1>
        <div class="row">
          <div class="col-12">
              <div class="w3-bar w3-blue-gray w3-card w3-padding">
                <p>Categories</p>
                <?php
                  $db->_result("SELECT * FROM category INNER JOIN category_assign ON category.category_id=category_assign.category_id WHERE category_assign.post_type='Discussion_Forum' AND parent_category IS NULL");
                  if ($db->result->num_rows) {
                    while ($c = mysqli_fetch_assoc($db->result)) {
                      ?>
                        <a href="#" class="w3-bar-item w3-button w3-text-white" onclick="category_post(<?php echo $c['category'];?>)"><?php echo $c['category']; ?></a>
                      <?php
                    }
                  }
                ?>
            </div>
          </div>
          
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">

        <?php 
          if ($res->num_rows) {
            
              while ($post = mysqli_fetch_assoc($res)) {

                ?>
                  <div class="row">
          
          <!-- /.col -->
          <div class="col-md-9">
            <div class="card">
              
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
                      <div class="row mb-3">
                        
                        <!-- /.col -->
                      </div>
                      <!-- /.row -->

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
             

                      <?php } ?>