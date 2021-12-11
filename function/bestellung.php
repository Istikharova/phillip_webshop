<?php
function createOrder(int $userId, array $cartItems, string $stat = 'new'):bool{
    $sql = "INSERT INTO bestellungen SET 
            stat = :stat,
            kunde_id = :userId";
    $statement = getDB()->prepare($sql);
    $data = [
        ':stat' => $stat,
        'orderDate' => $orderDate,
        ':userId' => $userId
    ];
    $statement->execute($data);
    $bestellungId = getDB()->lastInsertId();

    $sql="INSERT INTO order_products SET
         titel = :titel,
         menge = :menge,
         preis = :preis,
         bestellungen_id = :bestellungenId;
         ";
    $statement = getDB()->prepare($sql);
    foreach($cartItems as $cartItem){
        $data= [
            ':titel' =>$cartItem['titel'],
            ':menge' =>$cartItem['menge'],
            ':preis' =>$cartItem['preis'],
            ':bestellungenId' =>$bestellungenId
        ];
    $statement->execute($data);
    }
    return true;
}