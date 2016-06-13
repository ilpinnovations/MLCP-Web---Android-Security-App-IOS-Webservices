<?php require_once('Connections/mlcp.php'); ?>
<?php
//initialize the session
if (!isset($_SESSION)) {
  session_start();
}

// ** Logout the current user. **
$logoutAction = $_SERVER['PHP_SELF']."?doLogout=true";
if ((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING'] != "")){
  $logoutAction .="&". htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_GET['doLogout'])) &&($_GET['doLogout']=="true")){
  //to fully log out a visitor we need to clear the session varialbles
  $_SESSION['MM_Username'] = NULL;
  $_SESSION['MM_UserGroup'] = NULL;
  $_SESSION['PrevUrl'] = NULL;
  unset($_SESSION['MM_Username']);
  unset($_SESSION['MM_UserGroup']);
  unset($_SESSION['PrevUrl']);
	
  $logoutGoTo = "index.php";
  if ($logoutGoTo) {
    header("Location: $logoutGoTo");
    exit;
  }
}
$message=""
?>
<?php
$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

if (isset($_POST['vehicleno'])) {
  $loginUsername=$_POST['vehicleno'];
  //$password=$_POST['vehicleno'];
  $MM_fldUserAuthorization = "";
  $MM_redirectLoginSuccess = "welcome1.php";
  $MM_redirectLoginFailed = "login.php";
  $MM_redirecttoReferrer = false;
  mysql_select_db($database_mlcp, $mlcp);
  
  $LoginRS__query=sprintf("SELECT vehiclenumber FROM mlcp_vehicle WHERE vehiclenumber='$loginUsername'"); 
   
  $LoginRS = mysql_query($LoginRS__query, $mlcp) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);
  if ($loginFoundUser) {
     $loginStrGroup = "";
    
	if (PHP_VERSION >= 5.1) {session_regenerate_id(true);} else {session_regenerate_id();}
    //declare two session variables and assign them
    $_SESSION['MM_Username'] = $loginUsername;
    $_SESSION['MM_UserGroup'] = $loginStrGroup;	      

    if (isset($_SESSION['PrevUrl']) && false) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }
    header("Location: " . $MM_redirectLoginSuccess );
  }
  else {
	  
    header("Location: ". $MM_redirectLoginFailed );
	echo "<script type=\"text/javascript\">".
        "alert('Invalid Username or Password');".
        "</script>";
  }
}
?>

<!DOCTYPE HTML>
<html>
	<head>
		<title>MLCP | Login</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<!--[if lte IE 8]><script src="assets/js/ie/html5shiv.js"></script><![endif]-->
		<link rel="stylesheet" href="assets/css/main.css" />
		<!--[if lte IE 8]><link rel="stylesheet" href="assets/css/ie8.css" /><![endif]-->
        <script>
		function validate()
{
	//var uname=document.getElementById('emp_id').value;
	var pass=document.getElementById('vehicleno').value;
if (window.XMLHttpRequest)
{// co'1de for IE7+, Firefox, Chrome, Opera, Safari
  	xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
   document.getElementById("login_status").innerHTML = xmlhttp.responseText;

    }
  }
xmlhttp.open("GET","login_validate.php?pass="+pass,true);
xmlhttp.send();
}
		</script>
	</head>
	<body>
		<div id="page-wrapper">

			<!-- Header -->
				<header id="header">
					<h1><a href="index.php">Multi Level Car Parking</a></h1>
					<nav id="nav">
						<ul>
							<li><a href="index.php">Home</a></li>
						 	<!---<li>
								<a href="#" class="icon fa-angle-down">Menu</a>
								<ul>
									<li><a href="index.php#main">About</a></li>
									<li><a href="index.php#features">Features</a></li>
									<!--<li><a href="elements.html">Elements</a></li>
									<li>
										<a href="#">Submenu</a>
										<ul>
											<li><a href="#">Option One</a></li>
											<li><a href="#">Option Two</a></li>
											<li><a href="#">Option Three</a></li>
											<li><a href="#">Option Four</a></li>
										</ul>
									</li>
								</ul>
							</li>--->
                            <?php if (isset($_SESSION['MM_Username'])): ?>
							<li><a href="<?php echo $logoutAction ?>" class="button">Logout</a></li>
                            <li><a href="welcome1.php" class="button">My Account</a></li>
                            <?php else: ?>
                            <li><a href="login.php" class="button">Login</a></li>
                          <?php endif ?>
						</ul>
					</nav>
				</header>
	<!-- Main -->
				<section id="main" class="container 50%">
					<header>
						<h2>Login</h2>
						<hr>
					</header>
					<div class="box">
                   <h3>Sign in to your account</h3>
                  
						<form method="POST" action="<?php echo $loginFormAction; ?>">
                        <div id="login_status" class="row uniform 50%">
						
						</div>
                        <p>&nbsp;</p>
							<!---<div class="row uniform 50%">
								<div class="12u">
									<input type="text" name="emp_id" id="emp_id" value="" placeholder="Employee ID" required>
								</div>
							</div>--->
							<div class="row uniform 50%">
								<div class="12u">
									<input type="text" name="vehicleno" id="vehicleno" value="" placeholder="Vehicle Number" required>
								</div>
							</div>
							<div class="row uniform">
								<div class="12u">
									<ul class="actions align-center">
       <li><input type="submit" class="button icon fa-unlock" onClick="return validate();" value="Login" placeholder="Vehicle Number" /></li>
                                   
										
									</ul>
								</div>
							</div>
						</form>
                    
					</div>
				</section>
				<footer id="footer">
					<!---<ul class="icons">
						<li><a href="#" class="icon fa-twitter"><span class="label">Twitter</span></a></li>
						<li><a href="#" class="icon fa-facebook"><span class="label">Facebook</span></a></li>
						<li><a href="#" class="icon fa-instagram"><span class="label">Instagram</span></a></li>
						<li><a href="#" class="icon fa-github"><span class="label">Github</span></a></li>
						<li><a href="#" class="icon fa-dribbble"><span class="label">Dribbble</span></a></li>
						<li><a href="#" class="icon fa-google-plus"><span class="label">Google+</span></a></li>
					</ul>-->
					<ul class="copyright">
						<li>&copy; ILP Innovations. All rights reserved.</li>
					</ul>
				</footer>

		</div>

		<!-- Scripts -->
			<script src="assets/js/jquery.min.js"></script>
			<script src="assets/js/jquery.dropotron.min.js"></script>
			<script src="assets/js/jquery.scrollgress.min.js"></script>
			<script src="assets/js/skel.min.js"></script>
			<script src="assets/js/util.js"></script>
			<!--[if lte IE 8]><script src="assets/js/ie/respond.min.js"></script><![endif]-->
			<script src="assets/js/main.js"></script>

	</body>
</html>