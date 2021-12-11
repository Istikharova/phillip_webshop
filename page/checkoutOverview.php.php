<!DOCTYPE html>
<html lang="de">
<head>
  <base href="<?=$baseUrl?>">
  <?php include("includes/head.inc.html")?>
  <title>Adresse | Phillip's Steinfiguren</title>
</head>
<body>
<!-- nav -->
<?php include("includes/nav_page.inc.php")?>
<!-- header -->
<header id="steinfiguren" class="d-flex align-items-center">
  <div class="container">
    <div>
      <h1 class="display-1 pt-2">Adresse</h1>
      <p>Wähle deine Lieferadresse</p>
    </div>
  </div>
</header>
<section id="overview">
    <?php foreach($cartItems as $cartItem):?>
	<div class="col">
    <?php include("includes/cart_item.php")?>
	</div>
  <?php endforeach;?>
<a class="btn btn-danger " href="index.php">Abbrechen</a>
<a class="btn " href="index.php/completeOrder">Bestellen</a>
</section>

<!-- footer und js spript -->
<?php include("includes/footer.inc.html")?>
</body>
</html>