<?php
function getCurrentUserId(){
    $userId = random_int(0,time());
    if(isset($_COOKIE['userId'])){
      $userId = (int) $_COOKIE['userId'];
    }
    if(isset($_SESSION['userId'])){
      $userId = (int) $_SESSION['userId'];
    }
    return $userId;
}
function getUserDataForUsername(string $username):array{
  $sql="SELECT id,password
        FROM kunde
        WHERE username=:username";

        $statement = getDb()->prepare($sql);
        if(false ===$statement){
          return [];
        }
        $statement->execute([
          ':username'=>$username
        ]);
        if(0 === $statement->rowCount()){
          return[];
        }
        $row = $statement->fetch();
        return $row;

}
function isLogIn():bool{
  return isset($_SESSION['userId']);
}