<?php
/**
 * Created by PhpStorm.
 * User: Gheoca Victor Manuel
 * Date: 5/1/2019
 * Time: 9:12 AM
 */

include_once ('../database/config.php');
include_once ('../database/database.php');

$errors = array(
  'email' => '',
  'password' => ''
);

if(isset($_POST['email']) && !empty($_POST['email'])){
    if(isset($_POST['passd']) && !empty($_POST['passd'])){
        $email = $_POST['email'];
        $password = $_POST['passd'];
        $conn = DB::getConnection(  DB_HOST, DB_NAME, DB_USERNAME, DB_PASSWORD);
        $stmt = $conn->prepare("SELECT * FROM clienti WHERE email=? and parola=?;");
        $stmt->bind_param('ss', $email, $password);
        $stmt->execute();
        $result = $stmt->get_result();
        if($result->num_rows > 0){
            session_start();
            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $email;
        }
    } else{
        $errors['passd'] = 'Please insert your password!';
    }
} else{
    $errors['email'] = 'Please insert your email!';
}
