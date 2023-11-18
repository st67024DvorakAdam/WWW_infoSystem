<?php
session_start();

if (!isset($_SESSION['user_id'])) {
 // Uživatel není přihlášen, takže zrušíme jeho relaci
    session_destroy();
    // Přesměrujte ho na stránku odhlášení nebo jinou vhodnou stránku

    header('Location: logout.php');
    exit;
}

$host = 'localhost';
$dbname = 'db';
$user = 'root';
$pass = '';

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// Zkontrolujeme, zda byl formulář odeslán pomocí HTTP POST metody
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $sender_id = $_SESSION['user_id'];
    $receiver_id = $_POST['receiver_id'];
    $text = $_POST['text'];
    $messageDateTime = date('Y-m-d H:i:s');

    $sql = "INSERT INTO message (sender_id, receiver_id, text, messageDateTime) VALUES ('$sender_id', '$receiver_id', '$text', '$messageDateTime')";

    if ($conn->query($sql) === TRUE) {
        // Zpráva byla úspěšně odeslána
        echo "Zpráva byla úspěšně odeslána.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

}
// Získání ID přihlášeného uživatele
$user_id = $_SESSION['user_id'];

// Získání všech zpráv pro přihlášeného uživatele jako příjemce
$sql = "SELECT * FROM message WHERE receiver_id = '$user_id'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Infosystém</title>
    <!-- CSS Files -->
    <link rel="stylesheet" href="https://unpkg.com/bootstrap@5.3.2/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://unpkg.com/bs-brain@2.0.2/components/logins/login-5/assets/css/login-5.css" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" data-no-delete="yes" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

<style>
    body,
    html {
        height: 100%;
        margin: 0;
    }

    body {
        background-color: #2069f5;
        background-size: cover;
        background-attachment: fixed;
    }



    /* Bílý pruh ve středu stránky */
    .center-container {
        background-color: #fff;
        padding: 20px;
        border-radius: 5px;
        margin: 30px auto;
        max-width: 800px;
        height: 100vh;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);

    }

    /* Bílé tlačítko */
    .white-button {
        background-color: #2069f5;
        /* Modrá barva */
        color: white;
        /* Bílý text */
        border: none;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.4);
        border-radius: 20px;
        padding: 10px 15px;
        cursor: pointer;
        margin-top: auto;
        text-align: center;
        /* Zarovnání textu na střed */
        position: sticky;
        bottom: 10%;
        left: 45%;
    }

    .white-button:hover {
        background-color: white;
        /* Bílé pozadí při najetí myší */
        color: #2069f5;
        /* Modrý text při najetí myší */
    }

    /* Zarovnání tlačítka doprava */
    .button-container {
        display: flex;
        justify-content: flex-end;
        margin-right: 40px;
    }

    /* Barva textu pro odkaz "Příspěvky" */
    .nav-link[href="chat.php"] {
        font-weight: bold;
    }

    .navbar {
        background-color: #fff;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
        /* Zvětšený stín */
        border-radius: 0;
        /* Ostré rohy */
    }

    .navbar-brand {
        font-size: 24px;
        font-weight: bold;
    }

    .navbar-nav .nav-item {
        padding: 0 15px;
    }

    .navbar-nav .nav-link {
        color: #2069f5;
    }

    .navbar-toggler-icon {
        background-color: #2069f5;
    }
</style>
</
<body>
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <a class="navbar-brand" href="#">Infosystém</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="posts.php">Příspěvky</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="chat.php">Chaty</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="account.php">Můj Účet</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Odhlásit</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    

    <!-- Formulář pro odeslání zprávy -->
    <div class="center-container">
        <form method="post" action="">
            <div class="form-group">
                <label for="receiver_id">ID příjemce:</label>
                <input type="text" class="form-control" id="receiver_id" name="receiver_id" required>
            </div>
            <div class="form-group">
                <label for="text">Text zprávy:</label>
                <textarea class="form-control" id="text" name="text" rows="3" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Odeslat zprávu</button>
        </form>
    </div>
   <!-- Zobrazování zpráv na stránce -->
   <div class="center-container">
        <?php
        if ($result->num_rows > 0) {
            // Výpis všech zpráv
            while ($row = $result->fetch_assoc()) {
                echo "<div class='message'>";
                echo "<p>Sender: " . $row['sender_id'] . "</p>";
                echo "<p>Text: " . $row['text'] . "</p>";
                echo "<p>Date: " . $row['messageDateTime'] . "</p>";
                echo "</div>";
                echo "<p>______________________________________________</p>";
            }
        } else {
            echo "<p>Žádné zprávy nebyly nalezeny.</p>";
        }
        ?>
    </div>

    
</body>
<?php
$conn->close();
?>
</html>
