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

    if (isset($_FILES["post_image"]) && $_FILES["post_image"]["size"] > 0) {
        // Získání informací o souboru
        $image_info = getimagesize($_FILES["post_image"]["tmp_name"]);
        $mime_type = $image_info['mime'];

        // Kontrola podporovaných formátů
        $allowed_formats = ['image/gif', 'image/jpeg', 'image/bmp', 'image/png'];
        if (!in_array($mime_type, $allowed_formats)) {
            // Neplatný formát obrázku
            echo "<script>alert('Neplatný formát obrázku. Podporované formáty jsou JPEG, PNG, GIF, BMP.');</script>";
            exit;
        }

        // Kontrola rozměrů obrázku
        $width = 800;
        $height = intval($image_info[1] * ($width / $image_info[0]));

        // Získání obsahu obrázku
        $post_image = file_get_contents($_FILES["post_image"]["tmp_name"]);

        // Konverze obrázku na formát JPEG
        if ($mime_type != 'image/jpeg') {
            switch ($mime_type) {
                case 'image/gif':
                    $image = imagecreatefromgif($_FILES["post_image"]["tmp_name"]);
                    break;
                case 'image/bmp':
                    $image = imagecreatefrombmp($_FILES["post_image"]["tmp_name"]);
                    break;
                case 'image/png':
                    $image = imagecreatefrompng($_FILES["post_image"]["tmp_name"]);
                    break;
            }

            // Vytvoření prázdného obrázku s novými rozměry
            $new_image = imagecreatetruecolor($width, $height);

            // Kopírování a převedení obrázku na formát JPEG
            imagecopyresampled($new_image, $image, 0, 0, 0, 0, $width, $height, $image_info[0], $image_info[1]);

            ob_start(); // Otevření output bufferu
            imagejpeg($new_image, null, 90); // Převod na formát JPEG a výstup do output bufferu
            $post_image = ob_get_contents(); // Získání obsahu output bufferu
            ob_end_clean(); // Uzavření a vyprázdnění output bufferu

            // Uvolnění paměti používané pro obrázek
            imagedestroy($image);
            imagedestroy($new_image);
        }
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

header("Location: posts.php");

// Uzavření připojení k databázi
$conn = null;
?>