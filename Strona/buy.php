<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <title>OLX dla gorszych</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php
    $db = new mysqli("localhost", "root", "", "shop");

    $sql = "SELECT `name`, `seller` FROM `item` WHERE `id`=".$_POST["item"].";";
    $sellerId = $db->query($sql)->fetch_assoc()["seller"];
    $nameOfItem = $db->query($sql)->fetch_assoc()["name"];

    echo "<a href='index.php'>Powrot</a>";
    if(!isset($_COOKIE["userID"])){
        echo "<h1>Brak dostepu!</h1>";
    }
    else if($_COOKIE["userID"] == $sellerId){
        echo "<h1>Nie mozesz kupic wlasnego przedmiotu</h1>";
    }
    else{
        if(isset($_POST["afformation"]) && $_POST["afformation"] == 1){
            $sql = "UPDATE `item` SET `sold_at`='".date("Y-m-d")."', `buyer`='".$_COOKIE["userID"]."' WHERE `id` ='".$_POST["item"]."';";
            $db->query($sql);
            echo "<br>Kupionne ".$nameOfItem."!";
        } 
        else{
            $sql = "SELECT `name` FROM `account` WHERE `id`=" . $_COOKIE["userID"] . ";";
            $name = $db->query($sql)->fetch_assoc()["name"];    
            echo "<h1>" . $name . "</h1>";

            $sql = "SELECT i.id, i.name, i.price, i.description, i.created_at, i.sold_at, a.name as `seller_name`, b.name as`buyer_name` FROM item AS i JOIN ACCOUNT AS a ON a.id = i.seller LEFT JOIN account as b ON b.id = i.buyer WHERE i.id=".$_POST["item"].";";
            $offer = $db->query($sql)->fetch_assoc();
            echo "<h1>Name: ".$offer["name"]."</h1>";
            echo "<h2 style='font-size: 200%;'>Price: ".$offer["price"]."PLN</h1>";
            echo "<p>Description: ".$offer["description"]."</p>";
            echo "<p>Offered at: ".$offer["created_at"]."</p>";
            echo "<p>Seller: ".$offer["seller_name"]."</p>";
            if($offer["buyer_name"] != null && $offer["sold_at"] != null){
                echo "<p>Buyer: ".$offer["buyer_name"]."</p>";
                echo "<p>Bought at: ".$offer["sold_at"]."</p>";
            }

            echo "
                <form method='POST'>
                    <input type='hidden' name='item' value='".$_POST["item"]."'>
                    <input type='hidden' name='afformation' value='1'>
                    <input type='submit' value='Kupuje na pewno!'>
                </form>
            ";
        }
    }

    $db->close();
    ?>
</body>

</html>