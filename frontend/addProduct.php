<!DOCTYPE html>
<html lang="ro">
<head>
    <title>Create Account</title>
    <link rel="stylesheet" href="../css/addProduct.css">
</head>
<body>
<h1>addProduct</h1>
    <form action="../backend/addProduct.php" method="POST" enctype="multipart/form-data">
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
                <input type="number" id="price" placeholder="price" name="price" required>
            </div>

            <div>
                <label for="sour"><b>Sour </b></label>
                <input type="checkbox" id="sour" name="sour">
            </div>

            <div>
                <label for="file"><b>Photo </b></label>
                <input type="file" id="file" name="file">
            </div>

            <div>
                <label for="quantity"><b>Initial quantity: </b></label>
                <input type="number" id="quantity" name="quantity" min="50" required>
            </div>

        </div>
        <div>
            <button type="submit" name="submit">Submit</button>
            <a class="cancelButton" href="index.php">Cancel</a>
        </div>
    </form>
</body>
</html>

