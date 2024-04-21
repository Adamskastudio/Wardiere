<!DOCTYPE html>
<html lang="pl">
<head>
    <title>Oferta Spa</title>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="style.css">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include 'header.php'; ?>

    <div class="container">
        <h3>Oferta Spa</h3>
        <table class="table">
            <thead>
                <tr>
                    <th>Nazwa</th>
                    <th>Czas</th>
                    <th>Cena</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Połączenie z bazą danych
                $conn = new mysqli("localhost", "root", "", "wardiere");

                // Sprawdzenie połączenia
                if ($conn->connect_error) {
                    die("Błąd połączenia z bazą danych: " . $conn->connect_error);
                }

                // Zapytanie do bazy danych
                $sql = "SELECT * FROM usługi";
                $result = $conn->query($sql);

                // Wyświetlanie danych z bazy
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["Nazwa"] . "</td>";
                        echo "<td>" . $row["Opis"] . "</td>";
                        echo "<td>" . $row["Cena"] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='3'>Brak ofert spa w bazie danych.</td></tr>";
                }

                // Zamknięcie połączenia z bazą danych
                $conn->close();
                ?>
            </tbody>
        </table>
    </div>

    <?php include 'footer.php'; ?>
</body>
</html>
