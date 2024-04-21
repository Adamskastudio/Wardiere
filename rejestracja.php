
<!DOCTYPE html>
<html lang="PL">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="utf-8">
   
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
    
    <link rel="stylesheet" href="style3.css">
    <script src="https://ajax/googleapis.com/ajax/libs/jqueary/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js.1.12.9/umd/popper.min.js"></script>   
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script> 
    <script src="https://use.fontawesome.com/releases/v5.0.8/js/all.js"></script>
<title>Logowanie</title>
<style>
        body{ font: 14px sans-serif; }
        .wrapper{ width: 360px; padding: 20px; }
    </style>


</head>

<body>
  <nav class="navbar navbar-expand-md navbar-light bg-light sticky-top">
    <div class="container-fluid">
      <a class="navbar-brand" href="http://wardiere.j.pl/"><img src="grafika/logo2.png"></a>

      
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" >
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="http://wardiere.j.pl/">MENU</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="#">O FIRMIE</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="#">GALERIA</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="http://localhost/cennik.php">OFERTA</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="#">KONTAKT</a>
          </li>
          <li><div id="konto">
            <div id="button">
            <nav class="navbar navbar-light bg-light">
              <form class="container-fluid justify-content-start">
              <button class="btn btn-sm btn-outline-secondary " type="button"><a href="http://localhost/konto.php" style="color:black">ZALOGUJ SIĘ</a></button>
              </form>
            </nav>
            </div>
            </div>
          </li>
        </ul>
      </div>
    </div>
  </nav>
<body>
    
    <div class="wrapper">
    



    <h2>Zarejestruj się</h2>
    <p>Podaj swoje dane do rejestracji.</p>

    <?php
        if(!empty($login_err)){
            echo '<div class="alert alert-danger">Niepoprawne dane</div>';

        }
    ?>

    <form action="rejestracja.php" method="post">
        <div class="form-group">
            <label for="login">Login:</label>
            <input type="text" name="login" class="form-control">
        </div>
        <div class="form-group">
            <label for="password">Hasło:</label>
            <input type="password" name="password" class="form-control">
        </div>
        <div class="form-group">
            <label for="passwordrepeat">Powtórz hasło:</label>
            <input type="password" name="passwordrepeat" class="form-control">
        </div>
        <input type="hidden" name="action" value="register">
        <div class="form-group">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="regulamin" id="regulamin">
                <label class="form-check-label" for="regulamin">Akceptuję regulamin</label>
            </div>
        </div>
        <div class="form-group"> 
            <input type="submit" class="btn btn-primary btn-block" value="Zarejestruj">
        </div>
        <p>Posiadasz konto? <a href="konto.php"> Zaloguj się!</a></p>
    </form>
    </div>

<?php

session_start();

if(isset($_REQUEST['action']) && $_REQUEST['action'] == "register") {
    $db = new mysqli("localhost", "root", "", "wardiere");
    
    $login = $_POST['login'];
    $password = $_POST['password'];
    $passwordrepeat = $_POST['passwordrepeat'];
    $regulamin = isset($_POST['regulamin']);

    if (empty($login) || empty($password) || empty($passwordrepeat) || !$regulamin) {
        echo '<div class="alert alert-danger">Wszystkie pola muszą być wypełnione, a regulamin zaakceptowany!</div>';
    } else {
        $login = filter_var($login, FILTER_SANITIZE_EMAIL);

        if (!preg_match('/^[a-zA-Z0-9]{4,32}$/', $login) || !preg_match('/^[a-zA-Z0-9]{4,32}$/', $password)) {
            echo '<div class="alert alert-danger">Niepoprawny format loginu lub hasła!</div>';
        } else {
            $slogin = "SELECT login FROM uzytkownicy WHERE login='$login'";
            $result = $db->query($slogin);
            if ($result->num_rows == 0) {
                if (strlen($password) >= 8) {
                    if ($password == $passwordrepeat) {
                        $passwordHash = password_hash($password, PASSWORD_ARGON2I);
                        $q = $db->prepare("INSERT INTO uzytkownicy (login, password) VALUES (?, ?)");
                        $q->bind_param("ss", $login, $passwordHash);
                        $result = $q->execute();
                        if ($result) {
                            echo '<div class="alert alert-success">Konto utworzono poprawnie.</div>';
                            header("location: powitanielog.html");
                            exit;
                        } else {
                            echo '<div class="alert alert-danger">Coś poszło nie tak!</div>';
                        }
                    } else {
                        echo '<div class="alert alert-danger">Hasła nie są zgodne - spróbuj ponownie!</div>';
                    }
                } else {
                    echo '<div class="alert alert-danger">Hasło jest zbyt krótkie!</div>';
                }
            } else {
                echo '<div class="alert alert-danger">Podany login jest już zajęty!</div>';
            }
        }
    }
}

session_destroy();

?>



    <?php 
    include 'footer.php';
    ?>
</body>
</html>
