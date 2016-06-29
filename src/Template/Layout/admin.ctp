<!DOCTYPE html>
<html>
  <head>
    <?php echo $this->Html->css('jquery-ui.css'); ?>
    <?php echo $this->Html->css('jquery-ui.min.css'); ?>
    <?php echo $this->Html->css('bootstrap/css/bootstrap.min.css'); ?>
    <?php echo $this->Html->css('style.css'); ?>
    
    <?php echo $this->fetch('css'); ?>
    <?php echo $this->fetch('script'); ?>
  </head>
<body>
  <div class="wrapper">
    <div class="menu">
      <nav class="navbar navbar-inverse">
        <div class="container-fluid">
          <!-- Brand and toggle get grouped for better mobile display -->
          <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">Coffee Manage</a>
          </div>

          <!-- Collect the nav links, forms, and other content for toggling -->
          <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
              <li class="<?php echo 'Home' == $this->request->controller ? 'active' : ''; ?>"><a href="<?php echo $this->request->webroot . 'admin/home/dashboard' ?>">Dashboard <span class="sr-only">(current)</span></a></li>
              
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Users <span class="caret"></span></a>
                <ul class="dropdown-menu">
                  <li><a href="<?php echo $this->request->webroot . 'admin/users/listUser';  ?>">List User</a></li>
                </ul>
              </li>

              <li class="dropdown <?php echo 'Categorys' == $this->request->controller ? 'active' : ''; ?>">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Category <span class="caret"></span></a>
                <ul class="dropdown-menu">
                  <li><a href="<?php echo $this->request->webroot . 'admin/categorys/addCategory'; ?>">Add new</a></li>
                  <li><a href="<?php echo $this->request->webroot . 'admin/categorys/listCategory'; ?>">List view</a></li>
                </ul>
              </li>

              <li class="dropdown <?php echo 'Products' == $this->request->controller ? 'active' : ''; ?>">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Product <span class="caret"></span></a>
                <ul class="dropdown-menu">
                  <li><a href="<?php echo $this->request->webroot . 'admin/products/addProduct'; ?> ">Add new</a></li>
                  <li><a href="<?php echo $this->request->webroot . 'admin/products/listProduct'; ?>">List view</a></li>
                </ul>
              </li>

              <li class="dropdown <?php echo 'Invoices' == $this->request->controller ? 'active' : ''; ?>">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Invoice <span class="caret"></span></a>
                <ul class="dropdown-menu">
                  <li><a href="<?php echo $this->request->webroot . 'admin/invoices/listInvoice'; ?>">List view</a></li>
                </ul>
              </li>

              <li class="dropdown <?php echo 'Customers' == $this->request->controller ? 'active' : ''; ?>">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Customer <span class="caret"></span></a>
                <ul class="dropdown-menu">
                   <li><a href="<?php echo $this->request->webroot . 'admin/customers/addCustomer'; ?>">Add customer</a></li>
                  <li><a href="<?php echo $this->request->webroot . 'admin/customers/listCustomer'; ?>">List customer</a></li>
                </ul>
              </li>

              <li class="dropdown <?php echo 'Orders' == $this->request->controller ? 'active' : ''; ?>">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Order <span class="caret"></span></a>
                <ul class="dropdown-menu">
                  <li><a href="<?php echo $this->request->webroot . 'admin/orders/orderAtShop';?> " >Order at Shopping</a></li>
                  <li><a href="<?php echo $this->request->webroot . 'admin/orders/addProductOrder';?> " >Order products contact by phone</a></li>
                  <li><a href="<?php echo $this->request->webroot . 'admin/orders/listOrder'; ?>">Manage orders</a></li>
                </ul>
              </li>

              <li class="dropdown <?php echo 'Reports' == $this->request->controller ? 'active' : ''; ?>">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Report <span class="caret"></span></a>
                <ul class="dropdown-menu">
                  <li><a href="<?php echo $this->request->webroot . 'admin/reports/productsQtySale';?> " >Products sale</a></li>
                </ul>
              </li>

            </ul>
            <!-- <form class="navbar-form navbar-left" role="search">
              <div class="form-group">
                <input type="text" class="form-control" placeholder="Search">
              </div>
              <button type="submit" class="btn btn-default">Submit</button>
            </form> -->
            <ul class="nav navbar-nav navbar-right">
              <li><a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-cog"></span> Setting</a>
                <ul class="dropdown-menu">
                  <li><a href="<?php echo $this->request->webroot . 'admin/users/updateInfo'; ?>"><span class="glyphicon glyphicon-user"></span> Profile user </a></li>
                  <li><a href="<?php echo $this->request->webroot . 'admin/users/changePassword' ?>"><span class="glyphicon glyphicon-retweet"></span> Change Password</a></li>
                  <li role="separator" class="divider"></li>
                  <li><a href="<?php echo $this->request->webroot . 'admin/users/logout' ?>"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
                </ul>
              </li>
            </ul>

          </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
      </nav>
    </div>
    
    <div class="content">
      <div class="container"> 
        <div class="main">
          <?php echo $this->Flash->render(); ?>
          <?php echo $this->fetch('content'); ?>
        </div>
      </div>
    </div><!-- End.content -->
    <div class="clear">
    </div>
    <div class="footer">
      <p>&copy; COPYRIGHT BY XP 2016</p>
    </div>
  </div><!-- End#wrapper -->
  
  
  

  <!-- DateTimePicker -->
<!--   <script type="text/javascript" src="/bower_components/jquery/jquery.min.js"></script>
  <script type="text/javascript" src="/bower_components/moment/min/moment.min.js"></script>
  <script type="text/javascript" src="/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script> -->
  <!-- <link rel="stylesheet" href="/bower_components/bootstrap/dist/css/bootstrap.min.css" /> -->
  <!-- <link rel="stylesheet" href="/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css" /> -->

  <script type="text/javascript" src="<?php echo $this->request->webroot . 'webroot/js/jquery-1.12.3.min.js';  ?>"></script>
  <script type="text/javascript" src="<?php echo $this->request->webroot . 'webroot/js/jquery-ui.js'; ?>" ></script>
  <script type="text/javascript" src="<?php echo $this->request->webroot . 'webroot/js/app.js';  ?>"></script>
  
  <?php echo $this->Html->script('bootstrap/js/bootstrap.min.js'); ?>
  <script type="text/javascript">
      $(function() {
        $( "#datepicker1" ).datepicker();
        $( "#datepicker2" ).datepicker();
      });

      $('#datepicker2').change(function(event) {
            if( $('#datepicker2').val() < $('#datepicker1').val() ) {
                alert('End date must be taller Start date !');
                $('#datepicker2').val('');
            }
      }); 
      
  </script>
</body>
</html>