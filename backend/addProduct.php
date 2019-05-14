<?php
/**
 * Created by PhpStorm.
 * User: Gheoca Victor Manuel
 * Date: 5/3/2019
 * Time: 9:43 AM
 */

include_once ('../database/database.php');
include_once ('../database/config.php');

$errors = array(
    'name' => '',
    'flavor' => '',
    'price' => '',
    'path' => '',
    'quantity' => ''
);

//if($_SESSION['loggedin'] == true and $_SESSION['seller'] == true) {
    if (isset($_POST['productName']) && !empty($_POST['productName'])) {
        if (isset($_POST['flavours']) && !empty($_POST['flavours'])) {
            if (isset($_POST['price']) && !empty($_POST['price'])) {
                if(isset($_POST['quantity']) && !empty($_POST['quantity'])){
                    if (isset($_POST['submit'])) {
                        $productName = $_POST['productName'];
                        $flavours = $_POST['flavours'];
                        $price = $_POST['price'];
                        $file = $_FILES['file'];
                        $quantity = $_POST['quantity'];

                        $fileName = $file['name'];

                        $fileTokens = explode('.', $fileName);
                        $fileExtension = strtolower(end($fileTokens));

                        $allowed = array('jpeg', 'png', 'jpg');

                        if (in_array($fileExtension, $allowed)) {
                            if ($file['error'] === 0) {
                                if ($file['size'] < 1000000) {
                                    $email = $_SESSION['username'];

                                    $newFileName = $email . '_' . $productName . "." . $fileExtension;
                                    $fileDestination = 'products/' . $newFileName;

                                    move_uploaded_file($file['tmp_name'], $fileDestination);

                                    $conn = DB::getConnection(DB_HOST, DB_NAME, DB_USERNAME, DB_PASSWORD);
                                    $stmt = $conn->prepare("SELECT id_vanzator FROM vanzator WHERE email = ?;");
                                    $stmt->bind_param('s', $email);
                                    $stmt->execute();
                                    $result = $stmt->get_result();
                                    $row = $result->fetch_assoc();
                                    $id_seller = $row['id_vanzator'];

                                    $stmt = $conn->prepare("INSERT INTO produse(id_vanzator, nume, pret, acidulat, arome, path_poza) VALUES(?, ?, ?, ?, ?, ?);");
                                    $sour = isset($_POST['sour']) ? 1 : 0;
                                    $stmt->bind_param('isiiss', $id_seller, $productName, $price, $sour, $flavours, $newFileName);
                                    $check = $stmt->execute();

                                    if (!$check) {
                                        echo 'Database error!';
                                    }

                                    $stmt = $conn->prepare("SELECT id_produs FROM produse WHERE id_vanzator=? and nume=?;");
                                    $stmt->bind_param('is', $id_seller, $productName);
                                    $stmt->execute();
                                    $result = $stmt->get_result();
                                    $row = $result->fetch_assoc();
                                    $id_product = $row['id_produs'];

                                    $stmt = $conn->prepare("INSERT INTO detine(id_vanzator, id_produs, cantitate) VALUES(?, ?, ?);");
                                    $stmt->bind_param('iii', $id_seller, $id_product, $quantity);
                                    $check = $stmt->execute();

                                    if (!$check) {
                                        echo 'Database error!';
                                    }

                                    header("Location: ../frontend/index.php");
                                } else {
                                    $errors['path'] = 'Your photo is too big!';
                                }
                            } else {
                                $errors['path'] = 'There was an error uploading your file!';
                            }
                        } else {
                            $errors['path'] = 'The file should have png, jpg or jpeg extension!';
                        }
                    } else {
                        $errors['path'] = 'Please select a representative photo!';
                    }
                } else{
                    $errors['quantity'] = 'You need at least 50 pieces to sell!';
                }
            } else {
                $errors['price'] = 'Please select a price!';
            }
        } else {
            $errors['flavor'] = 'Please select some flavours!';
        }
    } else {
        $errors['name'] = 'Please select a name!';
    }/*
} else{
    $errors['name'] = 'You must be a seller to upload products!';
}
