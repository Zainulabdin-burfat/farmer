<?php
if (isset($_POST['action']) && $_POST['action'] == 'detail') {
  require_once '../require/database.php';
  $id = $_POST['post_id'];
  if ($_POST['num'] == 2) {
    $q = "SELECT * FROM post INNER JOIN user_assign_role ON post.user_assign_role_id=user_assign_role.user_assign_role_id INNER JOIN user_role ON user_role.user_role_id=user_assign_role.user_role_id INNER JOIN USER ON user.user_id=user_assign_role.user_id WHERE post_type='Discussion Forum' AND post.post_id=$id ORDER BY post.post_id DESC";
  } else {

    $q = "SELECT * FROM post INNER JOIN user_assign_role ON post.user_assign_role_id=user_assign_role.user_assign_role_id INNER JOIN user_role ON user_role.user_role_id=user_assign_role.user_role_id INNER JOIN post_attachment ON post_attachment.post_id=post.post_id INNER JOIN USER ON user.user_id=user_assign_role.user_id WHERE post_type='Knowledge Base' AND post.post_id=$id ORDER BY post.post_id DESC";
  }
  $db->_result($q);
  $res = $db->result;

?>
  <!-- Post -->
  <style type="text/css">
    a[href $=".ppt"]::before {

      /*content: url("before/ppt.png");*/
      background-image: url('before/ppt.png');
      background-size: 15px 15px;
      display: inline-block;
      width: 15px;
      height: 15px;
      content: "";
    }

    a[href $=".xls"]::before {

      /*content: url("before/ppt.png");*/
      background-image: url('before/excel.png');
      background-size: 15px 15px;
      display: inline-block;
      width: 15px;
      height: 15px;
      content: "";
    }

    a[href $=".doc"]::before {

      /*content: url("before/ppt.png");*/
      background-image: url('before/word.png');
      background-size: 15px 15px;
      display: inline-block;
      width: 15px;
      height: 15px;
      content: "";
    }

    a[href $=".zip"]::before {

      /*content: url("before/ppt.png");*/
      background-image: url('before/doc.png');
      background-size: 15px 15px;
      display: inline-block;
      width: 15px;
      height: 15px;
      content: "";
    }
  </style>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <?php
            if ($_POST['num'] == 2) {
            ?>
              <h1>Discussion Forum</h1>
            <?php
            } else {
            ?>
              <h1>Knowledge Base</h1>
            <?php
            }
            ?>
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
            <div class="row">

              <!-- /.col -->
              <div class="col-md-9">
                <div class="card">

                  <div class="card-body">
                    <div class="tab-content">
                      <div class="active tab-pane" id="activity">

                        <div class="post">
                          <div class="user-block">
                            <img class="img-circle img-bordered-sm" src="<?php echo $post['user_image']; ?>" alt="User Image">
                            <span class="username">
                              <a href="#"><?php echo $post['first_name'] . " " . $post['last_name'] . " (" . $post['user_role'] . ")"; ?></a>
                              <!-- <a href="#" class="float-right btn-tool"><i class="fas fa-times"></i></a> -->
                            </span>
                            <span class="description"><?php //echo "Posted ".$pics['count(file_type)']." photos - ";echo $t; 
                                                      ?></span>
                          </div>
                          <!-- /.user-block -->
                          <b>
                            <h4><?php echo $post['post_title']; ?></h4>
                          </b>
                          <p><?php echo $post['post_summary']; ?></p>
                          <div class="row mb-3">
                            <div class="col-sm-6">

                              <?php
                              if (isset($post['file_type']) && $post['file_type'] == 'picture') {

                              ?>
                                <img style="width: 400px;height: 300px;" class="img-fluid" src="<?php echo $post['file_name']; ?>" alt="Photo">
                              <?php
                              } ?>
                            </div>
                            <!-- /.col -->
                            <p><?php echo $post['post_description']; ?></p>
                            <!-- /.col -->
                          </div>
                          <!-- /.row -->
                          <a href="pages/web.ppt">WEB Slide</a>
                          <br>
                          <a href="pages/web.xls">Excel</a>
                          <br>
                          <a href="pages/web.doc">Word</a>
                          <br>
                          <a href="pages/web.zip">Zip</a>
                          <!-- <img src="https://cdn.iconscout.com/icon/free/png-512/powerpoint-13-1174816.png"> -->
                          <p>
                            <a href="#" class="link-black text-sm"><i class="far fa-thumbs-up mr-1"></i> Like</a>
                            &nbsp;
                            &nbsp;
                            &nbsp;
                            <a href="#" class="link-black text-sm">
                              <i class="far fa-comments mr-1"></i> Comments (5)
                            </a>
                          </p>

                          <input class="form-control form-control-sm" type="text" placeholder="Type a comment">
                        </div>
                        <!-- /.post -->
                      </div>
                      <!-- /.tab-pane -->



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