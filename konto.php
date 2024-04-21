
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
    
    <h2>Zaloguj się</h2>
    <p>Podaj swoje dane logowania.</p>

    <?php
        if(!empty($login_err)){
            echo '<div class="alert alert-danger">Niepoprawne dane logowania</div>';

        }
    ?>

    <form action="konto.php" method="post">
        <div class="form-group">
            <label for="login">Login:</label>
            <input type="text" name="login" class="form-control">
        </div>
        <div class="form-group">
            <label for="password">Hasło:</label>
            <input type="password" name="password" class="form-control">
        </div>
        <input type="hidden" name="action" value="login">
        <div class="form-group"> 
            <input type="submit" class="btn btn-primary btn-block" value="Zaloguj">
        </div>
        <p>Nie posiadasz konta? <a href="rejestracja.php"> Załóż je teraz!</a></p>
    </form>
    </div>


    <?php

    if(isset($_REQUEST['action']) && $_REQUEST['action'] == "login") {
        $login = $_REQUEST['login'];
        $password = $_REQUEST['password'];

        $login = filter_var($login, FILTER_SANITIZE_EMAIL);

        $db = new mysqli("localhost", "root", "", "wardiere");

        $q = $db->prepare("SELECT * FROM uzytkownicy WHERE login = ? LIMIT 1");
        $q->bind_param("s", $login);
        $q->execute();
        $result = $q->get_result();
        $userRow = $result->fetch_assoc();

        if($userRow == null){
            echo '<div class="alert alert-danger">Błędny login lub hasło</div>';
        } else {
            if(password_verify($password, $userRow['password'])) {
                header("location: powitanie.html");
            } else {
                echo '<div class="alert alert-danger">Błędny login lub hasło.</div>';
            }
        }
    }

    ?>


    <?php 
    include 'footer.php';
    ?>
</body>
</html>
