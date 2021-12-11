<?php
$url = $_SERVER['REQUEST_URI'];

/* SORRY FÜR DEN LANGEN CODE, DIES WIRD SPÄTER BESSER AUSGELAGERT */

$indexPHPPosition = strpos($url,'index.php');
$baseUrl = $url;
//Damit auf jeder url der gleiche pfad ist.
if(false !== $indexPHPPosition){
  $baseUrl = substr($url,0,$indexPHPPosition);
}

if(substr($baseUrl,-1)!== '/'){
  $baseUrl.='/';
}
define('BASE_URL',$baseUrl);


$route = null;
if(false !== $indexPHPPosition){
  $route = substr($url,$indexPHPPosition);
  $route = str_replace('index.php','',$route);
}

$userId = getCurrentUserId();

$countCartItems = mengeProductCart($userId);
var_dump($route);

setcookie('userId',$userId,strtotime('+30 days'),$baseUrl);
//wen die url nicht für die startseite ist
if(!$route){
  $products = getAllProducts();
  
  require __DIR__.'/page/main_page.php';
  exit();
}
//wenn die route für in den warenkorn hinzufügen
if(strpos($route,'/cart/add/') !== false){
  $routeParts = explode('/',$route);
  $productId = (int)$routeParts[3];
  addProductToCart($userId,$productId);
  header("Location: ".$baseUrl."index.php");
  exit();
}
//wenn die route für den warenkorb
if(strpos($route,'/cart') !== false){
  $cartItems = getCartItemsForUserId($userId);
  $cartSum = getCartSumForUserId($userId);
  require __DIR__.'/page/warenkorb.php';
  exit();

}
//route für login
if(strpos($route,'/login') !==false){
  $isPost = isPost();
  $username="";
  $password="";
  //fehlermeldung
  $errors = [];
  $hasErrors = false;

  //wenn das formular abgeschickt wurde validierung
  if($isPost){
     //filter damit keine html tag eingeben können
    $username = filter_input(INPUT_POST,'username',FILTER_SANITIZE_SPECIAL_CHARS);
    $password = filter_input(INPUT_POST,'password');
    
    if(false ===(bool)$username){
      $errors[]="Username ist leer";
    }
    if(false ===(bool)$password){
      $errors[]="Passwort ist leer";
    }
    //username überprüfen aus der datenbank
    $userData = getUserDataForUsername($username);
    if((bool)$username && 0 === count($userData)){
      $errors[] = "Benutzename existiert nicht";
    }
    //passwort überprüfen aus der datenbank
    if((bool)$password &&
    isset($userData['password']) &&
    false === password_verify($password, $userData['password'])
    ){
      $errors[]="Passwort und Username sind nicht korrekt";
    }
    //wenn alles stimmt
    if(0 === count($errors)){
      $_SESSION['userId']=(int)$userData['id'];
      moveCartProductsToAnotherUser($_COOKIE['userId'],(int)$userData['id']);

      setcookie('userId',$userId,strtotime('+30 days'),$baseUrl);
      $redirectTarget = $baseUrl.'index.php';
      if(isset($_SESSION['redirectTarget'])){
      $redirectTarget = $_SESSION['redirectTarget'];
      }
      header("Location:".$redirectTarget);
      exit();
      

    }
  }
  $hasErrors = count($errors) > 0;
  require __DIR__.'/page/login.php';
  exit();

}
//route für checkout 
if(strpos($route,'/checkout') !==false){
  
  redirectIfNotLogget('/checkout');

  $empfaenger = "";
  $adresse ="";
  $stadt = "";
  $plz ="";
  $errors=[];
  $hasErrors= count($errors)>0;
  //felder rot markieren
  $empfaengerIsValid = true;
  $adresseIsValid = true;
  $stadtIsValid = true;
  $plzIsValid = true;
  //eingetragene lieferadresse
  $deliveryAddresses = getDeliveryAddressesForUser($userId);
  require __DIR__.'/page/lieferadresse.php';
  exit();
}
//für ausloggen 
if(strpos($route,'/logout') !==false){
 
  $redirectTarget = $baseUrl.'index.php';
  if(isset($_SESSION['redirectTarget'])){
    $redirectTarget = $_SESSION['redirectTarget'];
  }
  session_regenerate_id(true);
  session_destroy();
  header("Location:".$redirectTarget);
  exit();

}
//select lieferadresse
if(strpos($route,'/selectLieferadresse') !==false){
  //überprüfung ob man eingelogt ist
  redirectIfNotLogget('/selectLieferadresse');
  $routeParts = explode('/',$route);
  $lieferadresseId = (int)$routeParts[2];
  if(deliveryAddressBelongToUser($lieferadresseId,$userId)){
    $_SESSION['lieferadresseId'] = $lieferadresseId;
    header("Location: ".$baseUrl."index.php/selectPayment");
    exit();
  }
  header("Location: ".$baseUrl."index.php/checkout");
  exit();

  
}

//route für lieferadresse//alieferadresse speichern  
if(strpos($route,'/lieferadresse/add') !==false){
  //überprüfung ob man eingelogt ist
  redirectIfNotLogget('/lieferadresse/add');
 
  $emfaenger = "";
  $adresse ="";
  $stadt = "";
  $plz ="";
  //felder rot markieren
  $empfaengerIsValid = true;
  $adresseIsValid = true;
  $stadtIsValid = true;
  $plzIsValid = true;

  $isPost = isPost();
  $errors=[];
  $deliveryAddresses = getDeliveryAddressesForUser($userId);
  
  if($isPost){
    $empfaenger=filter_input(INPUT_POST,'empfaenger',FILTER_SANITIZE_SPECIAL_CHARS);
    $empfaenger = trim($empfaenger);
    $adresse=filter_input(INPUT_POST,'adresse',FILTER_SANITIZE_SPECIAL_CHARS);
    $adresse = trim($adresse);
    $stadt=filter_input(INPUT_POST,'stadt',FILTER_SANITIZE_SPECIAL_CHARS);
    $stadt = trim($stadt);
    $plz=filter_input(INPUT_POST,'plz',FILTER_SANITIZE_SPECIAL_CHARS);
    $plz = trim($plz);

    //validierung ob die felder eingegeben wurden. 
    if(!$empfaenger){
      $errors[]= "Bitte Empfänger eintragen";
      $emfaengerIsValid = false;
    }
    if(!$adresse){
      $errors[]= "Bitte eine Adresse eintragen";
      $adresseIsValid = false;
    }
    if(!$stadt){
      $errors[]= "Bitte eine Stadt eintragen";
      $stadtIsValid = false;
    }
    if(!$plz){
      $errors[]= "Bitte eine PLZ eintragen";
      $plzIsValid = false;
    }
  
    if(count($errors) === 0) {
      $lieferadresseId = saveLieferadresseForUser($userId,$empfaenger,$stadt,$plz,$adresse);
      if($lieferadresseId > 0){
        $_SESSION['lieferadresseId'] = $lieferadresseId;
        header("Location: ".$baseUrl."index.php/selectPayment");
        exit();
      }
      $errors[]= "Fehler beim Speichern der Lieferadresse";
    }
    $hasErrors = count($errors) > 0;
  }
  
  require __DIR__.'/page/lieferadresse.php';
  exit();
}
//route fpr selectpayment
if(strpos($route,'/selectPayment') !==false){
  redirectIfNotLogget('/selectPayment');
  //wenn keine session vorhanden ist
  if(!isset(($_SESSION['lieferadresseId']))){
    header("Location:".$baseUrl."index.php/checkout");
    exit();
  }
  $errors=[];
  //validierung ob auf rechnung oder paypal für value 
  $avaliablePaymentMethods = [
    "paypal" => "PayPal",
    "rechnung" =>"Rechnung"
  ];

  if(isPost()){
    //ist eine auswahl gewählt worden
    $paymentMethod = filter_input(INPUT_POST,'paymentMethod',FILTER_SANITIZE_STRING);

    if(!$paymentMethod){
      $errors[]="Bitte eine Bezahlmethode auswählen";
    }
    if($paymentMethod && !in_array($paymentMethod,array_keys($avaliablePaymentMethods))){
      $errors[]="Ungültige Auswahl";
    }
    $deliveryAddressData = getDeliveryAddressDataForUser($_SESSION['lieferadresseId'],getCurrentUserId());
    if(!$deliveryAddressData){
      $errors[]="Ausgewählte Lieferadresse wurde nicht gefunden";
    }
    $cartProducts = getCartItemsForUserId(getCurrentUserId());
    if(count($cartProducts)===0){
      $errors[]="Warenkorb ist leer";
    }
    //wenn keine fehlermeldung kommt
    if(count($errors) === 0){
      $functionName = $paymentMethod.'CreateOrder';
      $_SESSION['paymentMethod'] = $paymentMethod;
      //header("Location: " . $baseUrl . "index.php/selectPayment");
      $_SESSION['paymentMethod'] = $paymentMethod;
     
      call_user_func_array($functionName,[$deliveryAddressData,$cartProducts]);
    } 
  }
    $hasErrors = count($errors) > 0;
    require __DIR__.'/page/selectPayment.php';
    exit();
}
  
if(strpos($route,'/paymentComplete') !==false){
  redirectIfNotLogget('/checkout');
  if(!isset($_SESSION['paymentMethod']));{
    header("Location:".BASE_URL."index.php/paymentComplete");
    exit();
  }
  $userId = getCurrentUserId();
  $cartItems = getCartItemsForUserId($userId);
  $cartSum = getCartSumForUserId($userId);

  require __DIR__.'/page/checkoutOverview.php';
  exit();
}
//bestellung abschliessen
if(strpos($route,'/completeOrder') !==false){
  redirectIfNotLogget('/checkout');
  if(!isset($_SESSION['paymentMethod']));{
    header("Location:".BASE_URL."index.php/paymentComplete");
    exit();
  }
  $userId = getCurrentUserId();
  $cartItems = getCartItemsForUserId($userId);
  if(createOrder($userId, $cartItems)){
    clearCartForUser($userId);
    require __DIR__.'/page/thankYouPage.php';
    exit();
  }
}







