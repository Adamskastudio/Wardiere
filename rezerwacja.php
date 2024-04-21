<!DOCTYPE html>
<html lang="pl">
<head>
    <title>Rezerwacja</title>
    <meta charset="utf-8"/>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
       
    </style>
</head>
<body>
    <?php include 'header.php'; ?>
    <div class="container">
        <div class="wrapper">
            <br>
            <h3 class="text-center">Rezerwacja</h3>
            <form method="POST" action="rezerwacja.php">
                <div class="form-group">
                    <label for="wybor">Wybierz rodzaj zabiegu:</label>
                    <select class="form-control" id="wybor" name="wybor">
                        <option value="Masaż Shiatsu">Masaż Shiatsu</option>
                        <option value="Masaż Tajski">Masaż Tajski</option>
                        <option value="Masaż Antycelulitowy">Masaż Antycelulitowy</option>
                        <option value="Masaż Gorącymi Kamieniami">Masaż Gorącymi Kamieniami</option>
                        <option value="Masaż Bambusami">Masaż Bambusami</option>
                        <option value="Masaż Stemplami Ziołowymi">Masaż Stemplami Ziołowymi</option>
                        <option value="Tradycyjny Masaż Hilot - olejkowy">Tradycyjny Masaż Hilot - olejkowy</option>
                        <option value="Masaż Lomi">Masaż Lomi</option>
                        <option value="Masaż Dla Dwojga">Masaż Dla Dwojga</option>
                        <option value="Refleksologia">Refleksologia</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="czas">Czas:</label>
                    <select class="form-control" id="czas" name="czas">
                        <option value="60 minut">60 minut</option>
                        <option value="90 minut">90 minut</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="name">Imię i nazwisko:</label>
                    <input type="text" class="form-control" id="name" name="name" value="<?php echo isset($_POST['name']) ? $_POST['name'] : ''; ?>" required>
                </div>

                <div class="form-group">
                    <label for="number">Numer telefonu:</label>
                    <input type="number" class="form-control" id="number" name="number" value="<?php echo isset($_POST['number']) ? $_POST['number'] : ''; ?>" required>
                </div>

                <div class="form-group">
                    <label for="email">Adres email:</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>" required>
                </div>

                <div class="form-group">
                    
                    <input type="submit" class="btn btn-primary" name="zatwierdz" value="Zatwierdź">
                </div>
            </form>
            <a class="btn btn-secondary" href="http://www.wardiere.j.pl">Powrót</a>
            <?php
            // Sprawdzenie, czy formularz został wysłany
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                // Pobranie wyboru użytkownika
                $wybor = $_POST["wybor"];
                $czas = $_POST["czas"];

                // Słownik przedmiotów i ich cen
                $przedmioty = array(
                    'Masaż Shiatsu' => 210,
                    'Masaż Tajski' => 220,
                    'Masaż Antycelulitowy' => 210,
                    'Masaż Gorącymi Kamieniami' => 240,
                    'Masaż Bambusami' => 250,
                    'Masaż Stemplami Ziołowymi' => 230,
                    'Tradycyjny Masaż Hilot - olejkowy' => 220,
                    'Masaż Lomi' => 250,
                    'Masaż Dla Dwojga' => 220,
                    'Refleksologia' => 220,
                );

                $czas_prz = array(
                    '60 minut' => 1,
                    '90 minut' => 1.5,
                );

                // Sprawdzenie, czy wybór istnieje w słowniku
                if (array_key_exists($wybor, $przedmioty) && array_key_exists($czas, $czas_prz)) {
                    $cena_przedmiotu = $przedmioty[$wybor] * $czas_prz[$czas];
                    echo "<div class='alert alert-success'>Cena wybranego przedmiotu: $cena_przedmiotu</div>";
                } else {
                    echo "<div class='alert alert-danger'>Nieprawidłowy wybór. Spróbuj ponownie.</div>";
                }
            }
            ?>
            <div class="napis">
                <?php
                if (isset($_POST['zatwierdz'])) {
                    // Dane do połączenia z bazą danych
                    $host = 'localhost';
                    $username = 'nazwa_uzytkownika';
                    $password = 'haslo';
                    $database = 'nazwa_bazy_danych';

                    // Tworzenie połączenia z bazą danych
                    $conn = new mysqli("localhost", "root", "", "wardiere");

                    // Sprawdzanie czy udało się połączyć z bazą danych
                    if ($conn->connect_error) {
                        die("Błąd połączenia z bazą danych: " . $conn->connect_error);
                    }

                    $name = $_POST['name'];
                    $number = $_POST['number'];
                    $email = $_POST['email'];
                    $nazwa = $_POST["wybor"];
                    $czas = $_POST["czas"];
                    $napis = "Twoja rezerwacja na zabieg: $nazwa - $czas została potwierdzona!";

                    echo "<div class='alert alert-success'>$napis</div>";

                    // Zapis danych do bazy danych
                    $sql = "INSERT INTO rezerwacje (name, number, email, nazwa, czas) VALUES ('$name', '$number', '$email', '$nazwa', '$czas')";

                    if ($conn->query($sql) === TRUE) {
                        echo "<div class='alert alert-success'>Dane zostały zapisane w bazie danych.</div>";
                    } else {
                        echo "<div class='alert alert-danger'>Błąd przy zapisie danych do bazy danych: " . $conn->error . "</div>";
                    }

                    

                    // Zamykanie połączenia z bazą danych
                    $conn->close();

                }
                
                ?>
            </div>
        </div>
    </div>
    <?php include 'footer.php'; ?>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
