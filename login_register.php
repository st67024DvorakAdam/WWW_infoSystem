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
    $phone_number = $_POST['phone_number'];
    $img = $_POST['profile_picture'];

    $stmt = $conn->prepare("SELECT * FROM user WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $existingUser = $stmt->fetch();

        if ($existingUser) {
            // Zobrazení upozornění, že e-mail již existuje
            echo '<script>alert("E-mail již existuje. Prosím zvolte jiný e-mail.");</script>';
            header('Location: register.php');
        } else {
    //kontrola nahrani obrazku
    if (isset($_FILES["profile_picture"])) {
        if ($_FILES["profile_picture"]["error"] === 0) {
            // Soubor byl nahrán, můžete jej zpracovat
            $img = file_get_contents($_FILES["profile_picture"]["tmp_name"]);
        } else {
            
        $default_image_base64 = 'data:image/png;base64,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';
        $img = base64_decode(str_replace('data:image/png;base64,', '', $default_image_base64));
  
        }
    } else {
        $default_image_base64 = 'data:image/png;base64,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';
        $img = base64_decode(str_replace('data:image/png;base64,', '', $default_image_base64));
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
            $_SESSION['isAdmin'] = $user['is_administrator'];
            header('Location: posts.php');
            exit();
        } else {
            
            
            echo '<script>alert("Nesprávné přihlašovací údaje.");</script>';
            
            
            echo '<script>window.location.href = "index.php";</script>';

        }
    } catch (PDOException $e) {
        echo "Chyba: " . $e->getMessage();
    }
}
