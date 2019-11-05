<?php
?>
<!DOCTYPE html>
<html>
<head>
  <title>Gavelgo | Admin</title>
</head>
<?php 
# pass whether this is an admin page or not, and the access level required
if(Auth::can_view_page(1, 1)){
  if(isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] === 'http://admin.gavelgo.com/login'){
    Messages::set_message('Welcome, ' . $_SESSION['admin_full_name']);
    Messages::display();
  }
?>
<body>
    <div id="wrapper">
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Dashboard</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-comments fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">XX</div>
                                    <div>1</div>
                                </div>
                            </div>
                        </div>
                        <a href="#">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-tasks fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">XX</div>
                                    <div>2</div>
                                </div>
                            </div>
                        </div>
                        <a href="#">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-yellow">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-shopping-cart fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">XX</div>
                                    <div>3</div>
                                </div>
                            </div>
                        </div>
                        <a href="#">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-red">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-support fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">XX</div>
                                    <div>4</div>
                                </div>
                            </div>
                        </div>
                        <a href="#">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->
<h3>Employees: </h3>
<h4><a href="/employees">Index</a></h4>
<h4><a href="/employees/hours">Hours</a></h4>
<h3>Partners: </h3>
<h4><a href="/partners">Index</a></h4>
<h4><a href="/partners/add">Add</a></h4>
<h3>Users: </h3>
<h4><a href="/users">Index</a></h4>
<h3>Auctions: </h3>
<h4><a href="/auctions">Index</a></h4>
<h3>Coupons: </h3>
<h4><a href="/coupons">Index</a></h4>
<br /><br />
<h3><a href="https://www.google.com/analytics/#?modal_active=none">Analytics</a></h3>
<h3><a href="http://localhost/phpMyAdmin/index.php">Data</a></h3>
<h3><a href="https://aws.amazon.com">Cloud</a></h3>
<?php
}
else {
    Messages::set_message('You cannot view this page', 'error');
    Messages::display();
    if(!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] === 0){
      echo '<h2><a href="/login">Log in</a></h2>';
    }
}
?>
</body>
</html>