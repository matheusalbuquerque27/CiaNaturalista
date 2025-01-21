<?php

$pdo = new PDO('mysql:hostname=localhost;dbname=CiaNat_DB', 'root', '');

if(isset($_GET['id'])){
    $id = $_GET['id'];
    $sql = $pdo->prepare("DELETE FROM `estoque` WHERE id=?");
    $sql->execute(array($id));

    header('Location: /CiaNaturalista/');
}

?>