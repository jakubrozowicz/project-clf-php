<?php

session_start();
include('db.php');

$id = 0;

if(isset($_GET['id'])){
    $id = intval($_GET['id']);
}

if($id > 0){
    $sql = "DELETE FROM odmiana_imion WHERE id = {$id}";
    $sqlrun = mysqli_query($connect, $sql);
    $_SESSION['succesDelete'] = '<div class="alert alert-primary" role="alert">Rekord w bazie został usunięty!</div>';
    header('Location: list.php');
} else {
    header('Location: list.php');
}