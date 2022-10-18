<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Document</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/main.css">
</head>
<body>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="js/bootstrap.min.js"></script>
</body>
</html>

<?php
session_start();
include('db.php');

if(isset($_SESSION['succesInsert']))
{
    echo $_SESSION['succesInsert'];
    unset ($_SESSION['succesInsert']);
}

if(isset($_SESSION['succesUpdate']))
{
    echo $_SESSION['succesUpdate'];
    unset ($_SESSION['succesUpdate']);
}

if(isset($_SESSION['succesDelete']))
{
    echo $_SESSION['succesDelete'];
    unset ($_SESSION['succesDelete']);
}

$sql = "SELECT * FROM odmiana_imion";
$sqlrun = mysqli_query($connect, $sql);
$results = mysqli_fetch_all($sqlrun, MYSQLI_ASSOC);
$counter = $sqlrun->num_rows;

echo '<div class="container-fluid">';
echo '<b>Lista imion: </b><br><br>';
echo '<table class="table table-striped">';

    echo '<tr>';
        echo '<th>ID: </th>';
        echo '<th>Płeć: </th>';
        echo '<th>Imię: </th>';
        echo '<th>Wołacz: </th>';
        echo '<th>Opcje: </th>';
    echo '</tr>';


    foreach ($results as $result)
    {
        echo '<tr>';
        echo '<td >' . $result["id"] . '</td>';
        echo '<td>' . $result["sex"] . '</td>';
        echo '<td>' . $result["name"] . '</td>';
        echo '<td>' . $result["declination"] . '</td>';
        echo '<td><a href="delete.php?id=' . $result["id"] . '">Usuń</a> | <a href="add.php?id=' . $result["id"] . '">Edytuj</a></td>';
        echo '</tr>';
    }

echo '<tr><th colspan="5">Łączna liczba rekordów: ' . $counter . '</th></tr>';
echo '</table>';
echo '<a href="add.php">Dodaj nowe imię do bazy</a>';
echo '<br><br><br>';
echo '</div>';