<?php 

//funktion für post form
function isPost():bool{
    return strtoupper($_SERVER['REQUEST_METHOD']) ==='POST';
}

//escape damit die werte im input felder bleiben
function escape(string $value):string{
    return htmlspecialchars($value, ENT_QUOTES,'UTF-8');
}
//überprüfung ob eingelogt ist
function redirectIfNotLogget(string $sourceTarget){
    if(isLogIn()){
        return;
    }
    $_SESSION['redirectTarget'] = BASE_URL.'index.php'.$sourceTarget;
    header("Location: ".BASE_URL."index.php/login");
    exit();

}