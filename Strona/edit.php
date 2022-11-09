<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <title>OLX dla gorszych</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php
    $db = new mysqli("localhost", "root", "", "shop");

    $sql = "SELECT `seller` FROM `item` WHERE `id`=".$_GET["item"].";";
    $sellerId = $db->query($sql)->fetch_assoc()["seller"];

    echo "<a href='index.php'>Powrot</a>";
    if(!isset($_COOKIE["userID"]) || $_COOKIE["userID"] != $sellerId){
        echo "<h1>Brak dostepu!</h1>";
    }
    else{
        $sql = "SELECT `name` FROM `account` WHERE `id`=" . $_COOKIE["userID"] . ";";
        $name = $db->query($sql)->fetch_assoc()["name"];    
        echo "<h1>" . $name . "</h1>";

        if(isset($_POST["name"]) && isset($_POST["price"]) && isset($_POST["description"])){
            $sql = "UPDATE `item` SET `name`='".$_POST["name"]."',`price`='".$_POST["price"]."',`description`='".$_POST["description"]."' WHERE `id` =".$_GET["item"].";";
            $db->query($sql);
        }

        $sql = "SELECT i.id, i.name, i.price, i.description, i.created_at, i.sold_at, a.name as `seller_name`, b.name as`buyer_name` FROM item AS i JOIN ACCOUNT AS a ON a.id = i.seller LEFT JOIN account as b ON b.id = i.buyer WHERE i.id=".$_GET["item"].";";
        $offer = $db->query($sql)->fetch_assoc();
        echo "<form method='POST'>";
        echo "<label></label><input type='text' name='name' value='".$offer["name"]."'></br>";
        echo "<label></label><input type='numeric' name='price' value='".$offer["price"]."'></br>";
        echo "<label></label><input type='text' name='description' value='".$offer["description"]."' style='min-width: 500px;'></br>";
        echo "<p>Offered at: ".$offer["created_at"]."</p>";
        echo "<p>Seller: ".$offer["seller_name"]."</p>";
        echo "<input type='submit' value='Zmien dane!'>";
        echo "</form>";
    }

    $db->close();
    ?>
</body>

</html>