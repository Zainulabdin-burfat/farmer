<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<?php

    require_once '../require/database.php';

    $q = "SELECT * FROM post INNER JOIN user_assign_role ON post.user_assign_role_id=user_assign_role.user_assign_role_id INNER JOIN user_role ON user_role.user_role_id=user_assign_role.user_role_id INNER JOIN category ON category.category_id=post.category_id INNER JOIN post_attachment ON post_attachment.post_id=post.post_id INNER JOIN USER ON user.user_id=user_assign_role.user_id WHERE post_type='Knowledge Base' ORDER BY post.post_id DESC";
    $db->_result($q);
    $res = $db->result;

    $con = $db->connection;

    $sql = "SELECT * FROM post LIMIT 3,4";

    if (isset($_GET['page_no']) && $_GET['page_no']!="") {
        
        $page_no = $_GET['page_no'];
    }else {
        $page_no = 1;
    }


    $total_records_per_page = 3;

    $offset = ($page_no-1) * $total_records_per_page;
    $previous_page = $page_no - 1;
    $next_page = $page_no + 1;
    $adjacents = "2";

    $result_count = mysqli_query($con,"SELECT COUNT(*) As total_records FROM post");
    $total_records = mysqli_fetch_array($result_count);
    $total_records = $total_records['total_records'];
    $total_no_of_pages = ceil($total_records / $total_records_per_page);
    $second_last = $total_no_of_pages - 1; // total pages minus 1

    $result = mysqli_query($con,"SELECT * FROM post INNER JOIN user_assign_role ON post.user_assign_role_id=user_assign_role.user_assign_role_id INNER JOIN user_role ON user_role.user_role_id=user_assign_role.user_role_id INNER JOIN category ON category.category_id=post.category_id INNER JOIN post_attachment ON post_attachment.post_id=post.post_id INNER JOIN USER ON user.user_id=user_assign_role.user_id WHERE post_type='Knowledge Base' ORDER BY post.post_id DESC LIMIT $offset, $total_records_per_page");
?>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-9">
            <div class="card">
              <div class="card-body" id="filter">

                <?php 
                  if ($result->num_rows) {
                      while ($post = mysqli_fetch_assoc($result)) {
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

      
        </div>
      </div><!-- /.container-fluid -->
    </section>


<div style='padding: 10px 20px 0px; border-top: dotted 1px #CCC;'>
<strong>Page <?php echo $page_no." of ".$total_no_of_pages; ?></strong>
</div>

<ul class="pagination">
<?php if($page_no > 1){
echo "<li><a href='?page_no=1'>First Page</a></li>";
} ?>
    
<li <?php if($page_no <= 1){ echo "class='disabled'"; } ?>>
<a <?php if($page_no > 1){
echo "href='?page_no=$previous_page'";
} ?>>Previous</a>
</li>
    
<li <?php if($page_no >= $total_no_of_pages){
echo "class='disabled'";
} ?>>
<a <?php if($page_no < $total_no_of_pages) {
echo "href='?page_no=$next_page'";
} ?>>Next</a>
</li>

<?php if($page_no < $total_no_of_pages){
echo "<li><a href='?page_no=$total_no_of_pages'>Last &rsaquo;&rsaquo;</a></li>";
} ?>
</ul>

<?php


if ($total_no_of_pages <= 10){       
    for ($counter = 1; $counter <= $total_no_of_pages; $counter++){
        if ($counter == $page_no) {
           echo "<li class='active'><a>$counter</a></li>"; 
        }else{
            echo "<li><a href='?page_no=$counter'>$counter</a></li>";
        }
    }
}

    elseif ($total_no_of_pages > 10){
// Here we will add further conditions
}

if($page_no <= 4) {         
 for ($counter = 1; $counter < 8; $counter++){       
    if ($counter == $page_no) {
       echo "<li class='active'><a>$counter</a></li>";  
        }else{
           echo "<li><a href='?page_no=$counter'>$counter</a></li>";
                }
}
echo "<li><a>...</a></li>";
echo "<li><a href='?page_no=$second_last'>$second_last</a></li>";
echo "<li><a href='?page_no=$total_no_of_pages'>$total_no_of_pages</a></li>";
}

elseif($page_no > 4 && $page_no < $total_no_of_pages - 4) {      
    echo "<li><a href='?page_no=1'>1</a></li>";
    echo "<li><a href='?page_no=2'>2</a></li>";
    echo "<li><a>...</a></li>";
    for ($counter = $page_no - $adjacents; $counter <= $page_no + $adjacents; $counter++) {
        if ($counter == $page_no) {
            echo "<li class='active'><a>$counter</a></li>"; 
        }else{
            echo "<li><a href='?page_no=$counter'>$counter</a></li>";
        }                  
    }
    echo "<li><a>...</a></li>";
    echo "<li><a href='?page_no=$second_last'>$second_last</a></li>";
    echo "<li><a href='?page_no=$total_no_of_pages'>$total_no_of_pages</a></li>";
}

else {
    echo "<li><a href='?page_no=1'>1</a></li>";
    echo "<li><a href='?page_no=2'>2</a></li>";
    echo "<li><a>...</a></li>";

    for ($counter = $total_no_of_pages - 6; $counter <= $total_no_of_pages; $counter++) {
        if ($counter == $page_no) {
            echo "<li class='active'><a>$counter</a></li>"; 
        }else{
            echo "<li><a href='?page_no=$counter'>$counter</a></li>";
        }                   
    }
}

?>