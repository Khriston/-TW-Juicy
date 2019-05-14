<?php
/**
 * Created by PhpStorm.
 * User: Gheoca Victor Manuel
 * Date: 4/27/2019
 * Time: 1:04 PM
 */

include_once ('../database/config.php');
include_once ('../database/database.php');

$errors = array(
    'email' => '',
    'name' => '',
    'surname' => '',
    'password' => '',
    'repeatPassword' => '',
    'address' => ''
);

$email = '';
$name = '';
$surname = '';
$password = '';
$secondPassword = '';
$address = '';

if(isset($_POST['emailAddress']) and !empty($_POST['emailAddress'])){
    if(isset($_POST['firstName']) and !empty($_POST['firstName'])){
        if(isset($_POST['lastName']) and !empty($_POST['lastName'])){
            if(isset($_POST['password']) and !empty($_POST['password'])){
                if(isset($_POST['repeatPassword']) and !empty($_POST['repeatPassword'])){
                    if(isset($_POST['address']) and !empty($_POST['address'])){
                        $email = $_POST['emailAddress'];
                        $name = $_POST['firstName'];
                        $surname = $_POST['lastName'];
                        $password = $_POST['password'];
                        $secondPassword = $_POST['repeatPassword'];
                        $address = $_POST['address'];
                        
                        if(strpos($email, '@')){
                            if($password == $secondPassword){
                                if(strlen($password) > 5){
                                    $password = md5($password);

                                    $conn = DB::getConnection(DB_HOST, DB_NAME, DB_USERNAME, DB_PASSWORD);
                                    $stmt = $conn->prepare("SELECT * FROM clienti WHERE email=?;");
                                    $stmt->bind_param('sss', $email, $name, $password);
                                    $stmt->execute();
                                    $result = $stmt->get_result();
                                    if($result->num_rows == 0){
                                        $id = $conn->insert_id;
                                        $stmt = $conn->prepare("INSERT INTO clienti(id_client, adresa, email, nume, prenume, parola) VALUES(?, ?, ?, ?, ?, ?);");
                                        $stmt->bind_param('isssss', $id, $address, $email, $name, $surname, $password);
                                        $check = $stmt->execute();

                                        if(! $check){
                                            echo 'Database error!';
                                        }
                                    } else{
                                        $errors['email'] = 'Email already in use';
                                    }

                                    $stmt->close();
                                } else{
                                    $errors['password'] = 'Your password should be at least 6 characters long!';
                                }
                        } else{
                                $errors['password'] = 'Passwords don\'t correspond!';
                            }
                        } else{
                            $errors['email'] = 'Invalid email address';
                        }
                    } else{
                        $errors['address'] = "Please insert your address!";
                    }
                } else{
                    $errors['repeatPassword'] = 'Please insert your password!';
                }
            } else{
                $errors['password'] = 'Please insert your password!';
            }
        } else{
            $errors['surname'] = 'Please insert your last name!';
        }
    } else{
        $errors['name'] = 'Please insert your first name!';
    }
} else{
    $errors['email'] = 'Please insert your email address!';
}

?>
