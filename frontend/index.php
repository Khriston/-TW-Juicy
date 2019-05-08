<?php include_once('menu.php');
      include_once('../backend/addSeller.php');
      ?>
<!DOCTYPE html>
<html lang="ro">

<head>
    <meta charset="utf-8">
    <title>Juicy</title>
    <link rel="stylesheet" href="../css/main.css"> 
    <link rel="stylesheet" href="../css/login.css">
</head>

<body>
    <h1>Juicy</h1>

    <h2>Welcome !</h2>
    <p id="p1">Using our web service you can preview drinks that are available for purchase.</p>
    <p id="p2">We also provide information regarding the respective drinks, such as price, the energy value, ingredients. </p>

    <form action="../backend/addSeller.php" method="POST">
        <div>
            <h1>Become a seller! </h1>
            <input type="text" id="addSeller" placeholder="your email here" name="emailSeller">
        </div>
        <div>
            <button type="submit">Submit</button>
        </div>
    </form>
    <a href = "addProduct.php" methods="POST">add product</a>
    <footer>Project by UAIC Students</footer>

</body>

</html>
