<?php
session_start();
//datenbank verbindung
define('CONFIG_DIR',__DIR__.'/config');
require_once ('function/database.php');

//login daten
$username ="dana";
$password = password_hash("test",PASSWORD_DEFAULT);

//variablen für username und passwort
$sql ="INSERT INTO kunde SET
username='".$username."',
password='".$password."'";

$statement = getDb()->execute($sql);

