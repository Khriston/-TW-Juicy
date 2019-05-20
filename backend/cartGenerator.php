<!DOCTYPE html>
<html lang="ro">

<?php
/**
 * Created by PhpStorm.
 * User: Lenovo
 * Date: 5/16/2019
 * Time: 8:18 AM
 */

include_once('../database/config.php');
include_once('../database/database.php');
include_once('../frontend/menu.php');

/*if($_SESSION['loggedin'] == true)
    header("Location: ../frontend/index.php");
*/
?>

<head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="../css/catalog.css">
    <title>Juicy</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../css/login.css">
</head>
<body>
    <header>
        <h1>Catalog sucuri</h1>
    </header>
    <div class="container">
        <div class="row">
            <?php
                $conn = DB::getConnection(DB_HOST, DB_NAME, DB_USERNAME, DB_PASSWORD);
                $result_produse = $conn->query("SELECT * FROM produse;");

                while($row = $result_produse->fetch_assoc()){
                    $path = "\"" . "../backend/products/" . $row['path_poza'] . "\"";
                    $nume = $row['nume'];
                    $pret = $row['pret'];
                    $arome = $row['arome'];
                    $id_produs = $row['id_produs'];
                    $adauga_in_cos = "\"" . "../backend/addToCart.php?id_produs=$id_produs" . "\"";

                    $stmt = $conn->prepare("SELECT * FROM detine WHERE id_produs=?;");
                    $stmt->bind_param('i', $id_produs);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $row = $result->fetch_assoc();
                    $quantity = $row['cantitate'];
                    $result->close();

                    $sold_out = $quantity == 0 ? true : false;
                    ?>
                    <div class="column">
                        <div class="card">
                            <a class="button">
                                <img src=<?php echo $path?> alt=<?php echo $nume?> style="width:100%">
                            </a>
                            <h2> <?php echo $nume ?> </h2>
                            <?php if($sold_out == false) {
                                ?> <p class="Pret"><?php echo $pret ?> LEI </p> <?php
                            } else{
                                ?> <p class="soldOut">SOLD OUT</p> <?php
                            }
                            ?>
                            <p><?php echo $arome ?></p>
                            <?php if($sold_out == false) {
                                ?> <p><a class="btn btn-primary" href=<?php echo $adauga_in_cos?>>Adauga in cos</a></p> <?php
                            } ?>
                        </div>
                    </div>
            <?php
                }
            ?>
        </div>
    </div>
</body>
</html>

