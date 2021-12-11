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
<!-- eingetragene adressen -->
<section id="selectAdress">
    <div class="container my-3">
        <div class="row">
        <?php foreach($deliveryAddresses as $deliveryAddress):?>
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <strong class="empfaenger"> <?= $deliveryAddress['empfaenger']?></strong>
                        <div class="adresse"><?= $deliveryAddress['adresse']?></div>
                    </div>
                    <div class="card-body">
                    <p class="stadt">
                    <?= $deliveryAddress['plz']?> <?= $deliveryAddress['stadt']?> 
                    </p>
                    <a href="index.php/selectLieferadresse/<?=$deliveryAddress['id']?>" class="cart-link">Wählen</a>
                    </div>
                </div>
            </div>
        <?php endforeach;?>
        </div>
    </div>
</section>
<!-- lieferadresse formular -->
<section id="neuelieferadresse">
    <div class="container py-4">
        <form method="POST" action="index.php/lieferadresse/add">
            <div class="card">
                <div class="card-header">Neue Adresse eintragen
                </div>
                <div class="card-body">
                <!-- fehlermeldung -->
                    <?php include("includes/alertFehlermeldung.php")?>
                    <div class="form-group">
                        <label for="empfaenger">Empfänger</label>
                        <input name="empfaenger" value="<?= escape($empfaenger) ?>" class="form-control <?= $empfaengerIsValid?'':' is-invalid'?>" id="empfaenger">
                    </div>
                    <div class="form-group">
                        <label for="adresse">Adresse</label>
                        <input name="adresse" value="<?= escape($adresse) ?>"  class="form-control <?= $adresseIsValid?'':' is-invalid'?>" id="adresse">
                    </div>
                    <div class="form-group">
                        <label for="plz">PLZ</label>
                        <input name="plz" value="<?= escape($plz) ?>"  class="form-control <?= $plzIsValid?'':' is-invalid'?>" id="plz">
                    </div>
                    <div class="form-group">
                        <label for="stadt">Stadt</label>
                        <input name="stadt" value="<?= escape($stadt) ?>" class="form-control <?= $stadtIsValid?'':' is-invalid'?>" id="stadt">
                    </div>
                </div>
                <div class="card-footer">
                    <button class="btn">Speichern</button>
                </div>
            </div>
        </form>
    </div>
</section>

<!-- footer und js spript -->
<?php include("includes/footer.inc.html")?>
</body>
</html>