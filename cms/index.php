<?php
session_start();


require_once('config/config.php');
require_once('function/utilities.php');

require_once('function/notLogIn.php');
?>


<!-- head -->
<?php include("includes/head.html")?>
<title>Dashboard | Phillips Steinfiguren</title>
</head>

<body>
<!-- nav -->
<?php include("includes/nav_cms.inc.php")?>
<!-- header -->
<header class="container-lx d-flex align-items-center">
    <div class="container">
      <div>
        <h1 class="display-1 pt-2" >Dashboard</h1>
        <div>
          <p class="ms-4">Hallo hier kannst du deine Website verwalten.</p>
        </div>
      </div>
    </div>
</header>

<section >
	<div class="row container m-auto py-5 text-center">
		<div class="col">
			<div class="card-body mb-5" >
				<h5 class="card-header h1 p-3">Produkte</h5>
				<p class="card-title p-5 border"><a href="produkte.php" style="color: rgb(124, 13, 13);text-decoration: none;">Produkte Verwalten</a></p>
			</div>
		</div>
		<div class="col">
			<div class="card-body mb-5">
				<h5 class="card-header h1 p-3">Benutzer</h5>
				<p class="card-title p-5 border"><a href="register.php"style="color: rgb(124, 13, 13);text-decoration: none;" >Benutzer Verwalten</a></p>
			</div>
		</div>
		<div class="col">
			<div class="card-body mb-5">
				<h5 class="card-header h1 p-3">Bilder</h5>
				<div class="card-title border p-5"><a href="" style="color: rgb(124, 13, 13);text-decoration: none;">Bilder Verwalten</a><div>
			</div>
		</div>
		<div class="col">
			<div class="card-body mb-5">
				<h5 class="card-header h1 p-3">Bestellungen</h5>
				<div class="card-title border p-5"><a href="#" style="color: rgb(124, 13, 13);text-decoration: none;">Bestellungen</a><div>
			</div>
		</div>
	</div>
</section>

	<!-- footer -->
	<?php include("../includes/footer.inc.html")?>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"
		integrity="sha512-bnIvzh6FU75ZKxp0GXLH9bewza/OIw6dLVh9ICg0gogclmYGguQJWl8U30WpbsGTqbIiAwxTsbe76DErLq5EDQ=="
		crossorigin="anonymous" referrerpolicy="no-referrer"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"
		integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4"
		crossorigin="anonymous"></script>

	<script src="../js/navigation_cms.js"></script>

</body>

</html>