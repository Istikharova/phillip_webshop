<?php
//produkte aus der Datenbank

function getAllProducts(){
    $sql="SELECT id,titel,beschreibung,preis,bild
    FROM product";

    $result = getDB()->query($sql);
    if(!$result){
        return [];
    }
    $products = [];
    while($row = $result->fetch()){
        $products[]=$row;

    }

    return $products;
}