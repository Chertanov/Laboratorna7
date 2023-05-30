<?php
try{
    $dsn = "mysql:host=localhost;dbname=lb_pdo_goods";
    $user="root";
    $password="";
    $dbh = new PDO($dsn, $user, $password);
}catch(PDOException $ex){
    echo $ex->GetMessage();
}
