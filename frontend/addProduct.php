<?php include_once('../backend/addProduct.php'); ?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <title>Create Account</title>
    <link rel="stylesheet" href="../css/addProduct.css">
</head>
<body>
<h1>addProduct</h1>
<form action="addProduct.php" method="POST">
    <div class="formular">
        <div>
            <label for="productName"><b>Juice name: </b></label>
            <input type="text" id="productName" placeholder="product name" name="productName" required>
        </div>

        <div>
            <label for="flavor"><b>Flavors: </b></label>
            <input type="text" id="productFlavours" placeholder="flavour1, flavour2, ..." name="flavours" required>
        </div>

        <div>
            <label for="price"><b>Password: </b></label>
            <input type="text" id="price" placeholder="price" name="price" required>
        </div>

        <div>
            <label for="sour"><b>Sour </b></label>
            <input type="checkbox" id="sour" name="sour" required>
        </div>

        <div>
            <label for="file"><b>Photo </b></label>
            <input type="file" id="file" name="file">
        </div>

    </div>
    <div>
        <button type="submit">Submit</button>
        <a class="cancelButton" href="index.php">Cancel</a>
    </div>
</form>
</body>
</html>

