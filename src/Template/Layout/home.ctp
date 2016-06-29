<!DOCTYPE html>
<html>
<head>
  <title></title>
  <?php //echo $this->Html->css('bake.css'); ?>
  <?php //echo $this->Html->css('cake.css'); ?>

  <?php echo $this->Html->css('bootstrap/css/bootstrap.min.css'); ?>
  <?php echo $this->Html->css('home.css'); ?>

  <?php echo $this->fetch('css'); ?>
  <?php echo $this->fetch('script'); ?>
</head>
<body>
  <div class="wrapper">
    <div class="menu">
       <nav class="navbar navbar-inverse">
        <div class="container-fluid">
          <div class="navbar-header">
            <a class="navbar-brand" href="#">Coffee Manage</a>
          </div>
          <ul class="nav navbar-nav">
            <li class="<?php echo 'Home' == $this->request->params['controller'] ? 'active' : ''; ?>"><a href="<?php echo $this->request->webroot . 'home/index'; ?>">Home</a></li>
            <li class="dropdown <?php echo 'Products' == $this->request->params['controller'] ? 'active' : ''; ?>">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Category <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <?php foreach($categorys as $category) { ?>
                  <li><a href="<?php echo $this->request->webroot . 'products/view-product/'. $category->category_id; ?>"><?php echo $category->name_category; ?></a></li>
                <?php } ?>
              </ul>
            </li>
            <li class="<?php echo $this->request->params['action'] == 'orderCart' ? 'active' : ''; ?>" ><a href="<?php echo $this->request->webroot . 'carts/orderCart' ?>"><span class="glyphicon glyphicon-shopping-cart">MyCart</span></a></li>
            <li class="<?php echo $this->request->params['action'] == 'history' ? 'active' : ''; ?>" ><a href="<?php echo $this->request->webroot . 'carts/history' ?>">History</a></li>
          </ul>
          <?php if(!isset($user)) { ?>
          <ul class="nav navbar-nav navbar-right">
            <li><a href="<?php echo $this->request->webroot . 'customers/signUp'; ?>"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
            <li><a href="<?php echo $this->request->webroot . 'customers/login'; ?>"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
          </ul>
          <?php } else { ?>
            <ul class="nav navbar-nav navbar-right">
              <li><a href="<?php echo $this->request->webroot . 'customers/logout'; ?>"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
            </ul>
          <?php } ?>
        </div>

      </nav>
    </div>

      <div class="content">
          <div class="row">
            <img src="<?php echo $this->request->webroot . 'img/welcome_image.jpg';  ?>"; width="1300" height="100" style="margin-top:-30px; margin-bottom: 20px;" />
          </div>
            <div class="container">
              <?php echo $this->Flash->render(); ?> 
              <?= $this->fetch('content') ?>
            </div>
          <div>
            <!-- <img src="<?php echo $this->request->webroot . 'img/cafe.icon.png';?>" width="180" class="icon-coffee"> -->
          </div>
      </div><!-- End.content -->
      
    
    <div class="clear">
    </div>
    <div class="footer">
      <p>COPYRIGHT BY XP 2016</p>
    </div>
  </div><!-- End#wrapper -->


    <!-- MODAL -->
    <!-- data-toggle="modal" data-target="#myModal" -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">My Cart</h4>
          </div>
          <div class="modal-body" id="result">
            <p>One fine body&hellip;</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->
  <script src="<?php echo $this->request->webroot . 'webroot/js/jquery-1.12.3.min.js'; ?>"></script>
  <script src="<?php echo $this->request->webroot . 'webroot/js/app.js'; ?>"></script>
  <script src="<?php echo $this->request->webroot . 'webroot/js/bootstrap/js/bootstrap.min.js'; ?>"></script>
  <script type="text/javascript">
    $('#myModal').on('shown.bs.modal', function () {
      $('#myInput').focus()
    })
  </script>
</body>
</html>