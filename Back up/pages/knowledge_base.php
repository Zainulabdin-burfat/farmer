<?php 
session_start();
  if (isset($_POST['action']) && $_POST['action'] == 'knowledge_base') {
    require_once '../require/database.php';
   $q = "SELECT *,post.added_on FROM post INNER JOIN user_assign_role ON post.user_assign_role_id=user_assign_role.user_assign_role_id INNER JOIN user_role ON user_role.user_role_id=user_assign_role.user_role_id INNER JOIN category ON category.category_id=post.category_id INNER JOIN post_attachment ON post_attachment.post_id=post.post_id INNER JOIN USER ON user.user_id=user_assign_role.user_id WHERE post_type='Knowledge Base' ORDER BY post.post_id DESC";
    $db->_result($q);
    $res = $db->result;

    if (!empty($_SESSION['user'])) {
?>
  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">

        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Create Post</h1>
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
            <td>Category</td>
            <td>
              <select id="category" class="form-control" name="category" onchange="get_child_category()">
                <option value="">Select category</option>
                <?php 
                  $db->_result("SELECT * FROM category INNER JOIN category_assign ON category.category_id=category_assign.category_id WHERE category_assign.post_type='Knowledge_Base' AND parent_category IS NULL");
                    $a = $db->result;
                    while ($category = mysqli_fetch_assoc($db->result)) {
                      ?>
                        <option value="<?php echo $category['category_id']; ?>"><?php echo $category['category']; ?></option>
                      <?php
                    }

                ?>
              </select>
            </td>
          </tr>
          <div id="child"></div>
          </tr>
          <tr>
            <td>Attachments</td>
            <td><input type="file" name="file"></td>
          </tr>
          <tr>
            <td><input type="submit" class="btn-success btn-flat" name="submit" value="POST"></td>
          </tr>
        </table>
        </form>
      </div>
    </div>
    <?php } ?>
          
      </div><!-- /.container-fluid -->



    </section>
  </div>
    
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
            <h1 class="w3-teal w3-padding-16" align="center">Knowledge Base</h1>
        <div class="row">
          <div class="col-12">
              <div class="w3-bar w3-blue-gray w3-card w3-padding">
                <p>Categories</p>
                <?php
                  $db->_result("SELECT * FROM category INNER JOIN category_assign ON category.category_id=category_assign.category_id WHERE category_assign.post_type='Knowledge_Base' AND parent_category IS NULL");
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
        <div class="row">
          <div class="col-9">
            <div class="card">
              <div class="card-body">

                <?php 
                  if ($res->num_rows) {
                    $a=0;
                      while ($post = mysqli_fetch_assoc($res)) {
                        $a++;
                        ?>
                            <div class="post">
                              <div class="user-block">
                                  <img class="img-circle img-bordered-sm" src="<?php echo $post['user_image']; ?>" alt="User Image">
                                  <span class="username">
                                    <a href="#"><?php echo $post['first_name']." ".$post['last_name']." (".$post['user_role'].")"; ?></a>
                                      <p><?php echo $post['category']; ?></p>
                                  </span>
                                <span class="description"><?php echo $post['added_on']; ?></span>
                              </div>

                              <b><h4><?php echo $post['post_title']; ?></h4></b>
                              <p><?php echo $post['post_description']; ?>..<a href="#" onclick="_detail(<?php echo $post['post_id'];?>)">Show more</a></p>
                              <div class="row mb-3">
                                <div class="col-sm-6">
                                  <?php 
                                    if ($post['file_type'] == 'picture' ) {
                                      ?>
                                        <img style="width: 400px;height: 300px;" class="img-fluid" src="<?php echo $post['file_name']; ?>" alt="Photo">
                                      <?php
                                    }
                                  ?>
                                </div>
                              </div>
                            </div>
                        <?php
                      }
                  }
                ?>
              </div>
            </div>
          </div>

          <div class="col-3">
            <div class="card">
              <div class="card-body">
                <h2>Latest posts</h2>
                <?php
                  $db->_result($q);
                  $a = 0;
                  while ($post = mysqli_fetch_assoc($db->result)) {
                    $a++;
                    if ($a<=4) {
                    ?>
                      <div class="card mb-2 bg-gradient-dark">
                        
                        <img style="width: auto;height: 300px;" class="card-img-top" src="<?php echo $post['file_name']; ?>" alt="Dist Photo 1">
                        
                        <div class="card-img-overlay d-flex flex-column justify-content-end">
                         
                          <div style="text-shadow: 1px 1px 2px black">
                            <h5 class="card-title text-primary text-white"><?php echo $post['post_title']; ?></h5>
                            <p class="card-text text-white pb-2 pt-1">
                              <?php echo $post['post_description']; ?>..<a href="#" onclick="_detail(<?php echo $post['post_id'];?>)">Show more</a>

                              <p class="text-white"><?php echo date("h:i:s d/m/y",$post['added_on']); ?></p>

                                <p><?php echo $post['first_name']." ".$post['last_name']." (".$post['user_role'].")"; ?></p>
                                <p><?php echo "Category : ".$post['category']; ?></p>
                            </p>
                          </div>
                        </div>
                      </div>
                    <?php
                    }
                  }
                ?>
              </div>
            </div>
          </div>
         
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
             

                      <?php } ?>