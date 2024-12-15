
<?php
session_start();
error_reporting(0);
include("include/config.php");
if(isset($_POST['submit']))
{
	$username=$_POST['username'];
	$password=md5($_POST['password']);
$ret=mysqli_query($con,"SELECT * FROM admin WHERE username='$username' and password='$password'");
$num=mysqli_fetch_array($ret);
if($num>0)
{
$extra="change-password.php";//
$_SESSION['alogin']=$_POST['username'];
$_SESSION['id']=$num['id'];
$host=$_SERVER['HTTP_HOST'];
$uri=rtrim(dirname($_SERVER['PHP_SELF']),'/\\');
header("location:http://$host$uri/$extra");
exit();
}
else
{
$_SESSION['errmsg']="Invalid username or password";
$extra="index.php";
$host  = $_SERVER['HTTP_HOST'];
$uri  = rtrim(dirname($_SERVER['PHP_SELF']),'/\\');
header("location:http://$host$uri/$extra");
exit();
}
}

if(isset($_POST['verify'])) {
    $entered_otp = $_POST['otp'];

    if($entered_otp == $_SESSION['last_sent_otp']) {
        // OTP is correct, insert data into the database
        include('includes/config.php');
        $data = $_SESSION['reg_data'];
        $query = mysqli_query($con, "INSERT INTO users(name, email, contactno, password) VALUES('".$data['name']."', '".$data['email']."', '".$data['contactno']."', '".$data['password']."')");
        
        if($query) {
            echo "<script>alert('Registration successful!');</script>";
            unset($_SESSION['reg_data']);
            unset($_SESSION['last_sent_otp']);
            header("Location: login.php");
            exit();
        } else {
            echo "<script>alert('Something went wrong, please try again.');</script>";
        }
    } else {
        echo "<script>alert('Invalid OTP!');</script>";
    }
}
?>

			<!DOCTYPE html>
			<html lang="en">
				<head>
					<!-- Meta -->
					<meta charset="utf-8">
					<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
					<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
					<meta name="description" content="">
					<meta name="author" content="">
					<meta name="keywords" content="MediaCenter, Template, eCommerce">
					<meta name="robots" content="all">
			
					<title>Shopping Portal | Signi-in | Signup</title>
			
					<!-- Bootstrap Core CSS -->
					<link rel="stylesheet" href="assets/css/bootstrap.min.css">
					
					<!-- Customizable CSS -->
					<link rel="stylesheet" href="assets/css/main.css">
					<link rel="stylesheet" href="assets/css/green.css">
					<link rel="stylesheet" href="assets/css/owl.carousel.css">
					<link rel="stylesheet" href="assets/css/owl.transitions.css">
					<!--<link rel="stylesheet" href="assets/css/owl.theme.css">-->
					<link href="assets/css/lightbox.css" rel="stylesheet">
					<link rel="stylesheet" href="assets/css/animate.min.css">
					<link rel="stylesheet" href="assets/css/rateit.css">
					<link rel="stylesheet" href="assets/css/bootstrap-select.min.css">
			
					<!-- Demo Purpose Only. Should be removed in production -->
					<link rel="stylesheet" href="assets/css/config.css">
			
					<link href="assets/css/green.css" rel="alternate stylesheet" title="Green color">
					<link href="assets/css/blue.css" rel="alternate stylesheet" title="Blue color">
					<link href="assets/css/red.css" rel="alternate stylesheet" title="Red color">
					<link href="assets/css/orange.css" rel="alternate stylesheet" title="Orange color">
					<link href="assets/css/dark-green.css" rel="alternate stylesheet" title="Darkgreen color">
					<!-- Demo Purpose Only. Should be removed in production : END -->
			
					
					<!-- Icons/Glyphs -->
					<link rel="stylesheet" href="assets/css/font-awesome.min.css">
			
					<!-- Fonts --> 
					<link href='http://fonts.googleapis.com/css?family=Roboto:300,400,500,700' rel='stylesheet' type='text/css'>
					
					<!-- Favicon -->
					<link rel="shortcut icon" href="assets/images/favicon.ico">
			
			
			
			
				</head>
				<body class="cnt-home">
				
					
				
					<!-- ============================================== HEADER ============================================== -->
			<header class="header-style-1">
			
				<!-- ============================================== TOP MENU ============================================== -->
			<?php include('includes/top-header.php');?>
			<!-- ============================================== TOP MENU : END ============================================== -->
			<?php include('includes/main-header.php');?>
				<!-- ============================================== NAVBAR ============================================== -->
			<?php include('includes/menu-bar.php');?>
			<!-- ============================================== NAVBAR : END ============================================== -->
			
			</header>
			
			<!-- ============================================== HEADER : END ============================================== -->
			<div class="breadcrumb">
				<div class="container">
					<div class="breadcrumb-inner">
						<ul class="list-inline list-unstyled">
							<li><a href="home.html">Home</a></li>
							<li class='active'>Authentication</li>
						</ul>
					</div><!-- /.breadcrumb-inner -->
					<h4 class="">OTP verification</h4>
				</div><!-- /.container -->
			</div><!-- /.breadcrumb -->
			
			<div class="body-content outer-top-bd">
				<div class="container">
					<div class="sign-in-page inner-bottom-sm">
						<div class="row">
							<!-- Sign-in -->			
			<div class="col-md-6 col-sm-6 sign-in">
				
				<p class="">Enter Your OTP</p>
				<form class="register-form outer-top-xs" method="post">
				<span style="color:red;" >
			<?php
			echo htmlentities($_SESSION['errmsg']);
			?>
			<?php
			echo htmlentities($_SESSION['errmsg']="");
			?>
				</span>
					
			<!-- Sign-in -->
			<form class="register-form outer-top-xs" method="post">
        <input type="text" name="otp" id="otp" required> <br></br>
        <button type="submit" class="btn-upper btn btn-primary checkout-page-button" name="verify">Verify OTP</button>
    </form>
	<br></br>
	<br></br>
	<br></br>
			<!-- create a new account -->
			
			<!-- create a new account -->			</div><!-- /.row -->
					</div>
			<?php include('includes/brands-slider.php');?>
			</div>
			</div>
			<?php include('includes/footer.php');?>
				<script src="assets/js/jquery-1.11.1.min.js"></script>
				
				<script src="assets/js/bootstrap.min.js"></script>
				
				<script src="assets/js/bootstrap-hover-dropdown.min.js"></script>
				<script src="assets/js/owl.carousel.min.js"></script>
				
				<script src="assets/js/echo.min.js"></script>
				<script src="assets/js/jquery.easing-1.3.min.js"></script>
				<script src="assets/js/bootstrap-slider.min.js"></script>
				<script src="assets/js/jquery.rateit.min.js"></script>
				<script type="text/javascript" src="assets/js/lightbox.min.js"></script>
				<script src="assets/js/bootstrap-select.min.js"></script>
				<script src="assets/js/wow.min.js"></script>
				<script src="assets/js/scripts.js"></script>
			
				<!-- For demo purposes – can be removed on production -->
				
				<script src="switchstylesheet/switchstylesheet.js"></script>
				
				<script>
					$(document).ready(function(){ 
						$(".changecolor").switchstylesheet( { seperator:"color"} );
						$('.show-theme-options').click(function(){
							$(this).parent().toggleClass('open');
							return false;
						});
					});
			
					$(window).bind("load", function() {
					   $('.show-theme-options').delay(2000).trigger('click');
					});
				</script>
				<!-- For demo purposes – can be removed on production : End -->
			
				
			
			
            

    
</body>
</html>
