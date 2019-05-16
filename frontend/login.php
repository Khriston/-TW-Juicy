<?php include_once('../backend/login.php'); ?>
<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="../css/login.css">
    </head>
    <body>

        <div id="id01" class="modal">
            
            <form class="modalContent animation">
                <div class="Login">
                    <h1>Login</h1>
                    <span onclick="document.getElementById('id01').style.display='none'" class="close" title="closeModal">&times</span>
                </div>

                <div class="formular">
                    <label for="email"><b>Username: </b></label>
                    <input type="text" placeholder="Enter Email" name="email" required>
                </div>
                <div>
                    <label for="password"><b>Password: </b></label>
                    <input type="password" placeholder="Enter Password" name="passd" required>
                </div>
                <div>
                    <button type="submit" formaction="../backend/login.php" formmethod="POST">Login</button>
                </div>
                
                <div class="container" style="background-color: #f1f1f1">
                    <div><button type="button" onclick="document.getElementById('id01').style.display='none'" class="cancelButton">Cancel</button></div>
                    <div><a type="button" href="createAccount.php">Create Account</a></div>
                </div>
            </form>
        </div>

        <script>
            var modal = document.getElementById('id01');
            window.onclick = function(event){
                if(event.target==modal){
                    modal.style.display = 'none';
                }
            }
        </script>
    </body>
</html>
