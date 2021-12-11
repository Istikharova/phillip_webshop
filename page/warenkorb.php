<!DOCTYPE html>
<html lang="de">
<head>
  <base href="<?=$baseUrl?>">
  <?php include("includes/head.inc.html")?>
  <title>Warenkorb | Phillip's Steinfiguren</title>
</head>
<body>
<!-- nav -->
<?php include("includes/nav_page.inc.php")?>
<!-- header -->
<header id="steinfiguren" class="d-flex align-items-center">
  <div class="container">
    <div>
      <h1 class="display-1 pt-2">Phillip's Steinfiguren</h1>
    </div>
  </div>
</header>
<!-- warenkorb -->
<section class="container" id="cartItems">
  <h2 class="h1 display-3 text-center pt-4">Warenkorb</h2>
  <div class="container row py-5">
	  <?php foreach($cartItems as $cartItem):?>
	  <div class="col">
      <?php include("includes/cart_item.php")?>
	  </div>
    <?php endforeach;?>
	  <div class="container">
      <div class="py-4 h5">
        Total (<?=$countCartItems?>Artikel): <?=$cartSum?>CHF
      </div>
    <hr>
    <a  href="index.php/checkout" class="btn shadow-none my-3">Zur Kasse</a>
	</div>
</div>
</section>
<!-- footer und js script -->
<?php include("includes/footer.inc.html")?>
</html>