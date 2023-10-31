<?php
session_start();

$host = 'localhost'; // Host
$dbname = 'db'; // Nazev databáze na localu
$user = 'root'; // Přihlašovací jméno k phpMyAdmin MySQL serveru
$pass = ''; // Heslo - defaultně žádné


// Připojení k DB pomocí PDO

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Chyba připojení: " . $e->getMessage();
}


// Získá údaje odesláné z formuláře pro registraci podle name
if (isset($_POST["register"])) {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $sex = $_POST['sex'];
    $is_admin = 0;
    $phone_number = NULL;
    $img = NULL;
    //kontrola nahrani obrazku
    if (isset($_FILES["profile_picture"])) {
        if ($_FILES["profile_picture"]["error"] === 0) {
            // Soubor byl nahrán, můžete jej zpracovat
            $img = file_get_contents($_FILES["profile_picture"]["tmp_name"]);
        } else {
            // Chyba při nahrávání souboru
            $img = NULL;
        }
    } else {
        
        $img = null;
    }

    try {
        $stmt = $conn->prepare("INSERT INTO user (first_name, last_name, email, password, sex, phone_number, is_administrator, img) VALUES (:first_name, :last_name, :email, :password, :sex, :phone_number, :is_administrator, :img)");

        $stmt->bindParam(':first_name', $first_name);
        $stmt->bindParam(':last_name', $last_name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':sex', $sex);
        $stmt->bindParam(':phone_number', $phone_number);
        $stmt->bindParam(':is_administrator', $is_admin);
        $stmt->bindParam(':img', $img, PDO::PARAM_LOB);


        $stmt->execute();
        $user_id = $conn->lastInsertId();

        session_start();
        $_SESSION['user_id'] = $user_id;

        header('Location: posts.php');
        exit;
    } catch (PDOException $e) {
        echo "Chyba: " . $e->getMessage();
    }
} elseif (isset($_POST["login"])) {
    $login_email = $_POST['email'];
    $login_password = $_POST['password'];

    try {
        $stmt = $conn->prepare("SELECT * FROM user WHERE email = :email");
        $stmt->bindParam(':email', $login_email);
        $stmt->execute();
        $user = $stmt->fetch();

        if ($user && password_verify($login_password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            header('Location: posts.php');
            exit();
        } else {
            echo "Nesprávné přihlašovací údaje.";
        }
    } catch (PDOException $e) {
        echo "Chyba: " . $e->getMessage();
    }
}
