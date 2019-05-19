<!DOCTYPE html>
<html lang="ro">
<?php
/**
 * Created by PhpStorm.
 * User: Gheoca Victor Manuel
 * Date: 5/14/2019
 * Time: 9:17 AM
 */

include_once('../database/config.php');
include_once('../database/database.php');
include_once('../frontend/menu.php')
?>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width">
        <link rel="stylesheet" type="text/css" href="../css/cart.css">
    </head>
    <body>
        <header>
            <h1 class="main_title">Juicy</h1>
        </header>

        <div class="cart">
            <div class="title">Your Cart</div>
            <?php
                $conn = DB::getConnection(DB_HOST, DB_NAME, DB_USERNAME, DB_PASSWORD);
                $user_name = $_SESSION['username'];
                $stmt = $conn->prepare('SELECT id_client FROM clienti WHERE email=?;');
                $stmt->bind_param('s', $user_name);
                $stmt->execute();
                $result = $stmt->get_result();
                $row = $result->fetch_assoc();
                $id_client = $row['id_client'];
                $result->close();
                $stmt->close();

                $stmt = $conn->prepare("SELECT id_lista_cumparaturi FROM plateste_pentru WHERE id_client=?;");
                $stmt->bind_param('i', $id_client);
                $stmt->execute();
                $result = $stmt->get_result();
                $row = $result->fetch_assoc();
                $id_lista_cumparaturi = $row['id_lista_cumparaturi'];
                $result->close();
                $stmt->close();

                $stmt = $conn->prepare("SELECT * FROM cantitate_cumparata WHERE id_lista_cumparaturi=?;");
                $stmt->bind_param('i', $id_lista_cumparaturi);
                $stmt->execute();
                $result_lista_cumparaturi = $stmt->get_result();

                while($row = $result_lista_cumparaturi->fetch_assoc()){
                    $id_produs = $row['id_produs'];
                    $quantity = "\"" . $row['cantitate'] . "\"";

                    $stmt->close();
                    $stmt = $conn->prepare("SELECT * FROM produse WHERE id_produs=?;");
                    $stmt->bind_param('i', $id_produs);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $row = $result->fetch_assoc();

                    $name  = $row['nume'];
                    $price = $row['pret'];
                    $arome = $row['arome'];
                    $img_path = "\"" . "../backend/products/" . $row['path_poza'] . "\"";
                    $sour = $row['acidulat'] == 1 ? 'acidulat' : 'neacidulat';
                    ?>
                    <html>
                    <div class="item">
                        <div class="buttons">
                            <span class="delete-btn"></span>
                            <span class="like-btn"></span>
                        </div>

                        <div class="image">
                            <img src=<?php echo $img_path?> alt="" />
                        </div>

                        <div class="description">
                            <span><?php echo $name ?></span>
                            <span><?php echo $arome ?></span>
                            <span><?php echo $sour ?></span>
                        </div>

                        <div>
                            <input type="number" name="quantity" value=<?php echo $quantity ?>>
                        </div>

                        <div class="total-price"><?php echo $price ?> Lei</div>
                    </html>
                    <?php
                }
            ?>
        </div>
        <div class="checkout-btn">
            <span><a href="checkout.html">Check out</a></span>
        </div>
        </div>

        <footer>Project by UAIC Students</footer>
    </body>
</html>
