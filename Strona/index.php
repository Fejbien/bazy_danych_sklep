<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <title>OLX dla gorszych</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php
    $db = new mysqli("localhost", "root", "", "shop");

    if(isset($_POST["out"])){
        if($_POST["out"] == 1){
            setcookie("userID", NULL);
            header('Location: index.php');
        }
    }

    if(!isset($_COOKIE["userID"])){
        if(isset($_POST["login"]) && isset($_POST["password"])){
            $sql = "SELECT `id` FROM `account` WHERE `login`='".$_POST["login"]."' AND `password`='".md5($_POST["password"])."';";

            if($res = $db->query($sql))
                if(mysqli_num_rows($res) != 0){
                    $logedID = $res->fetch_assoc()["id"];
                    setcookie("userID", $logedID);
                    header('Location: index.php');
                }

        }

        echo "
            <form method='POST' action='index.php'>
                <label>Login</label><input type='text' name='login'></br>
                <label>Haslo</label><input type='password' name='password'></br>
                <input type='submit' value='Zaloguj'>
            </form>
        ";

        echo "<a href='register.php'>Zarejestruj sie!</a>";
    }
    else{
        $sql = "SELECT `name` FROM `account` WHERE `id`=".$_COOKIE["userID"].";";
        $name = $db->query($sql)->fetch_assoc()["name"];

        echo "
            <form method='POST' action='index.php'>
                <input type='hidden' name='out' value='1'>
                <input type='submit' value='Wyloguj'>
            </form>
        ";

        echo "<h1>".$name."</h1>";


        $sql = "SELECT `name`, `price` FROM `item` WHERE `seller` =".$_COOKIE["userID"].";";
        $res = $db->query($sql);
        echo "<h3>Twoje oferty: </h3>";
        if(mysqli_num_rows($res) == 0){
            echo "Nie masz jeszcze zadnych ofert!";
        }
        else{
            echo "<ol>";
            while($row = $res->fetch_assoc()){
                echo "<li>".$row["name"]." : ".$row["price"]."PLN</li>";
            }
            echo "</ol>";
        }
    }

    $db->close();
    ?>
</body>
</html>