 
<div class="card-body">
    <img src="bilder/produkte/<?=$product['bild'] ?>" class="card-img-top rounded-0" alt="steinfiguren">
    <h3 class="card-title text-center h1"><?= $product['titel'] ?></h3>
    <p class="card-header"><?= $product['beschreibung'] ?></p>
    <ul class="list-group list-group-flush">
        <li class="list-group-item">Wartezeit: 1 Monat</li>
        <li class="list-group-item">Grösse: 5cm</li>
        <li class="list-group-item"><?= $product['preis'] ?>CHF</li>
    </ul>
    <a href="index.php/cart/add/<?= $product['id']?>" class="btn btn-outline-light p-2 my-2">In den Warenkorb</a>
</div>