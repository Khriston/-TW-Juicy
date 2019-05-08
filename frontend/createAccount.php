<?php include_once ('../backend/createAccount.php'); ?>
<!DOCTYPE html>
<html lang="ro">
    <head>
        <title>Create Account</title>
        <link rel="stylesheet" href="../css/createAccount.css">
    </head>
    <body>
        <h1>SignUp</h1>
        <form action="createAccount.php" method="POST">
            <div class="formular">
                <div>
                    <label for="email"><b>Email: </b></label>
                    <input type="text" id="email" placeholder="email address" name="emailAddress" required>
                </div>
        
                <div>
                    <label for="firstName"><b>First name: </b></label>
                    <input type="text" id="firstName" placeholder="first name" name="firstName" required>
                </div>

                <div>
                <label for="lastName"><b>Last name: </b></label>
                <input type="text" id="lastName" placeholder="last name" name="lastName" required>
                </div>

                <div>
                    <label for="password"><b>Password: </b></label>
                    <input type="password" id="password" placeholder="password" name="password" required>
                </div>

                <div>
                    <label for="repeatPassword"><b>Repeat password: </b></label>
                    <input type="password" id="repeatPassword" placeholder="repeat password" name="repeatPassword" required>
                </div>

                <div>
                    <label for="address"><b>address</b></label>
                    <input type="text" id="address" placeholder="address" name="address" required>
                </div>
            </div>
            <div>
                <button type="submit">Submit</button>
                <a class="cancelButton" href="index.php">Cancel</a>
            </div>
            <div>
                <p>By creating an account you agree to our <a href="tp.html" style="color:blue">Terms & Privacy</a>.</p>
            </div>
        </form>
    </body>
</html>
