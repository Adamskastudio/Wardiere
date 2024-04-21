<!DOCTYPE html>
<html lang="pl">
<head>
    <title>Formularz</title>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="style2.css">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
    <?php include 'style.php'; ?>
</head>
<body>
    <?php include 'header.php'; ?>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <center><h3>Rezerwacja</h3></center>
                <form method="POST" action="rezerwacja.php">
                    <h4>Podaj swoje dane:</h4>
                    <div class="form-group">
                        <label for="name">Imię i Nazwisko:</label>
                        <input type="text" class="form-control" name="name" id="name" placeholder="Jan Kowalski" required>
                    </div>
                    <div class="form-group">
                        <label for="number">Numer telefonu:</label>
                        <input type="tel" class="form-control" name="number" id="number" placeholder="xxx-xxx-xxx" required size="9">
                    </div>
                    <div class="form-group">
                        <label for="email">Adres mail:</label>
                        <input type="email" class="form-control" name="email" id="email" placeholder="wardiere@wardiere.com" required>
                    </div>
                    <input type="submit" class="btn btn-primary" name="submit" value="Przejdź dalej">
                </form>
                <?php
                if (isset($_POST['submit'])) {
                    $name = $_POST['name'];
                    $number = $_POST['number'];
                    $email = $_POST['email'];

                                    // Połączenie z bazą danych
                $db = new mysqli("localhost", "root", "", "wardiere");

                // Sprawdzenie połączenia z bazą danych
                if ($db->connect_error) {
                    die("Błąd połączenia z bazą danych: " . $db->connect_error);
                }

                // Przygotowanie zapytania SQL
                $sql = "INSERT INTO rezerwacje (name, number, email) VALUES ('$name', '$number', '$email')";

                if ($db->query($sql) === TRUE) {
                    echo "<div class='alert alert-success'>Dane zostały zapisane w bazie danych.</div>";
                } else {
                    echo "<div class='alert alert-danger'>Błąd przy zapisie danych do bazy danych: " . $db->error . "</div>";
                }

                // Zamknięcie połączenia z bazą danych
                $db->close();
            }
            ?>
        </div>
    </div>
</div>
<?php include 'footer.php'; ?>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
