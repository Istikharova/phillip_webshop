<!DOCTYPE html>
<html lang="de">
<head>
  <base href="<?=$baseUrl?>">
  <?php include("includes/head.inc.html")?>
  <link rel="stylesheet" href="css/login.css">
  <title>Login | Phillip's Steinfiguren</title>
</head>
<body>
<!-- nav -->
<?php include("includes/nav_page.inc.php")?>
<!-- header -->
<header id="steinfiguren" class="d-flex align-items-center">
  <div class="container">
    <div>
      <h1 class="display-1 pt-2">Login</h1>
    </div>
    <div>
        <p class="ms-4">Logge dich in deinen Account ein um deine Artikel zu bestellen.</p>
      </div>
  </div>
</header>
<section class="container" id="login">
  <div class="container formular">
    <div class="row col-lg-5 col-md-10 mx-auto container">
      <h2 class="text-center mt-3 display-2">Login</h2>
      <form class="mt-5"action="index.php/login" method="POST">
        <!-- fehlermeldung -->
        <?php include("includes/alertFehlermeldung.php")?>
          <div class="control-group">
          <div class="form-group floating-label-form-group controls">
            <label for="username">Username</label>
            <input type="text" class="form-control shadow-none" name="username" id="username"placeholder="Username" value="">
          </div>
          <div class="control-group ">
            <div class="form-group floating-label-form-group controls">
              <label for="password">Passwort</label>
              <input type="password" class="form-control shadow-none" name="password" id="password"placeholder="Passwort" value="">
            </div>
          </div>
          <button type="submit" class="btn btn-light mt-4" name="submit">Anmelden</button>
      </form> 
    </div>               
  </div>
</section>
<!-- footer und js script -->
<?php include("includes/footer.inc.html")?>
</body>
</html>