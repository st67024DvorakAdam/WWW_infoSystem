<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    session_destroy();
    header('Location: logout.php');
    exit;
}


if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
}

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

$sql = "SELECT first_name, last_name, phone_number, email, sex, register_date, img FROM user WHERE id = :user_id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':user_id', $user_id);
$stmt->execute();


if ($stmt->rowCount() > 0) {
    $row = $stmt->fetch();


    echo "<script>
            document.getElementById('first_name').innerText = '{$row['first_name']}';
            document.getElementById('last_name').innerText = '{$row['last_name']}';
            document.getElementById('phone_number').innerText = '{$row['phone_number']}';
            document.getElementById('email').innerText = '{$row['email']}';
            document.getElementById('sex').innerText = '{$row['sex']}';
            document.getElementById('register_date').innerText = '{$row['register_date']}';

            var img = document.getElementById('profile_picture');
            img.src = " . ($row['img'] ? "'data:image/jpeg;base64," . base64_encode($row['img']) . "'" : getImagePathBasedOnGender($row['sex'])) . ";

            document.getElementById('edit_first_name').innerText = '{$row['first_name']}';
            document.getElementById('edit_last_name').innerText = '{$row['last_name']}';
            document.getElementById('edit_phone_number').innerText = '{$row['phone_number']}';
            document.getElementById('edit_email').innerText = '{$row['email']}';
            document.getElementById('edit_sex').innerText = '{$row['sex']}';

            var img = document.getElementById('edit_profile_picture');
            img.src = " . ($row['img'] ? "'data:image/jpeg;base64," . base64_encode($row['img']) . "'" : getImagePathBasedOnGender($row['sex'])) . ";
          </script>";
} else {
    echo "Uživatel nebyl nalezen";
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Můj účet</title>

    <!-- CSS Files -->
    <link rel="stylesheet" href="https://unpkg.com/bootstrap@5.3.2/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://unpkg.com/bs-brain@2.0.2/components/logins/login-5/assets/css/login-5.css" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" data-no-delete="yes" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script>
        function editAccount() {
            document.getElementById('account-info').style.display = 'none';
            document.getElementById('edit-account-form').style.display = 'block';
        }

        function cancelEdit() {
            document.getElementById('account-info').style.display = 'block';
            document.getElementById('edit-account-form').style.display = 'none';
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


        .center-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            margin: 30px auto;
            max-width: 800px;
        }


        .white-button {
            background-color: #fff;
            color: #2069f5;
            border: none;
            border-radius: 20px;
            padding: 10px 20px;
            cursor: pointer;
        }


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
            <div class="button-container">
                <button class="white-button" onclick="editAccount()">Editovat účet</button>
            </div>
        </div>
        <div id="edit-account-form" style="display: none;">
            <form method="post" action="update_account.php" enctype="multipart/form-data">
                <p>
                    <label for="edit_first_name">Jméno:</label>
                    <input type="text" id="edit_first_name" name="edit_first_name" value="<?php echo $row['first_name']; ?>">
                </p>
                <p>
                    <label for="edit_last_name">Příjmení:</label>
                    <input type="text" id="edit_last_name" name="edit_last_name" value="<?php echo $row['last_name']; ?>">
                </p>

                <p>
                    <label for="edit_phone_number">Telefonní číslo:</label>
                    <input type="text" id="edit_phone_number" name="edit_phone_number" value="<?php echo $row['phone_number']; ?>">
                </p>

                <p><label for="edit_email">Email:</label>
                    <input type="email" id="edit_email" name="edit_email" value="<?php echo $row['email']; ?>">
                </p>


                <div class="mb-3">
                    <label for="sex" class="form-label">Pohlaví</label>
                    <select class="form-select" name="sex" id="sex">
                        <option value="male">muž</option>
                        <option value="female">žena</option>
                        <option value="other">ostatní</option>
                    </select>
                </div>


                <div class="mb-3">
                    <label for="profile_picture" class="form-label">Profilová fotka</label>
                    <input type="file" class="form-control" name="profile_picture" id="profile_picture">
                </div>

                <p><button type="submit" class="white-button">Uložit změny</button>
                    <button type="button" class="white-button" onclick="cancelEdit()">Zrušit</button>
                </p>

            </form>
        </div>
    </div>
</body>

</html>
<?php

if (!isset($_SESSION['user_id'])) {
    echo '<script>alert("Uživatel není přihlášen");</scrip>';
    echo '<script>window.location = "logout.php";</script>';
    exit;
}
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
}

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

$sql = "SELECT first_name, last_name, phone_number, email, sex, register_date, img FROM user WHERE id = :user_id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':user_id', $user_id);
$stmt->execute();


if ($stmt->rowCount() > 0) {
    $row = $stmt->fetch();


    echo "<script>
            document.getElementById('first_name').innerText = '{$row['first_name']}';
            document.getElementById('last_name').innerText = '{$row['last_name']}';
            document.getElementById('phone_number').innerText = '{$row['phone_number']}';
            document.getElementById('email').innerText = '{$row['email']}';
            document.getElementById('sex').innerText = '{$row['sex']}';
            document.getElementById('register_date').innerText = '{$row['register_date']}';

            var img = document.getElementById('profile_picture');
            img.src = " . ($row['img'] ? "'data:image/jpeg;base64," . base64_encode($row['img']) . "'" : getImagePathBasedOnGender($row['sex'])) . ";

            document.getElementById('edit_first_name').innerText = '{$row['first_name']}';
            document.getElementById('edit_last_name').innerText = '{$row['last_name']}';
            document.getElementById('edit_phone_number').innerText = '{$row['phone_number']}';
            document.getElementById('edit_email').innerText = '{$row['email']}';
            document.getElementById('edit_sex').innerText = '{$row['sex']}';

            var img = document.getElementById('edit_profile_picture');
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
$conn = null;

?>