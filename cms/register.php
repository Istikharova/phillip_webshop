<?php
session_start();
require_once('config/config.php');
require_once('function/utilities.php');

require_once('function/notLogIn.php');

$queryUsers = "SELECT * FROM admins";
$resultUsers = mysqli_query($conn, $queryUsers);
if(mysqli_num_rows($resultUsers) > 0){
    while($rowUsers = mysqli_fetch_assoc($resultUsers)) { 
        $users [] = [
            'admin_name' => $rowUsers['admin_name'],
            'admin_email' => $rowUsers['admin_email']
        ];
    }
    
} else {
    die("No results.");
} 
/* registration Form */

$statement = "";
$validationErrorUsername = "";
$validationErrorMail = "";
$validationErrorPW = "";
$validationErrorPWMatch = "";

// check if submit-button is clicked
if(isset($_POST['submit'])) {
    // if yes, desinfect user inputs
	$registration_user = desinfect($_POST['register_username']); 
    $email = desinfect($_POST['email']);
    $registration_password = desinfect($_POST['register_password']);
    $confirm_password = desinfect($_POST['confirm_password']);

    $registrationUserValue = $registration_user;
    $emailValue = $email;
    $registrationPasswordValue = $registration_password;
    $confirmPasswordValue = $confirm_password;

    // check if username field is empty
    if(empty($registration_user)) {
        $validationErrorUsername = "<ul role=\"alert\"><li>Bitte gib den gewünschten Usernamen ein.</li></ul>";
    // else check if username contains illegal characters
    } else if (!preg_match('/^[-a-z0-9_]+$/i', $registration_user))  {
        $validationErrorUsername= "<ul role=\"alert\"><li>Der Username darf keine Sonderzeichen beinhalten, nur Bindestrich (-) oder Unterstrich (_) sind erlaubt.</li></ul>";
    } else if (strlen($registration_user) < 3 || strlen($registration_user) > 30) {
        $validationErrorUsername= "<ul role=\"alert\"><li>Der Username muss mindestens 3 und darf höchstens 30 Zeichen lang sein.</li></ul>";
    } else {
        // check if username is already taken
        $queryLogin = "SELECT * FROM `admins` WHERE `admin_name`=?";
        
        $stmt = mysqli_prepare($conn, $queryLogin);
        mysqli_stmt_bind_param($stmt, 's', $registration_user); 
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $numRows = mysqli_num_rows($result); 
        

        if($numRows == 1) {
            $userdata = mysqli_fetch_assoc($result);
            $validationErrorUsername = "<ul role=\"alert\"><li>Dieser Username ist bereits vergeben!</li></ul>";
        }                 
    }

    // check if email field is empty
    if(empty($email)){
        $validationErrorMail = "<ul role=\"alert\"><li>Bitte gib die gewünschte E-Mail-Adresse ein.</li></ul>";
    // else check if email address is valid
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $validationErrorMail = "<ul role=\"alert\"><li>Bitte gib eine gültige E-Mail-Adresse ein.</li></ul>";
    }
    
    // check if password field is empty
    if(empty($registration_password)){
        $validationErrorPW = "<ul role=\"alert\"><li>Bitte gib das gewünschte Passwort ein.</li></ul>";
    // else check if password contains at least one letter, at least one number, and be longer than six characters - source regex: https://regexlib.com/REDetails.aspx?regexp_id=770
    } else if (!preg_match('/^(?=.*[0-9]+.*)(?=.*[a-zA-Z]+.*)[0-9a-zA-Z]{6,50}$/', $registration_password)) {
        $validationErrorPW = "<ul role=\"alert\"><li>Passwort muss mindestens 6 Zeichen lang sein und mindestens eine Zahl enthalten.</li></ul>";
        $validationErrorPWMatch = "<ul role=\"alert\"><li>Passwort muss mindestens 6 Zeichen lang sein und mindestens eine Zahl enthalten.</li></ul>";
    } 

    // check if confirm password field is empty
    if(empty($confirm_password)){
        $validationErrorPWMatch = "<ul role=\"alert\"><li>Bitte gib das gleiche Passwort nochmals ein.</li></ul>";
    // else check if password matches
    } else if ($registration_password !== $confirm_password) {
        $validationErrorPWMatch = "<ul role=\"alert\"><li> Die Passwörter stimmen nicht überein!</li></ul>";
        $validationErrorPW = "<ul role=\"alert\"><li> Die Passwörter stimmen nicht überein!</li></ul>";
    } 

    // if no validation errors, insert new user data to database
    if(!$validationErrorUsername && !$validationErrorMail && !$validationErrorPW && !$validationErrorPWMatch) {
        $password_hash = password_hash($registration_password, PASSWORD_DEFAULT);  
	
        $query = "INSERT INTO `admins` (`admin_name`, `admin_email`, `admin_password`) VALUES (?, ?, ?)";
        
        $statement = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($statement, 'sss', $registration_user, $email, $password_hash); 
        mysqli_stmt_execute($statement);

        

        // send confirmation email to new user
        $to = $email; // new user mail
        $email_subject = "Registrierungsbestätigung für Phillipsshop";
        $email_body = "Welcome $registration_user! Du wurderst erfolgreich für das Adminbereich von Phillipsshop angemeldet. .\n Klicke auf folgenden Link um dich einzuloggen: <a href=\"login\">Login CMS</a>\n Viel Spass! :)";
        $headers = "From: dana@bluewin.ch\n"; // This is the email address the generated message will be from.
        $headers .= 'Content-type: text/plain; charset=iso-8859-1'; // text/html
        // mail($to,$email_subject,$email_body,$headers); // funktionur nur mit einem activen mailserver
    }  
} else {
    $registrationUserValue = "";
    $emailValue = "";
    $registrationPasswordValue = "";
    $confirmPasswordValue = "";
}
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <!-- head -->
<?php include("includes/head.html")?>
<!-- Bootstrap and css -->
<link rel="stylesheet" href="../css/register.css">
<title>Registrieren | Phillips Steinfiguren</title>
</head>
<body>
<!-- nav -->
<?php include("includes/nav_cms.inc.php")?> 
<!-- header --> 
<header class="container-lx d-flex align-items-center">
    <div class= "container ">
      <div>
        <h1 class="display-1 pt-2" >Admin hinzufügen</h1>
        <div>
          <p class="ms-4">Registriere hier neue Benutzer für dieses CMS.</p>
        </div>
      </div>
    </div>
</header>
<section id="registration" class="container">
    <div class="row">
        <div class="col-lg-5 col-md-10 mx-auto py-5">
            <h2 class="text-center mt-3 h1">Registration</h2>
            <?php 
                if($statement) { 
                    echo "<p class=\"alert alert-success\"><strong><u>Registrierung erfolgreich!</u><br>In Kürze wird der neue Benutzer ein Mail mit den Zugangsdaten erhalten.</strong></p>";
                } 
                ?>
            <form action="register.php" method="Post" novalidate>
                <div class="control-group">
                    <div class="form-group floating-label-form-group controls ">
                        <label for="username">Username</label>
                        <input type="text" class="form-control bg-light border shadow-none" name="register_username" id="register_username" value="<?=$registrationUserValue?>" placeholder="Username">
                        <div class="help-block text-danger"><?=$validationErrorUsername?></div>
                    </div>
                </div>
                <div class="control-group">
                    <div class="form-group floating-label-form-group controls">
                        <label for="email">E-Mail-Adresse</label>
                        <input type="email" class="form-control bg-light border shadow-none" name="email" id="email" value="<?=$emailValue?>"placeholder="E-Mail-Adresse">
                    <div class="help-block text-danger"><?=$validationErrorMail?></div>
                </div>
                <div class="control-group">
                    <div class="form-group floating-label-form-group controls">
                        <label for="password">Passwort</label>
                        <input type="password" class="form-control bg-light border shadow-none" name="register_password" id="register_password" value="" placeholder="Passwort">
                        <div class="help-block text-danger"></div>
                    </div>
                </div>
                <div class="control-group">
                    <div class="form-group floating-label-form-group controls">
                        <label for="confirm_password">Passwort bestätigen</label>
                        <input type="password" class="form-control bg-light border shadow-none" name="confirm_password" id="confirm_password" value="<?=$registrationPasswordValue?>" placeholder="Passwort bestätigen">
                        <div class="help-block text-danger"><?=$validationErrorPW?></div>
                    </div>
                </div>
            <button type="submit" class="btn btn-outline-light mt-3 mb-5" name="submit">Registrieren</button>
            </form>
        </div>
    </div>
</section>
<section class="user">
<div class="row">
    <div class="col-lg-8 col-md-12 mx-auto">
        <h2 class="text-center h1" id="users_anchor">Admins</h2>
        <br>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="thead-light">
                <tr>
                    <th scope="col"></th>
                    <th scope="col">Username</th>
                    <th scope="col">Email</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($users as $key => $value) { ?>
                <tr>
                    <th scope="row"></th>
                    <td><p><?=($value['admin_name'])?></p></td>
                    <td><p><?=($value['admin_email'])?></p></td>
                </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</section>

<!-- footer -->
<?php include("../includes/footer.inc.html")?>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js" integrity="sha512-bnIvzh6FU75ZKxp0GXLH9bewza/OIw6dLVh9ICg0gogclmYGguQJWl8U30WpbsGTqbIiAwxTsbe76DErLq5EDQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
  <script src="../js/navigation_cms.js"></script>
</body>
</html>