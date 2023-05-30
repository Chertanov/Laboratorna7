<?php
include('database_connect.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script>
        let ajax = new XMLHttpRequest();
        function get1(){
            
            let vendorName = document.getElementById("vendor_name").value;
            ajax.onreadystatechange = load1;
            ajax.open("GET", "1st_task.php?vendor_name=" + vendorName, false);
            ajax.send();
        };

        function get2(){
            
            let categoryName = document.getElementById("category_name").value;
            ajax.onreadystatechange = load2;
            ajax.open("POST", "2nd_task.php");
            ajax.setRequestHeader("Content-type","application/x-www-form-urlencoded");
            ajax.send("category_name="+categoryName);
        };

        function get3(){
            
            let priceRange = document.getElementById("price_range").value;
            ajax.onreadystatechange = load3;
            ajax.open("POST", "3rd_task.php");
            ajax.setRequestHeader("Content-type","application/x-www-form-urlencoded");
            ajax.send("price_range="+priceRange);
        };

        function load1(){
            if(ajax.readyState === 4){
                if(ajax.status === 200){
                    console.dir(ajax);
                    document.getElementById("result1").innerHTML = ajax.response;
                }
            }
        };

        function load2(){
            if(ajax.readyState === 4){
                if(ajax.status === 200){
                    console.dir(ajax);
                    let categoryInfo = ajax.responseXML.firstChild.childNodes;
                    let res2 = "<tr><th colspan=4>Товари обраної категорії</th></tr>\
                    <tr><td>Назва товару</td><td>Ціна</td><td>Кількість</td><td>Якість</td></tr>";
                    for(let i = 0; i< categoryInfo.length; i++){
                        let name = categoryInfo[i].childNodes[0];
                        let price = categoryInfo[i].childNodes[1];
                        let quantity = categoryInfo[i].childNodes[2];
                        let quality = categoryInfo[i].childNodes[3];
                        res2+="<tr><th>" + name.textContent + "</th><th>"+price.textContent + "</th><th>"+ quantity.textContent + "</th><th>"+ quality.textContent +"</th><tr>";
                    }

                    document.getElementById("result2").innerHTML = res2;
                }
            }
        };

        function load3(){
            if(ajax.readyState === 4){
                if(ajax.status === 200){
                    console.dir(ajax);
                    let priceInfo = JSON.parse(ajax.responseText);
                    console.dir(priceInfo);
                    let res3 = "<tr><th colspan=4>Товари обраної цінової категорії</th></tr>\
                    <tr><td>Назва товару</td><td>Ціна</td><td>Кількість</td><td>Якість</td></tr>";
                    for(let i in priceInfo){
                        res3+="<tr><th>" + priceInfo[i].name + "</th><th>"+ priceInfo[i].price + "</th><th>"+ priceInfo[i].quantity + "</th><th>"+ priceInfo[i].quality +"</th><tr>";
                    }

                    document.getElementById("result3").innerHTML = res3;
                }
            }
        };
    </script>
    <title>Товари в магазині </title>
</head>
<body>
        <label for="vendor_name">Please, choose vendor name:</label></br>
        <select name="vendor_name" id="vendor_name">
            <?php
            try{
                foreach($dbh->query('SELECT DISTINCT v_name from vendors') as $row){
                    echo "<option value='$row[0]'>$row[0]</option>";
                }
            }catch(PDOException $ex){
                echo $ex->GetMessage();
            }
            ?>
        <input type=button value="Get!" id="first_task" onclick="get1()"></input>
    <table border='1'>
    <tbody id="result1">
    </tbody>
    </table>
    </br>
    </br>
        <label for="category_name">Please, choose category name:</label></br>
        <select name="category_name" id="category_name">
            <?php
            try{
                foreach($dbh->query('SELECT DISTINCT c_name from category') as $row){
                    echo "<option value='$row[0]'>$row[0]</option>";
                }
            }catch(PDOException $ex){
                echo $ex->GetMessage();
            }
            ?>
        <input type=button value="Get!" id="second_task" onclick="get2()"></input>

    <table border='1'>
    <tbody id="result2">
    </tbody>
    </table>
    </br>
    </br>
    <label for="price_range">Please, choose price range:</label></br>
        <select name="price_range" id="price_range">
            <option value=999>1000-1499</option>
            <option value=1500>1500-1999</option>
            <option value=2000>2000-2499</option>
            <option value=2500>2500+</option>
        <input type=button value="Get" onclick="get3()"></input>
    <table border='1'>
    <tbody id="result3">
    </tbody>
    </table>
</body>
</html>