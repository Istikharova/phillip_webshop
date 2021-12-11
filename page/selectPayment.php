<!DOCTYPE html>
<html lang="de">
<head>
  <base href="<?=$baseUrl?>">
  <?php include("includes/head.inc.html")?>
  <title>Zahlung | Phillip's Steinfiguren</title>
</head>
<body>
<!-- nav -->
<?php include("includes/nav_page.inc.php")?>
<!-- header -->
<header id="steinfiguren" class="d-flex align-items-center">
  <div class="container">
    <div>
      <h1 class="display-1 pt-2">Zahlungsmöglichkeiten</h1>
      <p>Wähle deine Zahlungsart</p>
    </div>
  </div>
</header>
<section class="container" id="selectPaymentMethod">
<!-- fehlermeldung -->
  <?php include("includes/alertFehlermeldung.php")?>
  <div class="container">
    <form action="index.php/selectPayment" method="POST" class="my-4">
      <?php foreach($avaliablePaymentMethods as $value => $text):?>
      <div class="form-check">
        <input type="radio" class="form-check-input" name="paymentMethod" id="payment<?=$text?>" value="<?=$value?>">
        <label class="form-check-label" for="payment<?=$text?>"><?=$text?> </label>  
      </div>
      <?php endforeach?>
      <button type="submit" class="btn mt-4">Bestellen</button>
    </form>
  </div>
</section>
 <!-- footer und js script -->
<?php include("includes/footer.inc.html")?>   
</body>
</html>