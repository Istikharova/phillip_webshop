<?php
session_start();
session_regenerate_id();
//datenbank verbingung
require_once('config/config.php');
require_once('function/utilities.php');


$loginError = false;
$validationErrorUsername = "";
$validationErrorPW = "";

// check if submit-button is clicked
if(isset($_POST['submit'])) {
    // if yes, desinfect user inputs
    $username = desinfect($_POST['username']); 
    $password = desinfect($_POST['password']);

    $usernameValue = $username;
    $passwordValue = $password;

    // check if username field is empty
    if(empty($username)) {
        $validationErrorUsername = "<ul role=\"alert\"><li>Bitte gib deinen Usernamen ein.</li></ul>";
    }
    
    // check if password field is empty
    if(empty($password)) {
        $validationErrorPW = "<ul role=\"alert\"><li>Bitte gib dein Passwort ein.</li></ul>";
    }

    if(!$validationErrorUsername && !$validationErrorPW) {
        // search username in the database
        $conn = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
        $queryLogin = "SELECT * FROM  admins WHERE `admin_name`=?";
        $stmt = mysqli_prepare($conn, $queryLogin);
        mysqli_stmt_bind_param($stmt, 's', $username);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $numRows = mysqli_num_rows($result); // count number of matches
         //print_r($numRows);

        if($numRows == 1) {
          $userdata = mysqli_fetch_assoc($result);
            // echo '<pre> User Data: ';
            // print_r($userdata);
            // print_r($password);
            // echo '</pre>';
          if(password_verify($password, $userdata['admin_password'])) {
                // echo "Passwort verifiziert";    
                        
                $_SESSION['isLoggedin'] = true; // login state
                $_SESSION['timestamp'] = time(); // for session limit time
                $_SESSION['userip'] = $_SERVER['REMOTE_ADDR']; // user ip
                $_SESSION['useragent'] = $_SERVER['HTTP_USER_AGENT']; // user agent of the visitor's browser
                $_SESSION['username'] = $username;
                // echo '<pre>';
                // print_r($_SESSION); 
                // echo '</pre>';
                
                // redirect to CMS Dashboard
                header('Location: index.php'); 
            } else {
                $loginError = true; // wrong password
            }
        } else {
            $loginError = true; // wrong username
        }     
    }        
} else {
	$usernameValue = "";
  $passwordValue = "";
}

$sessionValid = sessionIsValid();

if(!$sessionValid) {
  session_unset(); // clean up session data
	session_regenerate_id(); // replace current session id with a newly generated one
} else if ($sessionValid) {
  $_SESSION['timestamp'] = time(); // refresh session time
}


?>

<!DOCTYPE html>
<html lang="de">
<head>
  <!-- head -->
  <?php include("includes/head.html")?>
  <link rel="stylesheet" href="../css/login.css">
  <title>Login | Admintool</title>
</head>
<body>

<!-- navigation -->
<nav class="navbar navbar-expand-md navbar-light fixed-top" id="mainNav">
   <div class="container">
      <a class="navbar-brand" href="../index.php">Phillip's Steinfiguren</a>
      <?php
        if(sessionIsValid()) {
           
            echo "<style>#loginIcon{display: none !important;}</style>";
            echo "<li class=\"nav-item\"><a class=\"nav-link border border-white rounded\" href=\"function/logout.php\" id=\"logoutIcon\"><i class=\"fas fa-sign-out-alt\" style=\"font-size: medium;\"></i> Logout</a></li>";                   
          }
      ?>
      <button class="navbar-toggler shadow-none"" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-end text-right" id="navbarResponsive">
        <ul class="navbar-nav ">
          <li class="nav-item">
            <a class="nav-link active" href="../index.php">Steinfiguren</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../#about">About</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../#kontakt">Kontakt</a>
          </li>
        </ul>
      </div> 
    </div>
</nav>
<!-- header -->
<header  class="container-lx d-flex align-items-center"">
    <div class= "container ">
      <div>
        <h1 class="display-1 pt-2" >Login</h1>
        <div>
          <p class="ms-4">Logge dich in deinen Account ein.</p>
        </div>
      </div>
    </div>
</header>
<!-- section login -->
<section id="anmelden" style="height:30rem;">
  <div class="container formular">
    <div class="row col-lg-5 col-md-10 mx-auto container">
      <h2 class="text-center mt-3 display-2">Login</h2>
      <!-- fehlermeldung -->
      <?php 
      if($loginError) {
        echo "<p class=\"alert alert-danger\"><strong>Username oder Passwort falsch</strong></p>";
      }?>
      <form class="mt-5"action="login.php" method="post">
        <div class="control-group">
          <div class="form-group floating-label-form-group controls">
            <label for="username">Username</label>
            <input type="text" class="form-control shadow-none" name="username" id="username"placeholder="Username" value="<?=$usernameValue?>">
            <div class="help-block text-danger"><?=$validationErrorUsername?></div>
          </div>
        </div>
        <div class="control-group ">
          <div class="form-group floating-label-form-group controls">
            <label for="password">Passwort</label>
            <input type="password" class="form-control shadow-none" name="password" id="password"placeholder="Passwort" value="<?=$passwordValue?>">
            <div class="help-block text-danger"><?=$validationErrorPW?></div>
          </div>
          <button type="submit" class="btn btn-light mt-4" name="submit">Anmelden</button>
        </div>
      </form> 
    </div>               
  </div>
</section>
<!-- produkte form -->


<!-- footer -->
<?php include("../includes/footer.inc.html")?>
    <!-- Bootstrap core JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js" integrity="sha512-bnIvzh6FU75ZKxp0GXLH9bewza/OIw6dLVh9ICg0gogclmYGguQJWl8U30WpbsGTqbIiAwxTsbe76DErLq5EDQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
    <script src="../js/navigation_cms.js"></script>
</body>
</html>*