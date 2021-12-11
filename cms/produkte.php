<?php
session_start();
//datenbank verbingung
require_once('config/config.php');
require_once('function/utilities.php');
require_once('function/notLogIn.php');

$hasError = false;
$success = false;
$messages = array();

$query = "SELECT * FROM `product`";
$result = mysqli_query($conn, $query);
if(mysqli_num_rows($result) > 0){
    while($row = mysqli_fetch_assoc($result)) { 
        $produkte [] = [
            'id' => $row['id'],
            'titel' => $row['titel'],
            'beschreibung' => $row['beschreibung'],
            'preis' => $row['preis'],
            'bild'=> $row['bild']
        ];
    }
} else {
    die("No results.");
}

//delete button 
if(isset($_POST['delete'])) {
    $conn = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

    $cleanId = desinfect($_POST['delete']);
    $sqldelete = "DELETE FROM `product` WHERE `id` = ?";        
    $stmt = mysqli_prepare($conn, $sqldelete);
    mysqli_stmt_bind_param($stmt, 'i', $cleanId); // 'i' = 1 integer: id
    
    if (mysqli_stmt_execute($stmt)){
        $success = true;
        $messages [] = 'Artikel wurde gelöscht.';
        header("Location: produkte.php");
        die();
    } else {
        echo "error deleting the product";
    }
} 

?>

<!-- head -->
<?php include("includes/head.html")?> 
    <title>Produkte | Admintool</title>
</head>
<body>
<!-- nav -->
<?php include("includes/nav_cms.inc.php")?> 
<!-- header --> 
<header class="container-lx d-flex align-items-center">
    <div class= "container ">
      <div>
        <h1 class="display-1 pt-2" >Produkte</h1>
        <div>
          <p class="ms-4">Bearbeite oder stelle neue Produkte online.</p>
        </div>
      </div>
    </div>
</header>
<section class="container">
    <div class="row m-4">
        <div class="col-lg-5 col-md-10 mx-auto mb-4">
            <h2 class="text-center mt-3 h1" id="produkte">Übersicht Steinfiguren </h2>
            <br>
            <a href="createProduct.php" class="btn"><i class="fas fa-plus"></i> Neues Produkt</a>
            <br>
            <br>
            <div class="table-responsive">
                
                <?=isset($_GET['deleted']) ? "<div class=\"alert alert-danger\" role=\"alert\"><strong>Der Artikel wurde gelöscht!</strong></div>" : ""?>                          
                <?php if( count($messages)>0 ){ ?> 
            <div class="error">
                <?php echo implode('<br>', $messages); ?>
            </div>
            <?php } ?>
            <table class="table table-hover">
                <thead class="thead-light">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Figuren</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach (array_reverse($produkte) as $key => $value) { ?>
                    <tr>
                    <th scope="row"><?=$key+1?></th>
                    <td>
                        <a href="edit.php?id=<?=$value["id"]?>"><?=isset($_GET['created']) && $key == 0 ? $value['titel']." <span class=\"badge bg-warning float-right p-2\">NEW!</span>" : $value['titel']?></a>
                    </td>
                    <td>
                        <a class="btn btn-primary float-right" href="edit.php?id=<?=$value["id"]?>"><i class="fas fa-edit"></i> Bearbeiten</a>
                    </td>
                    <td>
                    <form action="" method="post">
                        <button name="delete" type="delete" class="btn btn-danger float-right" value="<?=$value["id"]?>"><i class="fas fa-trash-alt mr-1"></i> Löschen</button>
                        </form>
                    </td>
                <?php } ?>
                                    
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</section> 
<!-- footer -->
<?php include("../includes/footer.inc.html")?>


  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js" integrity="sha512-bnIvzh6FU75ZKxp0GXLH9bewza/OIw6dLVh9ICg0gogclmYGguQJWl8U30WpbsGTqbIiAwxTsbe76DErLq5EDQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
  <script src="../js/navigation.js"></script>
</body>
</html>