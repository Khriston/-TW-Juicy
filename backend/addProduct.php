<?php
/**
 * Created by PhpStorm.
 * User: Gheoca Victor Manuel
 * Date: 5/3/2019
 * Time: 9:43 AM
 */

include_once ('../database/database.php');
include_once ('../database/config.php');
session_start();

$errors = array(
    'name' => '',
    'flavor' => '',
    'price' => '',
    'path' => ''
);

    if (isset($_POST['productName']) && !empty($_POST['productName'])) {
        if (isset($_POST['flavours']) && !empty($_POST['flavours'])) {
            if (isset($_POST['price']) && !empty($_POST['price'])) {
                if (isset($_POST['submit'])) {
                    $productName = $_POST['productName'];
                    $flavours = $_POST['flavours'];
                    $price = $_POST['price'];
                    $file = $_FILES['file'];

                    $fileName = $file['name'];

                    $fileTokens = explode('.', $fileName);
                    $fileExtension = strtolower(end($fileTokens));

                    $allowed = array('jpeg', 'png', 'jpg');

                    if(in_array($fileExtension, $allowed)){
                        if($file['error'] === 0){
                            if($file['size'] < 1000000){
                                $email = $_SESSION['username'];

                                $newFileName = $email . '_' . $productName . '_' . $fileName;
                                $fileDestination = 'products/'.$newFileName;

                                move_uploaded_file($file['tmp_name'], $fileDestination);

                                $conn = DB::getConnection(DB_HOST, DB_NAME, DB_USERNAME, DB_PASSWORD);
                                $stmt = $conn->prepare("SELECT id_vanzator FROM vanzator WHERE email = ?;");
                                $stmt->bind_param('s', $email);
                                $stmt->execute();
                                $result = $stmt->get_result();
                                $row = $result->fetch_assoc();
                                $id = $row['id_vanzator'];

                                $stmt = $conn->prepare("INSERT INTO produse(id_vanzator, nume, pret, acidulat, arome, path_poza) VALUES(?, ?, ?, ?, ?, ?);");
                                $sour = $_POST['sour'] == 'Yes' ? 1 : 0;
                                $stmt->bind_param('isiiss', $id, $productName, $price, $sour, $flavours, $newFileName);
                                $check = $stmt->execute();

                                header("Location: ../frontend/index.php");
                                if(! $check){
                                    echo 'Database error!';
                                }
                            } else{
                                $errors['path'] = 'Your photo is too big!';
                            }
                        } else{
                            $errors['path'] = 'There was an error uploading your file!';
                        }
                    } else{
                        $errors['path'] = 'The file should have png, jpg or jpeg extension!';
                    }
                } else {
                    $errors['path'] = 'Please select a representative photo!';
                }
            } else {
                $errors['price'] = 'Please select a price!';
            }
        } else {
            $errors['flavor'] = 'Please select some flavours!';
        }
    } else {
        $errors['name'] = 'Please select a name!';
    }
