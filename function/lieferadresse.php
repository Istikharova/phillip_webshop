<?php
function saveLieferadresseForUser(int $userId, string $empfaenger, string $stadt, string $plz, $adresse):int{
    $sql = "INSERT INTO adresse
           SET kunde_id = :userId,
           empfaenger = :empfaenger,
           adresse = :adresse,
           stadt = :stadt,
           plz = :plz
           ";

    $statement = getDB()->prepare($sql);
        if(false === $statement){
            return 0;
        }
    $statement-> execute([
        ':userId'=> $userId,
        ':empfaenger' => $empfaenger,
        ':stadt' => $stadt,
        ':plz' => $plz,
        ':adresse' => $adresse
    ]);
    return(int)getDB()->lastInsertId();
}
//hier speichet nur eine adresse von einem user
function getDeliveryAddressDataForUser(int $lieferadresseId,int $userId): ?array{
    $sql = "SELECT id,empfaenger,adresse, plz, stadt
    FROM adresse
    WHERE kunde_id =:userId
    AND id=:lieferadresseId
    LIMIT 1";

    $statement = getDB()->prepare($sql);
    if(false === $statement){
    return null;
    }


    $statement->execute([':userId' => $userId,':lieferadresseId' => $lieferadresseId]);
    $address = $statement->fetch();  
    
    return $address;  


}

//damit die adressen von einem user gespeichert sind 
function getDeliveryAddressesForUser(int $userId):array{
    $sql = "SELECT id, empfaenger,adresse, stadt, plz
            FROM adresse
            WHERE kunde_id =:userId";

    $statement = getDB()->prepare($sql);
        if(false === $statement){
            return [];
        }

    $addresses = [];

    $statement->execute([':userId' => $userId]);

    while($row = $statement->fetch()){
        $addresses[]=$row;
    }

    return $addresses;
}

//überprüfung ob die lieferadresseid existiert und ob es zum user passt
function deliveryAddressBelongToUser(int $lieferadresseId, int $userId):bool{
    $sql = "SELECT id
            FROM adresse
            WHERE kunde_id = :userId AND id = :lieferadresseId";

    $statement = getDB()->prepare($sql);
     if(false === $statement){
         return false;
    }
    $statement->execute(
        [':userId' => $userId,
         ':lieferadresseId' => $lieferadresseId
        ]
    );   

    return (bool)$statement->rowCount();
}