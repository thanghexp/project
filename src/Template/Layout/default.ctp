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
            <li class="<?php echo $this->request->params['action'] == 'ordercart' ? 'active' : ''; ?>" ><a href="<?php echo $this->request->webroot . 'carts/orderCart' ?>"><span class="glyphicon glyphicon-shopping-cart">MyCart</span></a></li>
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
        <div class="col-md-9"> 
            <?php echo $this->Flash->render(); ?> 
            <?= $this->fetch('content') ?>
        </div>
        <div class="col-md-3">
          <div class="sidebar">
            <?php if(isset($user)) { ?>
             <div class="list-group">
              <a href="#" class="list-group-item active"> Infomation customer </a>
              <a href="#" class="list-group-item"><b>Customer ID :</b> <?php echo isset($user['customer_id']) ? $user['customer_id'] : ''; ?></a>
              <a href="#" class="list-group-item"> <b>Name Account :</b> <?php echo isset($user['username']) ? $user['username'] : ''; ?></a>
              <a href="#" class="list-group-item"><b>Full Name :</b> <?php echo isset($user['first_name']) || isset($user['last_name']) ? $user['last_name'] . ' ' . $user['first_name'] : ''; ?></a>
              <a href="#" class="list-group-item"><b>Address :</b> <?php echo isset($user['address']) ? $user['address'] : ''; ?></a>
              <a href="#" class="list-group-item"><b>Number phone :</b> <?php echo isset($user['phone_number']) ? $user['phone_number'] : ''; ?></a>
            </div>
            <?php } ?>


            <div id="result">
              <table class="table table-responsive">
                <?php if(isset($cart) && ($this->request->params['action'] != 'orderCart')) { ?>
                  <tr>
                    <th>ID</th>
                    <th>Name Product</th>
                    <th>Qty</th>
                    <th>Money</th>
                  </tr>
                  <?php foreach($cart as $product) { ?> 
                    <tr>
                      <td><?php echo isset($product->product_id) ? $product->product_id : ''; ?></td>
                      <td><?php echo isset($product->name_product) ? $product->name_product : ''; ?></td>
                      <td><?php echo isset($session_cart[$product->product_id]) ? $session_cart[$product->product_id] : ''; ?></td>
                      <td><?php echo number_format($product->price * $session_cart[$product->product_id], 3); ?></td>
                    </tr>
                  <?php } ?> 
                <?php } ?>
              </table>
            </div>
            
          </div>

          <div>
            <!-- <img src="<?php echo $this->request->webroot . 'img/cafe.icon.png';?>" width="180" class="icon-coffee"> -->
          </div>
        </div>
      </div>
      
    </div><!-- End.content -->
    <div class="clear">
    </div>
    <div class="footer">
      <p>COPYRIGHT BY XP 2016</p>
    </div>
  </div><!-- End#wrapper -->

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
  <script src="<?php echo $this->request->webroot . 'webroot/js/app.js'; ?>"></script>
  <?php echo $this->Html->script('bootstrap/js/bootstrap.min.js'); ?>
  <script type="text/javascript">
    $('#myModal').on('shown.bs.modal', function () {
      $('#myInput').focus()
    })
  </script>
</body>
</html>