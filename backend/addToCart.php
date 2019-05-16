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

//if($_SESSION['loggedin'] == true){
    if(isset($_GET['id_produs']) && !empty($_GET['id_produs'])){
        $id_produs = $_GET['id_produs'];

        $email = 'adresa@gmail.com';
        //$email = $_SESSION['username'];

        //if($_SESSION['seller'] == false){
        $stmt = $conn->prepare("SELECT * FROM clienti WHERE email=?;");
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $result = $result->fetch_assoc();
        $id_client = $result['id_client'];
        /*} else{
            $stmt = $conn->prepare("SELECT * FROM vanzator WHERE email=?");
            $stmt->bind_param('s', $email);
            $stmt->execute();
            $result = $stmt->get_result();
            $result = $result->fetch_assoc();
            $id_client = $result['id_vanzator'];
        }*/

        $conn = DB::getConnection(DB_HOST, DB_NAME, DB_USERNAME, DB_PASSWORD);

        $stmt = $conn->prepare("SELECT * FROM plateste_pentru WHERE id_client=?;");
        $stmt->bind_param('i', $id_client);
        $stmt->execute();
        if($stmt->num_rows == 0) {
            $id_lista_cumparaturi = $conn->insert_id;
            $stmt = $conn->prepare("INSERT INTO lista_cumparaturi(id_lista_cumparaturi) VALUES(?);");
            $stmt->bind_param('i', $id_lista_cumparaturi);
            $stmt->execute();
            $result = $conn->query("SELECT * FROM lista_cumparaturi ORDER BY id_lista_cumparaturi DESC LIMIT 1;");
            $result = $result->fetch_assoc();
            $id_lista_cumparaturi = $result['id_lista_cumparaturi'];

            $stmt = $conn->prepare("INSERT INTO plateste_pentru(id_client, id_lista_cumparaturi) VALUES(?, ?);");
            $stmt->bind_param('ii', $id_client, $id_lista_cumparaturi);
            $stmt->execute();
        } else{
            $result = $stmt->get_result();
            $result = $result->fetch_assoc();
            $id_lista_cumparaturi = $result['id_lista_cumparaturi'];
        }

        $stmt = $conn->prepare("SELECT * FROM cantitate_cumparata WHERE id_lista_cumparaturi=? and id_produs=?;");
        $stmt->bind_param('ii', $id_lista_cumparaturi, $id_produs);
        $stmt->execute();
        if($stmt->num_rows == 0) {
            $stmt = $conn->prepare("INSERT INTO cantitate_cumparata(id_lista_cumparaturi, id_produs, cantitate) VALUES(?, ?, ?);");
            $cantitate = 1;
            $stmt->bind_param('iii', $id_lista_cumparaturi, $id_produs, $cantitate);
            $stmt->execute();
        } else{
            $stmt = $conn->prepare("UPDATE cantitate_cumparata SET cantitate=cantitate+1 WHERE id_lista_cumparaturi=? and id_produs=?;");
            $stmt->bind_param('ii', $id_lista_cumparaturi, $id_produs);
            $stmt->execute();
        }
    } else{
        header("Location: ../frontend/catalog.php");
    }/*
} else{
    $errors['loggedin'] = 'You should login first!';
}
