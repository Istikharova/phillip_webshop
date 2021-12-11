<?php
session_start();
//datenbank verbingung
require_once('config/config.php');
require_once('function/utilities.php');
require_once('function/notLogIn.php');

function decrypt($str) {
	$str = html_entity_decode($str);
	$str = htmlspecialchars_decode($str);
	return $str;
}

$hasError = false;
$messages = array();


// Save id
if (!isset($_GET['id'])) {
    header("produkte.php");
    exit;
}

 $id = $_GET["id"];
 print_r($id);
// Beitrag auslesen
$query = "SELECT `titel`, `beschreibung`, `bild`, `preis` FROM `product` WHERE `id` = ?";

$connection = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
$statement = mysqli_prepare($connection, $query);
mysqli_stmt_bind_param($statement, 'i', $id);
mysqli_stmt_execute($statement);
$result = mysqli_stmt_get_result($statement);

if (mysqli_num_rows($result) == 1) {
    while ($row = mysqli_fetch_assoc($result)) {
        $produkte [] = [
            'productName' => decrypt($row['titel']),
            'productBeschreibung' => decrypt($row['beschreibung']),
            'productPreis' => decrypt($row['preis'])  
        ];
    }
    // echo '<pre></pre>';
    // print_r($produkte);
    // echo '<pre></pre>';
} else {
    die("produkt kann nicht gefunden werden.");
}

// Änderungen speichern
if (isset($_POST['speichern'])) {
    $titel = desinfect($_POST['productName']);
    $beschreibung = desinfect($_POST['productBeschreibung']);
    $preis = $_POST['productPreis'];
   
    

    $titeleVal = $titel;
    $beschreibungVal = $beschreibung; 
    $preisVal = $preis;
   

    if (empty($titel)) {
        $hasError = true;
        $messages [] = 'Bitte gib eine Titel ein!';
    } elseif (strlen($titel) > 250) {
        $hasError = true;
        $messages [] = 'Feld darf nicht mehr als 250 Zeichen beinhalten.';
    }

    if (empty($beschreibung)) {
        $hasError = true;
        $messages [] = 'Bitte fülle die Beschreibung ein!';
    } elseif (strlen($beschreibung) > 250) {
        $hasError = true;
        $messages [] = 'Feld darf nicht mehr als 250 Zeichen beinhalten.';
    }

    if (empty($preis)) {
        $hasError = true;
        $messages [] = 'Bitte gib einen Preis ein!';
    }

   
    if (!$hasError) {
        $queryUpdate = "UPDATE product SET titel=?, preis=?, beschreibung=?  WHERE Id=?";

        $stmt = mysqli_prepare($connection, $queryUpdate);
        mysqli_stmt_bind_param($stmt, 'ssii', $titel, $beschreibung, $preis, $id);
        if (!mysqli_stmt_execute($stmt)) {
            echo mysqli_stmt_error($stmt);
        } else {
            header("Location: produkte.php");
            die();
        }
    }
} else {
    $titelVal = "";
    $preisVal = ""; 
    $beschreibungVal = "";
    
}

?>

<?php

// If error display error messages
if ($hasError == true && isset($messages) ) {
    echo $messages; 
}
?>
<!-- head -->
<?php include("includes/head.html")?>
<title>Produkt Edit | Phillip's Steinfiguren</title>
</head>
<body>
<!-- nav -->
<?php include("includes/nav_cms.inc.php")?>
<!-- header -->
<header class="container-lx d-flex align-items-center">
 <div class="container ">
	<div>
		<h1 class="display-1 pt-2">Produkte</h1>
			<div>
				<p class="ms-4">Produkt bearbeiten.</p>
			</div>
		</div>
	</div>
</header>
<section class="container">
	<div class="py-5">
		<h2 class="text-center mt-3 h1">Produkt bearbeiten</h2>
		<div class="container  py-5 d-flex justify-content-center">
		    <!-- Error Messages -->
            <?php if( count($messages)>0 ){ ?> 
            <div class="error">
                <?php echo implode('<br>', $messages); ?>
            </div>
            <?php } ?>
        <?php foreach ($produkte as $key => $value) { ?>
			<form  method="POST" enctype="multipart/form-data"  class="border p-4">
				<div class="p-2">
					<label for="productName" class="">Produktname</label>
					<input type="text" id="productName" name="productName" value="<?=$titelVal ? $titelVal : $value['productName']?>">
				</div>

				<div class="p-2">
					<label for="productBeschreibung" class="">Beschreibung</label>
					<textarea name="productBeschreibung" id="productBeschreibung" cols="30" rows="10"><?=$beschreibungVal ? $beschreibungVal : $value['productBeschreibung']?></textarea>
				</div>
				
				<div class="p-2">
					<label for="productPreis" class="">Preis</label>
					<input type="text" id="productPreis" name="productPreis" value="<?=$preisVal ? $preisVal : $value['productPreis']?>">
				</div>

				<div class="p-2">
				<button class="speichern" type="speichern" name="speichern">Speichern</button>
					<a href="index.php" class="btn btn-danger">Abbrechen</a>
				</div>
			</form>
			<?php } ?>
		</div>
	</div>
</section>
<!-- footer -->
<?php include("../includes/footer.inc.html")?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"integrity="sha512-bnIvzh6FU75ZKxp0GXLH9bewza/OIw6dLVh9ICg0gogclmYGguQJWl8U30WpbsGTqbIiAwxTsbe76DErLq5EDQ=="crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4"crossorigin="anonymous"></script>
<script src="../js/navigation_cms.js"></script>
</body>
</html>
