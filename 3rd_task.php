<?php
header('Content-Type: application/json'); 
header("Cache-Control: no-cache, must-revalidate");

$price = $_REQUEST["price_range"];
$hprice = $price + 499;
if ($hprice == 2999)
    $hprice = 9999;

include("database_connect.php");

try{
    $sqlSelect = "select name, price, quantity, quality from items where price >= :category and price <= $hprice";
    

    $sth = $dbh->prepare($sqlSelect);
    $sth -> bindValue(":category", $price);
    $sth->execute();
    $res = $sth->fetchAll(PDO::FETCH_OBJ);
    
    //$data = array();
    //$data = array (array ( 'name' => 'Монитор 17"', 'price' => 333, 'quantity' => 20, 'quality' => 4 ),array ( 'name' => 'Ram4bg', 'price' => 999, 'quantity' => 111, 'quality' =>3333 ));
    /*foreach($res as $doc){
        
        array_push($data, array('name' => $doc['name'], 'price' => $doc['price'], 'quantity' => $doc['quantity'], 'quality' => $doc['quality']));
    }*/
    //print_r($data);
    echo json_encode($res);



    /*echo "<table border='1'>";
    if ($hprice == 9999)
        echo "<tr><th colspan=4>Товари ціною від $price</th></tr>";
    else
    echo "<tr><th colspan=4>Товари ціною від $price до $hprice</th></tr>";
    echo "<tr><td>Назва товару</td><td>Ціна</td><td>Кількість</td><td>Якість</td></tr>";
    foreach($res as $row){
        echo "<tr><td>$row[0]</td><td>$row[1]</td><td>$row[2]</td><td>$row[3]</td></tr>";
    }
    echo "</table>";*/
}catch(PDOException $ex){
    echo $ex->GetMessage();
}
