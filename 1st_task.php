<?php

$vendor_name = $_GET["vendor_name"];
include('database_connect.php');

try{
    

    $sqlSelect = "select name, price, quantity, quality from items join vendors on items.FID_Vendor=vendors.ID_Vendors where vendors.v_name = :vendor;";
    

    $sth = $dbh->prepare($sqlSelect);
    $sth -> bindValue(":vendor", $vendor_name);
    $sth->execute();
    $res = $sth->fetchAll(PDO::FETCH_NUM);

    //echo "<table border='1'>";
    echo "<tr><th colspan=4>Товари поставника $vendor_name</th></tr>";
    echo "<tr><td>Назва товару</td><td>Ціна</td><td>Кількість</td><td>Якість</td></tr>";
    foreach($res as $row){
        echo "<tr><td>$row[0]</td><td>$row[1]</td><td>$row[2]</td><td>$row[3]</td></tr>";
    }
    //echo "</table>";
}catch(PDOException $ex){
    echo $ex->GetMessage();
}
