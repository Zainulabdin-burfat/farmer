<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>.:: Farmer Connection ::.</title>
  <link rel="icon" href="../logo.jpg" type="image/x-icon" />


  <!-- Bootstrap 5 -->
  <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
  <!-- Bootstrap for pagination -->
  <link rel="stylesheet" href="../https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="../https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="../https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <!-- W3 CSS -->
  <link rel="stylesheet" type="text/css" href="../css/w3.css">
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="../https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="../plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../dist/css/adminlte.min.css">
</head>

<body class="hold-transition sidebar-collapse layout-fixed layout-navbar-fixed layout-footer-fixed">
  <div class="wrapper">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="../#" role="button"><i class="fas fa-bars"></i></a>
        </li>

        <li class="nav-item d-none d-sm-inline-block">
          <a href="../index.php" class="nav-link">Home</a>
        </li>
        <?php
        if (isset($_SESSION['user']) && $_SESSION['user']['user_role'] != 'Other') {
        ?>
          <li class="nav-item d-none d-sm-inline-block">
            <a href="../#" onclick="_dashboard()" class="nav-link">Dashboard</a>
          </li>

        <?php
        }
        ?>

        <li class="nav-item d-none d-sm-inline-block">
          <a href="../#" onclick="_knowledge_base()" class="nav-link">Knowledge Base</a>
        </li>

        <li class="nav-item d-none d-sm-inline-block">
          <a href="../#" onclick="_discussion_forum()" class="nav-link">Discussion Forum</a>
        </li>

        <li class="nav-item d-none d-sm-inline-block">
          <a href="../#" onclick="_consultant()" class="nav-link">Consultancy Service</a>
        </li>

        <li class="nav-item d-none d-sm-inline-block">
          <a href="../#" onclick="_e_commerce()" class="nav-link">E-Commerce</a>
        </li>
      </ul>



      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto">


        <?php

        require_once '../require/database.php';

        if (isset($_SESSION['user']) && $_SESSION['user']['user_role'] == 'Consultant') {
          $db->_result("SELECT count(consultant) AS 'Total' FROM consultancy_service WHERE status='In-Process' AND consultant=" . $_SESSION['user']['user_assign_role_id']);
          $result = mysqli_fetch_assoc($db->result);
        }
        if (isset($_SESSION['user']) && $_SESSION['user']['user_role'] != 'Consultant') {
          $db->_result("SELECT count(client) AS 'Total' FROM consultancy_service WHERE status='In-Process' AND client=" . $_SESSION['user']['user_assign_role_id']);
          $result = mysqli_fetch_assoc($db->result);
        }
        if (isset($_SESSION['user'])) {

          if ($_SESSION['user']['user_role'] == 'Consultant') {
            $db->_result("SELECT * FROM consultancy_service INNER JOIN user_assign_role ON user_assign_role.user_assign_role_id=consultancy_service.client INNER JOIN USER ON user.user_id=user_assign_role.user_id WHERE status='In-Process' AND consultant=" . $_SESSION['user']['user_assign_role_id']);
          } else {
            $db->_result("SELECT * FROM consultancy_service INNER JOIN user_assign_role ON user_assign_role.user_assign_role_id=consultancy_service.client INNER JOIN USER ON user.user_id=user_assign_role.user_id WHERE status='In-Process' AND client=" . $_SESSION['user']['user_assign_role_id']);
          }

          if ($db->result->num_rows) {
        ?>
            <li class="nav-item dropdown">
              <a class="nav-link" data-toggle="dropdown" href="../#">
                <i class="far fa-comments"></i>
                <span class="badge badge-danger navbar-badge"><?php echo  $result['Total']; ?></span>
              </a>
              <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <?php
                while ($client = mysqli_fetch_assoc($db->result)) {

                  if ($_SESSION['user']['user_role'] == 'Consultant') { ?>
                    <a onclick="_chat(<?php echo $client['consultancy_service_id']; ?>,<?php echo $client['user_assign_role_id']; ?>)" href="../#" class="dropdown-item">
                    <?php
                  } else {
                    ?>
                      <a onclick="_chat(<?php echo $client['consultancy_service_id']; ?>,<?php echo $client['consultant']; ?>)" href="../#" class="dropdown-item">
                      <?php
                    }
                      ?>
                      <!-- Message Start -->
                      <div class="media">
                        <img src="../<?php echo  $client['user_image']; ?>" alt="User Avatar" class="img-size-50 mr-3 img-circle">
                        <div class="media-body">
                          <h3 class="dropdown-item-title">
                            <?php echo $client['first_name']; ?>
                          </h3>
                          <p class="text-sm"><?php echo  $client['query']; ?></p>
                          <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i><?php echo  date("h:i a - d/m/y", strtotime($client['discussion_start'])); ?></p>
                        </div>
                      </div>
                      <!-- Message End -->
                      </a>
                    <?php
                  }
                    ?>
                    <div class="dropdown-divider"></div>
                    <a href="../#" class="dropdown-item dropdown-footer">See All Messages</a>
              </div>
            </li>

        <?php
          }
        }
        ?>

        <!-- Messages Dropdown Menu -->


        <?php
        if (!empty($_SESSION['user'])) { ?>
          <li class="nav-item d-none d-sm-inline-block">
            <a href="../#" class="nav-link">Welcome: <?php echo $_SESSION['user']['first_name'] . " (" . $_SESSION['user']['user_role'] . ")"; ?></a>
          </li>
          <li class="nav-item d-none d-sm-inline-block">
            <a href="../forms/login.php?msg=logout" class="nav-link">Log out</a>
          </li>
        <?php
        } else { ?>

          <li class="nav-item d-none d-sm-inline-block">
            <a href="../forms/login.php" class="nav-link">login</a>
          </li>

          <li class="nav-item d-none d-sm-inline-block">
            <a href="../forms/register.php" class="nav-link">Register</a>
          </li>
        <?php
        }
        ?>

      </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <a href="../index.php" class="brand-link">
        <img src="../logo.jpg" alt="Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Farmer Connection</span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <?php if (isset($_SESSION['user'])) { ?>
          <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
              <img src="../<?php echo $_SESSION['user']['user_image']; ?>" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
              <a onclick="view_profile(<?php echo $_SESSION['user']['user_assign_role_id']; ?>)" href="../#" class="d-block">
                <?php
                echo $_SESSION['user']['first_name'] ?? '';
                echo " (" . $_SESSION['user']['user_role'] . ")";
                ?></a>
            </div>
          </div>
        <?php } ?>


        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
            <?php
            if (isset($_SESSION['user']) && $_SESSION['user']['user_role'] != "Other") { ?>

              <li class="nav-item">
                <a onclick="_dashboard()" id="dashboard" href="../#" class="nav-link">
                  <i class="nav-icon fas fa-tachometer-alt"></i>
                  <p>
                    Dashboard
                    <i class="fas fa-angle-left right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview" style="display: none;">

                  <?php
                  if (isset($_SESSION['user']) && $_SESSION['user']['user_role'] == 'Admin') {
                  ?>
                    <li class="nav-item">
                      <a onclick="_manage()" href="../#" class="nav-link">
                        <i class="fa fa-users nav-icon"></i>
                        <p> Manage Users</p>
                      </a>
                    </li>
                  <?php
                  }
                  ?>
                  <li class="nav-item">
                    <a onclick="_products()" href="../#" class="nav-link">
                      <i class="fas fa-shopping-bag nav-icon"></i>
                      <p> Manage Products</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a onclick="_comments()" href="../#" class="nav-link">
                      <i class="fas fa-clone nav-icon"></i>
                      <p> Manage Post</p>
                    </a>
                  </li>

                </ul>
              </li>

            <?php
            } ?>

            <li class="nav-item">
              <a onclick="_knowledge_base()" id="knowledge_base" href="../#" class="nav-link">
                <i class="nav-icon fas fa-book"></i>
                <p>
                  Knowledge Base
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview" style="display: none;">
                <?php
                $db->_result("SELECT * FROM category INNER JOIN category_assign ON category.category_id=category_assign.category_id WHERE category_assign.post_type='Knowledge_Base' AND parent_category IS NULL");
                if ($db->result->num_rows) {
                  while ($c = mysqli_fetch_assoc($db->result)) {
                ?>
                    <li class="nav-item">
                      <a onclick="category_post(<?php echo $c['category_id']; ?>,1)" href="../#" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p><?php echo $c['category']; ?></p>
                      </a>
                    </li>
                <?php
                  }
                }
                ?>
              </ul>
            </li>

            <li class="nav-item">
              <a onclick="_discussion_forum()" id="forum" href="../#" class="nav-link">
                <i class="fab fa-rocketchat"></i>
                <p>
                  Discussion Forum
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview" style="display: none;">
                <?php
                $db->_result("SELECT * FROM category INNER JOIN category_assign ON category.category_id=category_assign.category_id WHERE category_assign.post_type='discussion_forum' AND parent_category IS NULL");
                if ($db->result->num_rows) {
                  while ($c = mysqli_fetch_assoc($db->result)) {
                ?>
                    <li class="nav-item">
                      <a onclick="category_post(<?php echo $c['category_id']; ?>,2)" href="../#" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p><?php echo $c['category']; ?></p>
                      </a>
                    </li>
                <?php
                  }
                }
                ?>
              </ul>
            </li>


            <li class="nav-item">
              <a onclick="_consultant()" id="consultant" href="../#" class="nav-link">
                <i class="fa fa-user-md"></i>
                <p>Consultancy Service</p>
              </a>
            </li>

            <li class="nav-item">
              <a onclick="_e_commerce()" id="forum" href="../#" class="nav-link">
                <i class="fa fa-shopping-bag"></i>
                <p>E-Commerce</p>
              </a>
            </li>

          </ul>
        </nav>
        <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
    </aside>

    <?php
    date_default_timezone_set("Asia/Karachi");
    ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Invoice</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="../#">Home</a></li>
                <li class="breadcrumb-item active">Invoice</li>
              </ol>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>

      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-12">
              <div class="callout callout-info">
                <h5><i class="fas fa-info"></i> Note:</h5>
                This page has been enhanced for printing. Click the print button at the bottom of the invoice to test.
              </div>


              <!-- Main content -->
              <div class="invoice p-3 mb-3">
                <!-- title row -->
                <div class="row">
                  <div class="col-12">
                    <h4>
                      <i class="fas fa-globe"></i> Farmer Connection
                      <small class="float-right"><?php echo "Date: " . date("d/m/Y", time()); ?></small>
                      </h2>
                  </div>
                  <!-- /.col -->
                </div>
                <!-- info row -->
                <div class="row invoice-info">
                  <div class="col-sm-4 invoice-col">
                    From
                    <address>
                      <strong>Farmer Connection</strong><br>
                      795 Folsom Ave, Suite 600<br>
                      San Francisco, CA 94107<br>
                      Phone: (123) 123-5432<br>
                      Email: info@farmerconnection.com
                    </address>
                  </div>
                  <!-- /.col -->
                  <div class="col-sm-4 invoice-col">
                    To
                    <address>
                      <strong><?php echo $_SESSION['user']['first_name']; ?></strong><br>
                      795 Folsom Ave, Suite 600<br>
                      San Francisco, CA 94107<br>
                      Phone: (555) 539-1037<br>
                      Email: <?php echo $_SESSION['user']['user_email']; ?>
                    </address>
                  </div>
                  <!-- /.col -->
                  <div class="col-sm-4 invoice-col">
                    <b>Invoice #007612</b><br>
                    <br>
                    <b>Order ID:</b> 4F3S8J<br>
                    <b>Payment Due:</b> 2/22/2014<br>
                    <b>Account:</b> 968-34567
                  </div>
                  <!-- /.col -->
                </div>
                <!-- /.row -->

                <!-- Table row -->
                <div class="row">
                  <div class="col-12 table-responsive">
                    <table class="table table-striped">
                      <thead>
                        <tr>
                          <th>Qty</th>
                          <th>Product</th>
                          <th>Serial #</th>
                          <th>Description</th>
                          <th>Subtotal</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>1</td>
                          <td>Call of Duty</td>
                          <td>455-981-221</td>
                          <td>El snort testosterone trophy driving gloves handsome</td>
                          <td>$64.50</td>
                        </tr>
                        <tr>
                          <td>1</td>
                          <td>Need for Speed IV</td>
                          <td>247-925-726</td>
                          <td>Wes Anderson umami biodiesel</td>
                          <td>$50.00</td>
                        </tr>
                        <tr>
                          <td>1</td>
                          <td>Monsters DVD</td>
                          <td>735-845-642</td>
                          <td>Terry Richardson helvetica tousled street art master</td>
                          <td>$10.70</td>
                        </tr>
                        <tr>
                          <td>1</td>
                          <td>Grown Ups Blue Ray</td>
                          <td>422-568-642</td>
                          <td>Tousled lomo letterpress</td>
                          <td>$25.99</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                  <!-- /.col -->
                </div>
                <!-- /.row -->

                <div class="row">
                  <!-- accepted payments column -->
                  <div class="col-6">
                    <p class="lead">Payment Methods:</p>
                    <img src="../../../dist/img/credit/visa.png" alt="Visa">
                    <img src="../../../dist/img/credit/mastercard.png" alt="Mastercard">
                    <img src="../../../dist/img/credit/american-express.png" alt="American Express">
                    <img src="../../../dist/img/credit/paypal2.png" alt="Paypal">

                    <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">
                      Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles, weebly ning heekya handango imeem
                      plugg
                      dopplr jibjab, movity jajah plickers sifteo edmodo ifttt zimbra.
                    </p>
                  </div>
                  <!-- /.col -->
                  <div class="col-6">
                    <p class="lead">Amount Due 2/22/2014</p>

                    <div class="table-responsive">
                      <table class="table">
                        <tr>
                          <th style="width:50%">Subtotal:</th>
                          <td>$250.30</td>
                        </tr>
                        <tr>
                          <th>Tax (9.3%)</th>
                          <td>$10.34</td>
                        </tr>
                        <tr>
                          <th>Shipping:</th>
                          <td>$5.80</td>
                        </tr>
                        <tr>
                          <th>Total:</th>
                          <td>$265.24</td>
                        </tr>
                      </table>
                    </div>
                  </div>
                  <!-- /.col -->
                </div>
                <!-- /.row -->

                <!-- this row will not appear when printing -->
                <div class="row no-print">
                  <div class="col-12">
                    <a href="invoice-print.php" rel="noopener" target="_blank" class="btn btn-default"><i class="fas fa-print"></i> Print</a>
                    <button type="button" class="btn btn-success float-right"><i class="far fa-credit-card"></i> Submit
                      Payment
                    </button>
                    <button type="button" class="btn btn-primary float-right" style="margin-right: 5px;">
                      <i class="fas fa-download"></i> Generate PDF
                    </button>
                  </div>
                </div>
              </div>
              <!-- /.invoice -->
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </section>
      <!-- /.content -->
    </div>


    <!-- Main Footer -->
    <footer class="main-footer">
      <strong>Copyright &copy; 2014-<?php echo date("Y", time()); ?><a href="../#"> Farmer Connection</a>.</strong>
      All rights reserved.
      <div class="float-right d-none d-sm-inline-block">
        <b>Version</b> 3.1.0-rc
      </div>
    </footer>
  </div>
  <!-- ./wrapper -->

  <!-- REQUIRED SCRIPTS -->
  <!-- Bootstrap 5 Js -->

  <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- jQuery -->
  <script src="../plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap -->
  <script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- overlayScrollbars -->
  <script src="../plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
  <!-- AdminLTE App -->
  <script src="../dist/js/adminlte.js"></script>

  <!-- PAGE PLUGINS -->
  <!-- jQuery Mapael -->
  <script src="../plugins/jquery-mousewheel/jquery.mousewheel.js"></script>
  <script src="../plugins/raphael/raphael.min.js"></script>
  <script src="../plugins/jquery-mapael/jquery.mapael.min.js"></script>
  <script src="../plugins/jquery-mapael/maps/usa_states.min.js"></script>
  <!-- ChartJS -->
  <script src="../plugins/chart.js/Chart.min.js"></script>

  <!-- AdminLTE for demo purposes -->
  <script src="../dist/js/demo.js"></script>
  <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
  <script src="../dist/js/pages/dashboard2.js"></script>
</body>

</html>