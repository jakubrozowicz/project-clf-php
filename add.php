<?php

session_start();
include('db.php');

$id = 0;

if(isset($_GET['id'])){
    $id = intval($_GET['id']);
}

if(isset($_POST['name'])){

    $succesValidation = true;
    $name = $_POST['name'];
    $declination = $_POST['declination'];
    $sex = $_POST['sex'];

    // WALIDACJA
    //walidacja pola Imię
    if(strlen($name)<3 || (strlen($name)>15))
    {
        $succesValidation = false;
        $_SESSION['error'] = '<div class="alert alert-danger" role="alert">Niepoprawne dane</div>';
    }

    if (!preg_match('/^[a-ząćęłńóśźż]+$/ui', $name)) {
        $succesValidation = false;
        $_SESSION['error'] = '<div class="alert alert-danger" role="alert">Niepoprawne dane</div>';
    }

    //walidacja pola Wołacz
    if(strlen($declination)<3 || (strlen($declination)>15))
    {
        $succesValidation = false;
        $_SESSION['error'] = '<div class="alert alert-danger" role="alert">Niepoprawne dane</div>';
    }

    if (!preg_match('/^[a-ząćęłńóśźż]+$/ui', $declination)) {
        $succesValidation = false;
        $_SESSION['error'] = '<div class="alert alert-danger" role="alert">Niepoprawne dane</div>';
    }

     // sprawdzenie czy płeć wybrana 
     if ($sex=="brak")
     {
        $succesValidation = false;
        $_SESSION['error'] = '<div class="alert alert-danger" role="alert">Niepoprawne dane</div>';
     }

     //sprawdzenie czy w bazie jest takie imię
     $sqlQeryName = "SELECT id FROM odmiana_imion WHERE name='$name'";
     $sqlrun = mysqli_query($connect, $sqlQeryName);
     $countNames = $sqlrun->num_rows;

      if ($countNames>0)
      {
        $succesValidation = false;
        $_SESSION['errorDb'] = '<div class="alert alert-danger" role="alert">Istnieje już taki rekord w bazie</div>';
      }

    //sprawdzenie czy w bazie jest taki wołacz
     $sqlQeryDeclination = "SELECT id FROM odmiana_imion WHERE declination='$declination'";
     $sqlrun = mysqli_query($connect, $sqlQeryDeclination);
     $countDeclinations = $sqlrun->num_rows;

      if ($countDeclinations>0)
      {
        $succesValidation = false;
        $_SESSION['errorDb'] = '<div class="alert alert-danger" role="alert">Istnieje już taki rekord w bazie</div>';
      }

     // KONIEC WALIDACJI

    if($id > 0 && $succesValidation==true){
        $sql = "UPDATE `odmiana_imion` SET `sex`='$sex',`name`='$name',`declination`='$declination' WHERE id = {$id}";
        $sqlrun = mysqli_query($connect, $sql);
        $_SESSION['succesUpdate'] = '<div class="alert alert-primary" role="alert">Edytowałeś dane w bazie!</div>';
        header('Location: list.php');
    
    }
    elseif($succesValidation==true) {
        $sql = "INSERT INTO `odmiana_imion`(`sex`, `name`, `declination`) VALUES ('$sex','$name','$declination')";
        $sqlrun = mysqli_query($connect, $sql);
        $_SESSION['succesInsert'] = '<div class="alert alert-primary" role="alert">Dodałeś imię do bazy!</div>';
        header('Location: list.php');
    }

}

if($id > 0){

    $sql = "SELECT * FROM odmiana_imion WHERE id={$id}";
    $sqlrun = mysqli_query($connect, $sql);
    $results = mysqli_fetch_assoc($sqlrun);

}

$nameValue="";
    if(isset($results['name'])){
    $nameValue = $results['name'];
    }

$declinationValue="";
    if(isset($results['declination'])){
    $declinationValue = $results['declination'];
    }

$options="";
    if(isset($results['sex'])){
    $options=$results['sex'];
    }

?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Odmiana imion</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/main.css">
</head>
<body>
    <div class="container-fluid">
        <form class="form" <?php 'action="add.php?id=' . $id . '"'?> method="post">
        <?php
                if(isset($_SESSION['error']))
                {   
                    echo $_SESSION['error'];
                    unset($_SESSION['error']);
                }

                if(isset($_SESSION['errorDb']))
                {   
                    echo $_SESSION['errorDb'];
                    unset($_SESSION['errorDb']);
                }
                ?>
                
            <?php
            if ($id > 0){
                echo '<input type="hidden" name="id" value="' . $id . '">';
            }
            ?>
            
            Imię: <input class="form-control" type="text" name="name" value="<?=$nameValue?>">
            Wołacz: <input class="form-control" type="text" name="declination" value="<?=$declinationValue?>">
            Wybierz płeć: <select class="form-control" name="sex">
                <option value="brak"<?php if($options=="brak") echo 'selected="selected"'; ?> >brak</option>
                <option value="K"<?php if($options=="K") echo 'selected="selected"'; ?> >K</option>
                <option value="M"<?php if($options=="M") echo 'selected="selected"'; ?> >M</option>
            </select>
            <br>
            <input type="submit" class="btn btn-md btn-success pull-right" value="Zapisz">
            <br><br>
            <a href="list.php">Pokaż listę wszystkich imion</a>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="js/bootstrap.min.js"></script>
</body>
</html>