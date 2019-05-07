<?php
/**
 * Created by PhpStorm.
 * User: Lenovo
 * Date: 5/4/2019
 * Time: 9:51 AM
 */

include_once ('../database/config.php');
include_once ('../database/database.php');

$file = "../frontend/catalog.php";
$catalog = fopen($file, 'w');

$title = "
    <?php include_once('menu.php');?>
    <!DOCTYPE html>
    <html lang=\"ro\">
    <head>
	    <meta charset=\"utf-8\">
	    <link rel=\"stylesheet\" type=\"text/css\" href=\"../css/catalog.css\">
		<title>Juicy</title>
		<meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">
		<link rel=\"stylesheet\" href=\"../css/login.css\">
    </head>
    <body>
        <header>
	        <h1>Catalog sucuri</h1>
	    </header>
	    <div class=\"container\">
	        <div class=\"row\">";

fwrite($catalog, $title);

$conn = DB::getConnection(DB_HOST, DB_NAME, DB_USERNAME, DB_PASSWORD);
$stmt = $conn->prepare("SELECT * FROM produse;");
$stmt->execute();
$result = $stmt->get_result();

while($row = $result->fetch_assoc()){
    $path = "../backend/products/" . $row['path_poza'];
    $nume = $row['nume'];
    $pret = $row['pret'];
    $arome = $row['arome'];
    $item = "
             <div class=\"column\">
                    <div class=\"card\">
                        <a class=\"button1\" href=\"DetaliiCola.html\">
                            <img src=\"$path\" alt=\"$nume\" style=\"width:100%\">
                        </a>
                        <h2> $nume</h2>
                        <p class=\"Pret\">$pret LEI</p>
                        <p>$arome</p>
                        <p><button class=\"cart\">Adauga in cos</button></p>
                    </div>
			  </div>";

    fwrite($catalog, $item);
}

$end = "
        </div>
	</div>
  </body>
</html>
";

fwrite($catalog, $end);


header('Location: ../frontend/catalog.php');