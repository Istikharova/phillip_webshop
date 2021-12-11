<!DOCTYPE html>
<html lang="de">
<head>
  <base href="<?=$baseUrl?>">
  <?php include("includes/head.inc.html")?>
  <link rel="stylesheet" href="css/page.css">
  <title>Phillip's Steinfiguren</title>
</head>
<body>
<!-- navigation -->
<?php include("includes/nav_page.inc.php")?>
<!-- header -->
<header id="steinfiguren" class="d-flex align-items-center">
  <div class="container">
    <div>
      <h1 class="display-1 pt-2">Steinfiguren</h1>
      <div>
        <p class="ms-4">Mit grosser Leidenschaft erschaffe ich verschiedene Figuren aus kleinen Steinen. <br> Alle
          Figuren sind Einzelprodukte und werden mit viel Details handgefertigt.</p>
      </div>
    </div>
  </div>
</header>
<!-- Section Produkte -->
<section id="produkte">
  <div class="row justify-content-center pt-5 pb-5">
    <?php foreach($products as $product):?>
      <div class="m-5 rounded-0 " style="width: 25rem;">
        <?php include("includes/card_produkt.php")?>
      </div>
    <?php endforeach;?>
  </div>
</section>
<!--section About -->
<section id="about">
  <div class="container pb-5">
    <h2 class="display-1 py-5">About</h2>
    <div class="container pb-5">
      <div class="row">
        <div class="col-lg">
          <img src="bilder/man_klein.jpg" alt="..." class="float-start rounded">
        </div>
        <div class="col-lg">
          <h4 class="h3 pt-3">Phillip Castiche</h4>
          <p class="pb-5">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Culpa officiis reprehenderit eum,
            velit vitae voluptatem ea illo autem accusantium dignissimos, impedit id ab, dolore consectetur nostrum
            aspernatur totam cumque nobis. Lorem ipsum dolor sit amet consectetur adipisicing elit. Omnis, unde enim.
            Sequi exercitationem magnam odit esse velit. Reprehenderit et amet voluptatem assumenda. At alias, nihil
            assumenda eligendi quo voluptatem neque!
            Inventore non voluptates facere aut eligendi odio ipsam, veritatis voluptatum distinctio molestias
            blanditiis perferendis optio mollitia dolores animi, possimus officiis, itaque cum nesciunt sapiente odit
            eum. Consequatur corrupti mollitia deleniti.
            Molestias earum soluta sunt eum tenetur esse ipsa culpa dolore dignissimos totam quia nulla, quod voluptatem
            architecto? Obcaecati corrupti temporibus sunt sint dolorum ex expedita aspernatur! Beatae, necessitatibus
            voluptas?
          </p>
        </div>
      </div>
    </div>
  </div>
  <!-- slider -->
  <div id="carouselExampleIndicators" class="carousel slide pt-5" data-bs-ride="carousel">
    <div class="carousel-indicators">
      <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active"
        aria-current="true" aria-label="Slide 1"></button>
      <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1"
        aria-label="Slide 2"></button>
      <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2"
        aria-label="Slide 3"></button>
    </div>
    <div class="carousel-inner">
      <div class="carousel-item active">
        <img src="bilder/dragon-steinfiguren.jpg" class="d-block w-100" alt="...">
      </div>
      <div class="carousel-item">
        <img src="bilder/dragon-steinfiguren.jpg" class="d-block w-100" alt="...">
      </div>
      <div class="carousel-item">
        <img src="bilder/dragon-steinfiguren.jpg" class="d-block w-100" alt="...">
      </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators"
      data-bs-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators"
      data-bs-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
    </button>
  </div>
</section>
<!-- section Kontakt -->
<section id="kontakt">
  <div class="container">
    <h2 class="display-1 py-5">Kontakt</h2>
    <div class="container ms-4">
      <p class="h6 mb-5">Wenn du Fragen oder sonstige Anliegen hast. Fülle den nachfolgenden Text aus, sende den ab und
        ich werde mich rasch bei dir melden.</p>
      <!-- kontaktformular -->
      <hr>
      <br>
      <p class="h5 ms-4">Grüezi Phillip</p>
      <form class="m-4" action="">
        <div class="row form-group h6 ">

          <div class="">
            <label for="name">Ich heisse</label>
            <input type="text" name="name" id="name" placeholder="hier dein Name">
          </div>

          <div class="">
            <label for="message">Mein Anliegen:</label>
            <textarea name="nachricht" id="message"></textarea>
          </div>

          <div class="">
            <label for="mobile">Unter dieser Telefonnummer: </label>
            <input type="text" id="mobile" placeholder="Telefonnummer">
          </div>

          <div class="">
            <label for="email"> und der E-Mail: </label>
            <input type="email" name="email" id="email" placeholder="E-mail">
          </div>

          <p>kannst du mich erreichen.</p>
          <p>Ich freue mich auf deine Rückmeldung.</p>
        </div>
        <button type="submit" class="btn btn-light mb-4">Senden</button>
      </form>
    </div>
  </div>
</section>
  <!-- footer und js script-->
  <?php include("includes/footer.inc.html")?>
</body>
</html>