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

        $email = 'email@gmail.com';
        //$email = $_SESSION['username'];

        $conn = DB::getConnection(DB_HOST, DB_NAME, DB_USERNAME, DB_PASSWORD);

        //if($_SESSION['seller'] == false){
        $stmt = $conn->prepare("SELECT id_client FROM clienti WHERE email=?;");
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $id_client = $row['id_client'];
        $result->close();
        /*} else{
            $stmt = $conn->prepare("SELECT * FROM vanzator WHERE email=?");
            $stmt->bind_param('s', $email);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            $id_client = $row['id_vanzator'];
            $result->close();
        }*/

        $stmt->close();
        $stmt = $conn->prepare("SELECT * FROM plateste_pentru WHERE id_client=?;");
        $stmt->bind_param('i', $id_client);
        $stmt->execute();
        $stmt->store_result();
        if($stmt->num_rows == 0) {
            $stmt->close();
            $id_lista_cumparaturi = $conn->insert_id;
            $stmt = $conn->prepare("INSERT INTO lista_cumparaturi(id_lista_cumparaturi) VALUES(?);");
            $stmt->bind_param('i', $id_lista_cumparaturi);
            $stmt->execute();
            $stmt->close();

            $result = $conn->query("SELECT * FROM lista_cumparaturi ORDER BY id_lista_cumparaturi DESC;");
            $row = $result->fetch_assoc();
            $id_lista_cumparaturi = $row['id_lista_cumparaturi'];
            $result->close();

            $stmt = $conn->prepare("INSERT INTO plateste_pentru(id_client, id_lista_cumparaturi) VALUES (?,?)");
            $stmt->bind_param('ii', $id_client, $id_lista_cumparaturi);
            $stmt->execute();

        } else{
            $stmt->close();
            $stmt = $conn->prepare("SELECT * FROM plateste_pentru WHERE id_client=?;");
            $stmt->bind_param('i', $id_client);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            $id_lista_cumparaturi = $row['id_lista_cumparaturi'];
            $result->close();
        }

        $stmt->close();
        $stmt = $conn->prepare("SELECT * FROM cantitate_cumparata WHERE id_lista_cumparaturi=? and id_produs=?;");
        $stmt->bind_param('ii', $id_lista_cumparaturi, $id_produs);
        $stmt->execute();
        $stmt->store_result();
        if($stmt->num_rows == 0) {
            $stmt->close();
            $stmt = $conn->prepare("INSERT INTO cantitate_cumparata(id_lista_cumparaturi, id_produs, cantitate) VALUES(?, ?, ?);");
            $cantitate = 1;
            $stmt->bind_param('iii', $id_lista_cumparaturi, $id_produs, $cantitate);
            $stmt->execute();
        } else{
            $stmt->close();
            $stmt = $conn->prepare("UPDATE cantitate_cumparata SET cantitate=cantitate+1 WHERE id_lista_cumparaturi=? and id_produs=?;");
            $stmt->bind_param('ii', $id_lista_cumparaturi, $id_produs);
            $stmt->execute();
        }
        header("Location: ../backend/catalogGenerator.php");
    } else{
        header("Location: ../frontend/index.php");
    }/*
} else{
    $errors['loggedin'] = 'You should login first!';
} */