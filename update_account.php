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
        $img = NULL;


       


        if (isset($_FILES["profile_picture"]) && $_FILES["profile_picture"]["size"] > 0) {
            // Získání informací o souboru
            $image_info = getimagesize($_FILES["profile_picture"]["tmp_name"]);
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
            $post_image = file_get_contents($_FILES["profile_picture"]["tmp_name"]);
    
            // Konverze obrázku na formát JPEG
            if ($mime_type != 'image/jpeg') {
                switch ($mime_type) {
                    case 'image/gif':
                        $image = imagecreatefromgif($_FILES["profile_picture"]["tmp_name"]);
                        break;
                    case 'image/bmp':
                        $image = imagecreatefrombmp($_FILES["profile_picture"]["tmp_name"]);
                        break;
                    case 'image/png':
                        $image = imagecreatefrompng($_FILES["profile_picture"]["tmp_name"]);
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






        

        $sql = "UPDATE user SET 
            first_name = :first_name,
            last_name = :last_name,
            phone_number = :phone_number,
            email = :email,
            sex = :sex";

        if ($post_image != NULL) {
            $sql .= ", img = :post_image";
        }

        $sql .= " WHERE id = :user_id";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':first_name', $_POST['edit_first_name']);
        $stmt->bindParam(':last_name', $_POST['edit_last_name']);
        $stmt->bindParam(':phone_number', $_POST['edit_phone_number']);
        $stmt->bindParam(':email', $_POST['edit_email']);
        $stmt->bindParam(':sex', $_POST['sex']);
        $stmt->bindParam(':user_id', $user_id);
        if ($post_image !== NULL) {
            $stmt->bindParam(':post_image', $post_image, PDO::PARAM_LOB);
        }

        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();


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
