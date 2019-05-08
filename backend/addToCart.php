<?php
/**
 * Created by PhpStorm.
 * User: Gheoca Victor Manuel
 * Date: 5/7/2019
 * Time: 12:55 PM
 */

include_once ('../database/config.php');
include_once ('../database/database.php');

$errors = array(
    'loggedin' => ''
);

if($_SESSION['loggedin'] == true){
    if(isset($_GET['id']) && !empty($_GET['id'])){
        $product_id = $_GET['id'];

    } else{
        header("Location: ../frontend/catalog.php");
    }
} else{
    $errors['loggedin'] = 'You should login first!';
}