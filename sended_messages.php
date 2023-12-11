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
    $receiver_email = $_POST['receiver_email'];
    $text = $_POST['text'];
    $messageDateTime = date('Y-m-d H:i:s');

    // Získání receiver_id podle receiver_email
    $sql_receiver_id = "SELECT id FROM `user` WHERE email = '$receiver_email'";
    $result = $conn->query($sql_receiver_id);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $receiver_id = $row['id'];

        // Vložení zprávy do tabulky message
        $sql = "INSERT INTO message (sender_id, receiver_id, text, messageDateTime) VALUES ('$sender_id', '$receiver_id', '$text', '$messageDateTime')";

        if ($conn->query($sql) === TRUE) {
            // Zpráva byla úspěšně odeslána
            echo "Zpráva byla úspěšně odeslána.";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Příjemce s tímto emailem nebyl nalezen.";
    }
}

// Získání ID přihlášeného uživatele
$user_id = $_SESSION['user_id'];

// Získání všech zpráv pro přihlášeného uživatele jako příjemce
$sql = "SELECT * FROM message WHERE sender_id = '$user_id' ORDER BY messageDateTime DESC";
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
    <script>
    function navigateToChat() {
        window.location.href = "chat.php";
    }

    function navigateToRecievedMessages() {
        window.location.href = "recieved_messages.php";
    }
    </script>
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

    @keyframes blinker {
        50% {
            opacity: 0;
        }
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

    <div>
    <?php
$host = 'localhost';
$dbname = 'db';
$user = 'root';
$pass = '';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    echo "Chyba připojení: " . $e->getMessage();
}


    //ověření nových zpráv
$sql_new_messages = "SELECT COUNT(*) FROM message WHERE receiver_id = $user_id AND isLookedByUser = 0";
$new_messages_result = $conn->query($sql_new_messages);

// Kontrola, zda existují nové zprávy
$newMessages = false; // Výchozí hodnota pro newMessages
$count = $new_messages_result->fetchColumn(); // Získání hodnoty počtu zpráv
if ($count > 0) {
    $newMessages = true; // Pokud existují nové zprávy, nastavíme newMessages na true
}
if ($newMessages == true) {
    echo "<b style='animation: blinker 1s linear infinite; color: red;'>Nové zprávy</b>";
}else{
    echo "Žádné nové zprávy";
}

function decryptText($encryptedText, $key, $iv) {
    // Dešifrování textu s využitím AES a specifikovaného IV
    $decryptedText = openssl_decrypt($encryptedText, 'aes-256-cbc', $key, 0, base64_decode($iv));

    // Vrácení dešifrovaného textu
    return $decryptedText;
}
    ?>
</div>

    <div style="font-weight: bold; font-size: 25px; text-align: center;">
        <h1>Odeslané zprávy</h1>
    </div>

    <div style="margin-top: 20px; margin-left: 20px;">
        <button class="btn btn-primary bg-info" onclick="navigateToChat()">Nová zpráva</button>
        <button class="btn btn-primary bg-info" onclick="navigateToRecievedMessages()">Přijaté zprávy</button>
    </div>

   <!-- Zobrazování zpráv na stránce -->
   <div class="center-container">
        <?php
        if ($result->num_rows > 0) {
            // Výpis všech zpráv
            while ($row = $result->fetch_assoc()) {
                echo "<div class='message'>";

                //zjištění příjemce zprávy
                $reciever_id = $row['receiver_id'];
                $sql_reciver_email = "SELECT email FROM user WHERE id = $reciever_id";
                $reciever_email_result = $conn->query($sql_reciver_email);
                $reciever_mail = $reciever_email_result->fetchColumn(); 

                //rošifrování zprávy
                $key = 'VpO7zGH4YLP7WHDGjEjqMmG0nDqp4JaO'; 
                $decryptedText = decryptText($row['text'], $key, $row['iv']);

                echo "<p>Reciever: " . $reciever_mail . "</p>";
                echo "<p>Text: " . $decryptedText . "</p>";
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
