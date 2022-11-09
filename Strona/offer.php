<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <title>OLX dla gorszych</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php
    function showItem($db){
        $sql = "SELECT i.id, i.name, i.price, i.description, i.created_at, i.sold_at, a.name as `seller_name`, b.name as`buyer_name` FROM item AS i JOIN ACCOUNT AS a ON a.id = i.seller LEFT JOIN account as b ON b.id = i.buyer WHERE i.id=".$_GET["item"].";";
        $offer = $db->query($sql)->fetch_assoc();
        echo "<h1>Name: ".$offer["name"]."</h1>";
        echo "<h2>Price: ".$offer["price"]."PLN</h1>";
        echo "<p>Description: ".$offer["description"]."</p>";
        echo "<p>Offered at: ".$offer["created_at"]."</p>";
        echo "<p>Seller: ".$offer["seller_name"]."</p>";
    }

    $db = new mysqli("localhost", "root", "", "shop");

    if(!isset($_COOKIE["userID"])){
        echo "<h1>Nie jestesc zalogowany zaloguj sie!</h1>";
        showItem($db);
    }
    else{
        $sql = "SELECT `name` FROM `account` WHERE `id`=" . $_COOKIE["userID"] . ";";
        $name = $db->query($sql)->fetch_assoc()["name"];    
        echo "<h1>" . $name . "</h1>";

        showItem($db);
    }

    $db->close();
    ?>
</body>

</html>