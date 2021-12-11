<?php
session_start();
//datenbank verbingung
require_once('config/config.php');
require_once('function/utilities.php');
require_once('function/notLogIn.php');



function isPost():bool{
    return strtoupper($_SERVER['REQUEST_METHOD']) ==='POST';
}

//escape damit die werte im input felder bleiben
function escape(string $value):string{
    return htmlspecialchars($value, ENT_QUOTES,'UTF-8');
}
function decrypt($str) {
	$str = html_entity_decode($str);
	$str = htmlspecialchars_decode($str);
	return $str;
}

$productName = "";
$productBeschreibung = "";
$productPreis = 0;
$errors = [];
$hasErrors = false;
$image_folderpath = '../bilder/produkte'; // hierhin kommt das Bild
$allowed_types = array('image/jpeg', 'image/gif', 'image/png' ); // hierhin kommt das Bild
$maxfilesize = 2*1024*1024; // 2MB
$thumbnail_foldername = 'produkte';
$thumbnail_hoehe = 60;
$hasFiles = false;


if(isset($_FILES['productBild']['size']) && $_FILES['productBild']['size'] > 0) {
	$hasFiles = true;
}

setlocale(LC_ALL, "de"); 
if(isPost() && $hasFiles){
	$productName = filter_input(INPUT_POST, 'productName', FILTER_SANITIZE_SPECIAL_CHARS);
    $productBeschreibung = filter_input(INPUT_POST, 'productBeschreibung', FILTER_SANITIZE_SPECIAL_CHARS);
    $productPreis = (int)filter_input(INPUT_POST, 'productPreis');


	//validieren
	
	if(false === (bool)$productName){
		$errors[] ="Bitte Produktnama eingeben";
	}
	if(false === (bool)$productBeschreibung){
		$errors[] ="Bitte eine Beschreibung zum Produkt eingeben";
	}
	if($productPreis === 0){
		$errors[] ="Bitte einen Preis eingeben";
	}
	if (isset($_FILES['productBild']) && $hasErrors == false) {
        // print_r($_FILES);

        $tmp_path = $_FILES['productBild']['tmp_name'];
        $zielpfad = $image_folderpath.'/'.$_FILES['productBild']['name'];

        // validierung: error, filesize etc...
        if($_FILES['productBild']['size'] > $maxfilesize){
            $hasErrors = true;
            $messages[] = 'Das Bild ist grösser als die erlaubte Maximalgrösse von <strong>'.($maxfilesize/1024/1024).' MB</strong>';
        }
        if(!in_array($_FILES['productBild']['type'], $allowed_types)){
            $hasErrors = true;
            $messages[] = 'Es können nur JPG, GIF oder PNG hochgeladen werden';
        }
        if($_FILES['productBild']['error'] > 0){
            $hasErrors = true;
            // generische Fehlermeldung - es könnte die Fehlernummer noch mit SWITCH oder IF/ELSE unterschieden werden
            $messages[] = 'Es ist ein Fehler aufgetreten';
        }
    }
	
	$moved = false;
    if ($hasErrors == false) {
        $moved = move_uploaded_file($tmp_path, $image_folderpath.'/'.$_FILES['productBild']['name']);
		$messages[] = 'Die Datei wurde hochgeladen in '.$image_folderpath.'/'.$_FILES['productBild']['name']; 
    } 

  
	
	$hasErrors = count($errors)>0;
	//produkt speichern in der datenbank
	if(false === $hasErrors && $moved == true){
		$conn = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
        $queryLogin = "INSERT INTO  product (titel, beschreibung, preis,bild) VALUES (?,?,?,?)";
        $stmt = mysqli_prepare($conn, $queryLogin);
        mysqli_stmt_bind_param($stmt, 'ssis', $productName, $productBeschreibung, $productPreis,$_FILES['productBild']['name']);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

		header('Location:produkte.php');
	}
}
?>
<!-- head -->
<?php include("includes/head.html")?>
<title>Produkt Edit | Phillip's Steinfiguren</title>
</head>
<body>
<!-- nav -->
<?php  include("includes/nav_cms.inc.php")?> 
<!-- header -->
<header class="container-lx d-flex align-items-center">
 <div class="container ">
	<div>
		<h1 class="display-1 pt-2">Produkte</h1>
			<div>
				<p class="ms-4">Veröffentliche ein neues Produkt.</p>
			</div>
		</div>
	</div>
</header>
<section class="container">
	<div class="py-5">
		<h2 class="text-center mt-3 h1">Neues Produkt</h2>
		<div class="container  py-5 d-flex justify-content-center">
			<form action="createProduct.php" method="POST" enctype="multipart/form-data"  class="border p-4">
			 <!-- fehlermeldung -->
			 <?php include("../includes/alertFehlermeldung.php")?>

				<div class="p-2">
					<label for="productName" class="">Produktname</label>
					<input type="text" id="productName" name="productName" value="<?=escape($productName)?>">
					
				</div>
				
				<div class="p-2">
					<label for="productBeschreibung" class="">Beschreibung</label>
					<textarea name="productBeschreibung" id="productBeschreibung" cols="30" rows="10"><?=escape($productBeschreibung)?></textarea>
					
				</div>
				
				<div class="p-2">
					<label for="productPreis" class="">Preis</label>
					<input type="text" id="productPreis" name="productPreis" value="<?=escape($productPreis)?>">
				
				</div>
				<div class="p-2">
					<label for="productBild"class="">Bild</label>
					<input type="file" id="productBild" name="productBild" >
				
				</div>
				<div class="p-2">
					<button type="submit"class="btn">Speichern</button>
					<a href="produkte.php" class="btn btn-danger">Abbrechen</a>
					
				</div>
			</form>
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