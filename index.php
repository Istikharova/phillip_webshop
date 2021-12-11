<?php
session_start();
//datenbank verbindung
define('CONFIG_DIR',__DIR__.'/config');
require_once ('function/database.php');
//von einem Kunden sein Produkt im warenkorb anzeigen
require_once('function/shoppingcart.php');
//funtionen für der warenkorb
require_once('function/kunde.php');
//produkte
require_once('function/product.php');
//form post
require_once('function/utilities.php');
//lieferadresse
require_once('function/lieferadresse.php');
//bestellungen
require_once('function/bestellung.php');
//zahlung
require_once('function/payed.php');
//url route
require_once('route.php');


$userId = getCurrentUserId();






