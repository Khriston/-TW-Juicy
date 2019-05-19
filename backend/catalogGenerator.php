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
                $result = $conn->query("SELECT * FROM produse;");

                while($row = $result->fetch_assoc()){
                    $path = "\"" . "../backend/products/" . $row['path_poza'] . "\"";
                    $nume = $row['nume'];
                    $pret = $row['pret'];
                    $arome = $row['arome'];
                    $id_produs = $row['id_produs'];
                    $adauga_in_cos = "\"" . "../backend/addToCart.php?id_produs=$id_produs" . "\"";

                    ?>
                    <div class="column">
                        <div class="card">
                            <a class="button">
                                <img src=<?php echo $path?> alt=<?php echo $nume?> style="width:100%">
                            </a>
                            <h2> <?php echo $nume ?> </h2>
                            <p class="Pret"><?php echo $pret ?> LEI </p>
                            <p><?php echo $arome ?></p>
                            <p><a class="btn btn-primary" href=<?php echo $adauga_in_cos?>>Adauga in cos</a></p>
                        </div>
                    </div>
            <?php
                }
            ?>
        </div>
    </div>
</body>
</html>

