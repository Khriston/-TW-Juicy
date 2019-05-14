<?php
/**
 * Created by PhpStorm.
 * User: Gheoca Victor Manuel
 * Date: 5/3/2019
 * Time: 12:12 PM
 */

include_once ('../database/config.php');
include_once ('../database/database.php');

$error = '';

if(isset($_POST['emailSeller']) && !empty(['emailSeller'])){
    $email = $_POST['emailSeller'];
    $cod = rand(100000, 999999);
    $password = md5($cod);

    $conn = DB::getConnection(DB_HOST, DB_NAME, DB_USERNAME, DB_PASSWORD);
    $stmt = $conn->prepare("SELECT * FROM vanzator WHERE email=?;");
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows == 0){
        $stmt = $conn->prepare("INSERT INTO vanzator(id_vanzator, email, parola) VALUES(?, ?, ?)");
        $id_vanzator = $conn->insert_id;
        $stmt->bind_param('iss', $id_vanzator, $email, $cod);
        $check = $stmt->execute();

        if($check){
            $from = "juicyprojectb2@gmail.com";
            $subject = "Password";
            $message = "Buna ziua! \n Parola dumneavoastra este: " . $cod;
            $headers = "From: " . $from;
            mail($email, $subject, $message, $headers);
        } else{
            echo 'Database error!';
        }

        header('location:../frontend/index.php');

    } else {
        $error = 'This email is already in use!';
    }

    $stmt->close();
} else{
    $error = 'Please insert your email first!';
}