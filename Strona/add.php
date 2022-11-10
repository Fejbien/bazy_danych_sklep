<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <title>OLX dla gorszych</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php
    $db = new mysqli("localhost", "root", "", "shop");

    echo "<a href='index.php'>Powrot</a>";
    if(!isset($_COOKIE["userID"])){
        echo "<h1>Brak dostepu!</h1>";
    }
    else{
        $sql = "SELECT `name` FROM `account` WHERE `id`=" . $_COOKIE["userID"] . ";";
        $name = $db->query($sql)->fetch_assoc()["name"];    
        echo "<h1>" . $name . "</h1>";
        echo "Dodawanie ofert: ";

        if(isset($_POST["name"]) && isset($_POST["price"]) && isset($_POST["description"]) && !empty($_POST["name"]) && !empty($_POST["price"]) && !empty($_POST["description"])){
            $sql = "INSERT INTO `item`(`id`, `name`, `price`, `description`, `created_at`, `sold_at`, `seller`, `buyer`) VALUES (NULL, '".$_POST['name']."', '".$_POST['price']."','".$_POST['description']."','".date("Y-m-d")."',NULL ,'".$_COOKIE['userID']."', NULL);";
            $db->query($sql);
            echo "Dodano oferte!";
        }

        echo "<form method='POST'>";
        echo "<label>Nazwa</label><input type='text' name='name'></br>";
        echo "<label>Cena</label><input type='numeric' name='price'></br>";
        echo "<label>Opis</label><input type='text' name='description' style='min-width: 500px;'></br>";
        echo "<input type='submit' value='Dodaj oferte!'>";
        echo "</form>";
    }

    $db->close();
    ?>
</body>

</html>