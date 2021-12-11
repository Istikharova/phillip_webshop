<?php
//von einem Kunden sein Produkt im warenkorb anzeigen 
function addProductToCart(int $userId,int $productId,int $menge = 1){
    $sql ="INSERT INTO shoppingcart 
           SET menge=:menge, kunde_id  = :userId, product_id = :productId
           ON DUPLICATE KEY UPDATE menge= menge +1";
    $statement = getDB()->prepare($sql);
  
    $statement->execute([
      ':userId'=> $userId,
      ':productId' => $productId,
      ':menge' => $menge
    ]);
}

function mengeProductCart(int $userId){
  $sql="SELECT COUNT(id) FROM shoppingcart WHERE kunde_id =".$userId;
  $cartResults = getDb()->query($sql);
  

  $cartItems = $cartResults->fetchColumn();
  return $cartItems;
}

//funtkion, produkte von einem user
function getCartItemsForUserId(int $userId):array{
  $sql="SELECT product_id,titel,beschreibung,preis,menge
        FROM shoppingcart
        JOIN product ON(shoppingcart.product_id = product.id)
        WHERE kunde_id =".$userId;
  $results = getDb()->query($sql);
  if($results ===false){
    return[];
  }
  $found = [];
  while($row = $results->fetch()){
    $found[]=$row;
  }
  return $found;

}
//total preis für produkte 
function getCartSumForUserId(int $userId):int{
  $sql="SELECT SUM(preis * menge)
        FROM shoppingcart
        JOIN product ON(shoppingcart.product_id = product.id)
        WHERE kunde_id = ".$userId;
  $result = getDb()->query($sql);
  //wenn der kunde keine artikel im warenkorb hat
  if($result === false){
    return 0;
  }
  return(int)$result->fetchColumn();
}
//löschen der Produkte aus dem warenkorb
 function deleteProductInCartForUserId(int $userId,int $productId):int{
  $sql = "DELETE FROM shoppingcart
  WHERE kunde_id = :userId
  AND product_id = :productId";

  $statement = getDb()->prepare($sql);
  if (false === $statement) {
  return 0;
}
  return $statement->execute(
    [
      ':userId' =>$userId,
      ':productId' => $productId]
  );
 }
//produkte bleiben erhalten im warenkorb nach dem einlogen
function moveCartProductsToAnotherUser(int $sourceUserId, int $targetUserId):int{
  //wenn keine produkte enthalten sind im warenkorb
  $oldCartItems = getCartItemsForUserId($sourceUserId);
  if(count($oldCartItems) === 0){
    return 0;
  }

   //wenn produkte enthalten sind
  $moveProducts = 0;

  foreach($oldCartItems as $oldCartItem){
    addProductToCart($targetUserId,$oldCartItem['product_id'],(int)$oldCartItem['menge']);
     // $moveProducts += deleteProductInCartForUserId($sourceUserId,(int)$oldCartItem['product_id']);
  }
  return $moveProducts;
  
}
//nach bestellen warenkorb leeren
function clearCartForUser(int $userId){
  $sql= "DELETE FROM shoppingcart WHERE kunde_id =:userId";
  $statement = getDB()->prepare($sql);
  $statement->execute([':userId' => $userId]);

}