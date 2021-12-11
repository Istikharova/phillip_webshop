<!-- navigation für website -->
<nav class="navbar navbar-expand-md navbar-light fixed-top" id="mainNav">
  <div class="container">
    <a class="navbar-brand" href="<?=$baseUrl?>">Phillip's Steinfiguren</a>
    <div class="btngroup">

      <?php if(isLogIn()):?>
      <a href="index.php/logout.php" title="login"><i class="far fa-user" style="font-size: large"></i>Logout</a>
      <?php endif;?>

      <?php if(!isLogIn()):?>
      <a href="index.php/login.php" title="login"><i class="far fa-user" style="font-size: large"></i>Login</a>
      <?php endif;?>
      <a href="index.php/cart"><i class="fas fa-shopping-cart"></i>Warenkorb(<?=$countCartItems?>)</a>
    </div>
    <button
      class="navbar-toggler shadow-none"
      type="button"
      data-bs-toggle="collapse"
      data-bs-target="#navbarResponsive"
      aria-controls="navbarResponsive"
      aria-expanded="false"
      aria-label="Toggle navigation"
    >
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-end text-right" id="navbarResponsive">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link active" href="#">Steinfiguren</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#about">About</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#kontakt">Kontakt</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
