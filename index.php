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
	
  $logoutGoTo = "home.php";
  if ($logoutGoTo) {
    header("Location: $logoutGoTo");
    exit;
  }
}
?>
<!DOCTYPE HTML>
<html>
	<head>
		<title>MLCP</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<!--[if lte IE 8]><script src="assets/js/ie/html5shiv.js"></script><![endif]-->
		<link rel="stylesheet" href="assets/css/main.css" />
		<!--[if lte IE 8]><link rel="stylesheet" href="assets/css/ie8.css" /><![endif]-->
       
	</head>
	<body class="landing">
		<div id="page-wrapper">

			<!-- Header -->
				<header id="header" class="alt">
					<h1><a href="index.php">Multi Level Car Parking</a></h1>
					<nav id="nav">
						<ul>
							<li><a href="index.php">Home</a></li>
                            
						 	<!--<li>
								<a href="#" class="icon fa-angle-down">Menu</a>
								<ul>
									<li><a href="#main">About</a></li>
									<li><a href="#features">Features</a></li>
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
                   <li><a href="availability.php" class="button">Check Slot Availability</a></li>
                            <?php if(isset($_SESSION['MM_Username'])): ?>
							<li><a href="<?php echo $logoutAction ?>" class="button">Logout</a></li>
                            <li><a href="welcome1.php" class="button">My Account</a></li>
                            <?php else: ?>
                            <li><a href="login.php" class="button">Login</a></li>
                            <?php endif ?>
						</ul>
					</nav>
				</header>

			<!-- Banner -->
				<section id="banner">
					<h2>Multi Level Car Parking</h2>
					<!--<p>Another fine responsive site template freebie by HTML5 UP.</p>-->
                    <p>&nbsp;</p>
					<ul class="actions">
						<!---<li><a href="#main" class="button special">Read More</a></li>--->
						
					</ul>
                    <p>&nbsp;</p>
                    <p>&nbsp;</p>
                    <p>&nbsp;</p>
				</section>

			<!-- Main -->
				<!---<section id="main" class="container">

					<section class="box special">
						<header class="major">
							<h2>Introducing ultimate Multi Level Car Parking</h2>
							<p>Introducing to you the whole new modernized way to park your car.</br> Get started by logging in to your account. </p>
                          
                            <ul class="actions">
                            <p>&nbsp;</p>
						<li><a href="login.php" class="button special">Login</a></li>
						
					</ul>
						</header>
						
					</section>

					<section id="features" class="box special features">
                     <p>&nbsp;</p>
                   
                    
						<div class="features-row">
							<section>
								<span class="icon major fa-automobile accent2"></span>
								<h3>Car Parking</h3>
								<p>No matter when you come to office, we will make sure you to reserve a place for you to park your car. You can also reserve a parking slot in advance.</p>
							</section>
							<section>
								<span class="icon major fa-lock accent3"></span>
								<h3>Security</h3>
								<p>The most important concern is the security of your car. Once your have parked your car at our premises, we take care of its security</p>
							</section>
						</div>
						
					</section>

					<!---<div class="row">
						<div class="6u 12u(narrower)">

							<section class="box special">
								<span class="image featured"><img src="images/pic02.jpg" alt="" /></span>
								<h3>Sed lorem adipiscing</h3>
								<p>Integer volutpat ante et accumsan commophasellus sed aliquam feugiat lorem aliquet ut enim rutrum phasellus iaculis accumsan dolore magna aliquam veroeros.</p>
								<ul class="actions">
									<li><a href="#" class="button alt">Learn More</a></li>
								</ul>
							</section>

						</div>
						<div class="6u 12u(narrower)">

							<section class="box special">
								<span class="image featured"><img src="images/pic03.jpg" alt="" /></span>
								<h3>Accumsan integer</h3>
								<p>Integer volutpat ante et accumsan commophasellus sed aliquam feugiat lorem aliquet ut enim rutrum phasellus iaculis accumsan dolore magna aliquam veroeros.</p>
								<ul class="actions">
									<li><a href="#" class="button alt">Learn More</a></li>
								</ul>
							</section>

						</div>
					</div>

				</section>--->

			<!-- CTA -->
				<!---<section id="cta">

					<h2>Sign up for beta access</h2>
					<p>Blandit varius ut praesent nascetur eu penatibus nisi risus faucibus nunc.</p>

					<form>
						<div class="row uniform 50%">
							<div class="8u 12u(mobilep)">
								<input type="email" name="email" id="email" placeholder="Email Address" />
							</div>
							<div class="4u 12u(mobilep)">
								<input type="submit" value="Sign Up" class="fit" />
							</div>
						</div>
					</form>

				</section>--->

			<!-- Footer -->
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
</html><a href="<?php echo $logoutAction ?>">Log out</a>