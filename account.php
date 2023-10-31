<!DOCTYPE html>
<html>

<head>
    <title>Můj účet</title>

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

        img {
            width: 225px;
            height: 225px;
            border: 2px solid black;
        }

        .navbar {
            background-color: #fff;
        }

        .navbar-brand {
            font-size: 24px;
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

        /* Bílý pruh ve středu stránky */
        .center-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            margin: 30px auto;
            max-width: 800px;
        }

        /* Bílé tlačítko */
        .white-button {
            background-color: #fff;
            color: #2069f5;
            border: none;
            border-radius: 20px;
            padding: 10px 20px;
            cursor: pointer;
        }

        /* Zarovnání tlačítka doprava */
        .button-container {
            display: flex;
            justify-content: flex-end;
            margin-right: 40px;
        }
    </style>
</head>

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
    <div class="center-container">
        <h1>Informace o mém účtu</h1>
        <div id="account-info">
            <img alt="Profilová fotka" id="profile_picture" /> <!-- Image tag with an empty src -->
            <p><strong>Jméno:</strong> <span id="first_name"></span></p>
            <p><strong>Příjmení:</strong> <span id="last_name"></span></p>
            <p><strong>Telefonní číslo:</strong> <span id="phone_number"></span></p>
            <p><strong>Email:</strong> <span id="email"></span></p>
            <p><strong>Pohlaví:</strong> <span id="sex"></span></p>
            <p><strong>Datum a čas registrace:</strong> <span id="register_date"></span></p>
        </div>
    </div>
</body>

</html>
<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    // Uživatel není přihlášen, takže zobrazíme alert a přesměrujeme ho po potvrzení
    echo '<script>alert("Uživatel není přihlášen");</script>';
    echo '<script>window.location = "logout.php";</script>';
    exit;
}
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
}

// The rest of your code for database connection and query remains the same
$host = 'localhost';
$dbname = 'db';
$user = 'root';
$pass = '';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Nepodařilo se připojit k databázi: " . $e->getMessage());
}
// Your SQL query and data retrieval code here
$sql = "SELECT first_name, last_name, phone_number, email, sex, register_date, img FROM user WHERE id = :user_id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':user_id', $user_id);
$stmt->execute();


if ($stmt->rowCount() > 0) {
    $row = $stmt->fetch();

    // Vložení dat do HTML
    echo "<script>
            document.getElementById('first_name').innerText = '{$row['first_name']}';
            document.getElementById('last_name').innerText = '{$row['last_name']}';
            document.getElementById('phone_number').innerText = '{$row['phone_number']}';
            document.getElementById('email').innerText = '{$row['email']}';
            document.getElementById('sex').innerText = '{$row['sex']}';
            document.getElementById('register_date').innerText = '{$row['register_date']}';

            // Load the image from the database BLOB or set a default image
            var img = document.getElementById('profile_picture');
            img.src = " . ($row['img'] ? "'data:image/jpeg;base64," . base64_encode($row['img']) . "'" : getImagePathBasedOnGender($row['sex'])) . ";
          </script>";
} else {
    echo "Uživatel nebyl nalezen";
}
function getImagePathBasedOnGender($gender)
{
    if ($gender === 'female') {
        return "'pictures/profile_picture_woman.jpg'";
    } elseif ($gender === 'male') {
        return "'pictures/profile_picture_man.jpg'";
    } else {
        return "'pictures/default_profile_picture.jpg'";
    }
}
$conn = null; // Uzavření PDO spojení

?>