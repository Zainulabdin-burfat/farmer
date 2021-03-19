<?php

require_once 'require/database.php';
$q = "SELECT * FROM post INNER JOIN user_assign_role ON post.user_assign_role_id=user_assign_role.user_assign_role_id INNER JOIN user_role ON user_role.user_role_id=user_assign_role.user_role_id INNER JOIN category ON category.category_id=post.category_id INNER JOIN USER ON user.user_id=user_assign_role.user_id WHERE post_type='Discussion Forum' ORDER BY post.post_id DESC";

$db->_result($q);
$res = $db->result;

?>
<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid">
      <h1 class="w3-teal w3-padding-16" align="center">Discussion Forum</h1>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <h2>Latest posts</h2>
      <div class="row">
        <?php
        $db->_result($q);
        $res = $db->result;
        $a = 0;
        while ($post = mysqli_fetch_assoc($res)) {
          $db->_result("SELECT added_on FROM post WHERE post_id=" . $post['post_id']);
          $time = mysqli_fetch_assoc($db->result);
          $a++;
          if ($a <= 4) {
        ?>
            <div class="col-3">
              <div class="card">
                <div class="card-body">
                  <div class="card mb-2 bg-gradient-dark">

                    <img style="width: auto;height: 300px;" class="card-img-top" src="https://media.istockphoto.com/photos/blur-office-meeting-background-business-people-working-group-in-picture-id1136476890?k=6&m=1136476890&s=170667a&w=0&h=107wDnv0hT_uEYEm0h8m4yrJJu4aIRyDzZdlDJqXe8Q=" alt="Dist Photo 1">

                    <div class="card-img-overlay d-flex flex-column justify-content-end">

                      <div style="text-shadow: 1px 1px 2px black">
                        <h5 class="card-title text-primary text-white"><?php echo $post['post_title']; ?></h5>
                        <p class="card-text text-white pb-2 pt-1">
                          <?php echo $post['post_description']; ?>..<a href="#" onclick="_detail(<?php echo $post['post_id']; ?>)">Show more</a>


                        <p><?php echo $post['first_name'] . " " . $post['last_name'] . " (" . $post['user_role'] . ")"; ?></p>
                        <p><?php echo "Category : " . $post['category']; ?></p>
                        <p class="text-white"><i class="fa fa-clock"> Posted on: <?php echo date('H:i a d-M-y', strtotime($time['added_on'])); ?></i></p>
                        </p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
        <?php
          }
        }
        ?>
        <button onclick="_discussion_forum()" class="w3-btn w3-blue">Create Thread</button>

      </div>
    </div>
  </section>