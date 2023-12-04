<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: logout.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $host = 'localhost';
    $dbname = 'db';
    $user = 'root';
    $pass = '';

    try {
        $conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $user_id = $_SESSION['user_id'];

        $sql = "UPDATE user SET 
            first_name = :first_name,
            last_name = :last_name,
            phone_number = :phone_number,
            email = :email,
            sex = :sex
            WHERE id = :user_id";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':first_name', $_POST['edit_first_name']);
        $stmt->bindParam(':last_name', $_POST['edit_last_name']);
        $stmt->bindParam(':phone_number', $_POST['edit_phone_number']);
        $stmt->bindParam(':email', $_POST['edit_email']);
        $stmt->bindParam(':sex', $_POST['edit_sex']);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();

        if ($_FILES['edit_profile_picture']['size'] > 0) {
            $imgData = file_get_contents($_FILES['edit_profile_picture']['tmp_name']);
            $sql = "UPDATE user SET img = :img WHERE id = :user_id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':img', $imgData, PDO::PARAM_LOB);
            $stmt->bindParam(':user_id', $user_id);
            $stmt->execute();
        }

        header('Location: account.php');
        exit;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    } catch (Exception $e) {
        echo "Exception: " . $e->getMessage();
    }
} else {
    echo "Invalid request method.";
}
