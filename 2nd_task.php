<?php
header('Content-Type: text/xml; charset=utf8');
header("Cache-Control: no-cache, must-revalidate");


$category_name = $_REQUEST["category_name"];

include("database_connect.php");

try{
    $sqlSelect = "select name, price, quantity, quality from items join category on items.FID_Category=category.ID_Category where category.c_name = :category;";
    

    $sth = $dbh->prepare($sqlSelect);
    $sth -> bindValue(":category", $category_name);
    $sth->execute();
    $res = $sth->fetchAll();

    //echo "<table border='1'>";
    echo "<?xml version='1.0' encoding='utf8'?>";
    echo "<root>";
    foreach($res as $row){
        echo "<categoryInfo><name>$row[0]</name><price>$row[1]</price><quantity>$row[2]</quantity><quality>$row[3]</quality></categoryInfo>";
    }
    echo "</root>";
    //echo "</table>";
}catch(PDOException $ex){
    echo $ex->GetMessage();
}
