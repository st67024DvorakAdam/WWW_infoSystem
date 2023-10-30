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
    $img_path = NULL;

    // když není vybranej obrázek nebo číslo - zůstanou null i v db
    if (isset($_POST['img_path']) && $_POST['img_path'] != NULL) {
        $img_path = $_POST['img_path'];
    }

    if (isset($_POST['phone_number']) && $_POST['phone_number'] != NULL) {
        $phone_number = $_POST['phone_number'];
    }

    try {
        $stmt = $conn->prepare("INSERT INTO user (first_name, last_name, email, password, sex, phone_number, is_administrator) VALUES (:first_name, :last_name, :email, :password, :sex, :phone_number, :is_administrator)");

        $stmt->bindParam(':first_name', $first_name);
        $stmt->bindParam(':last_name', $last_name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':sex', $sex);
        $stmt->bindParam(':phone_number', $phone_number);
        $stmt->bindParam(':is_administrator', $is_admin);
        // TODO
        //$stmt->bindParam(':img_path', $img_path);
        //header('Location: profile.php');

        $stmt->execute();
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
