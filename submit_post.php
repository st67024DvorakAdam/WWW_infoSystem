<?php
// Připojení k databázi
session_start();
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    header('Location: index.php'); // Přesměrování na přihlašovací stránku
    exit;
}

$host = 'localhost';
$dbname = 'db';
$user = 'root';
$pass = '';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Chyba připojení: " . $e->getMessage();
    die();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Získání dat z formuláře
    $post_text = $_POST["post_text"];

    // Zpracování nahrávaného obrázku, pokud byl vybrán
    if (isset($_FILES["post_image"]) && $_FILES["post_image"]["size"] > 0) {
        $post_image = file_get_contents($_FILES["post_image"]["tmp_name"]);
    } else {
        $post_image = null;
    }

    // Nastavení aktuálního data
    $post_date = date("Y-m-d H:i:s");

    // Vložení dat do databáze
    if ($post_image === null) {
        $post_image = ''; // Nastavit prázdný řetězec pro sloupce typu TEXT
    }
    $stmt = $conn->prepare("INSERT INTO Post (img, text, postDateTime, user_id) VALUES (?, ?, ?, ?)");
    $stmt->execute([$post_image, $post_text, $post_date, $user_id]);
}

$url = "http://localhost/WWW_infoSystem-main/posts.php";
$cas = 0;

echo "<meta http-equiv='refresh' content='{$cas};url={$url}'>";

// Uzavření připojení k databázi
$conn = null;
?>
