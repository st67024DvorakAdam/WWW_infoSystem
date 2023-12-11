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
    echo "Chyba připojení: " . $e->getMessage();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['change_password'])) {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    
    $stmt_check_password = $conn->prepare("SELECT password FROM user WHERE id = :user_id");
    $stmt_check_password->bindParam(':user_id', $user_id);
    $stmt_check_password->execute();
    $row_check_password = $stmt_check_password->fetch();


    
        

    if (password_verify($current_password, $row_check_password['password'])) {
        if ($new_password == $confirm_password) {
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            $sql_update_password = "UPDATE user SET password = :password WHERE id = :user_id";
            $stmt_update_password = $conn->prepare($sql_update_password);
            $stmt_update_password->bindParam(':password', $hashed_password);
            $stmt_update_password->bindParam(':user_id', $user_id);
            $stmt_update_password->execute();

            echo '<script>alert("Heslo bylo úspěšně změněno.");</script>';
        } else {
            echo '<script>alert("Nová hesla se neshodují.");</script>';
        }
    } else {
        echo '<script>alert("Aktuální heslo není správné.");</script>';
    }
}
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" data-no-delete="yes"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
    <script>
        function editAccount() {
            document.getElementById('account-info').style.display = 'none';
            document.getElementById('edit-account-form').style.display = 'block';
        }
        function editPassword(){
            document.getElementById('account-info').style.display = 'none';
            document.getElementById('edit').style.display = 'block';
        }
        function cancelPassword() {
            document.getElementById('account-info').style.display = 'block';
            document.getElementById('edit').style.display = 'none';
        }

        function cancelEdit() {
            document.getElementById('account-info').style.display = 'block';
            document.getElementById('edit-account-form').style.display = 'none';
        }


        function adminFunction() {
            window.open('admin_page.php', '_blank');
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

<script>
        function showPasswordChangeForm() {
            document.getElementById('password-change-form').style.display = 'block';
        }
    </script>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <a class="navbar-brand" href="#">Infosystém</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
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
                <?php

                $isAdmin = isset($_SESSION['isAdmin']) ? $_SESSION['isAdmin'] : false;


                if ($isAdmin) {
                    echo '<button class="white-button" onclick="adminFunction()">Admin</button>';
                }
                ?>
                <button class="white-button" onclick="editAccount()">Editovat účet</button>
                <button class="white-button" onclick="editPassword()">Změna Hesla</button>
            </div>
        </div>
        <div id="edit-account-form" style="display: none;">
            <form method="post" action="update_account.php" enctype="multipart/form-data">
                <p>
                    <label for="edit_first_name">Jméno:</label>
                    <input type="text" id="edit_first_name" name="edit_first_name"
                        value="<?php echo $row['first_name']; ?>">
                </p>
                <p>
                    <label for="edit_last_name">Příjmení:</label>
                    <input type="text" id="edit_last_name" name="edit_last_name"
                        value="<?php echo $row['last_name']; ?>">
                </p>

                <p>
                    <label for="edit_phone_number">Telefonní číslo:</label>
                    <input type="text" id="edit_phone_number" name="edit_phone_number"
                        value="<?php echo $row['phone_number']; ?>">
                </p>

                <p><label for="edit_email">Email:</label>
                    <input type="email" id="edit_email" name="edit_email" value="<?php echo $row['email']; ?>">
                </p>


                <div class="mb-3">
                    <label for="sex_edit" class="form-label">Pohlaví</label>
                    <select class="form-select" name="sex" id="sex_edit">
                        <option value="male" <?php echo ($row['sex'] === 'male') ? 'selected' : ''; ?>>muž</option>
                        <option value="female" <?php echo ($row['sex'] === 'female') ? 'selected' : ''; ?>>žena</option>
                        <option value="other" <?php echo ($row['sex'] === 'other') ? 'selected' : ''; ?>>ostatní</option>
                    </select>
                </div>


                <div class="mb-3">
                    <label for="edit_profile_picture" class="form-label">Profilová fotka</label>
                    <input type="file" class="form-control" name="profile_picture" id="edit_profile_picture">
                </div>
                

                <p><button type="submit" class="white-button">Uložit změny</button>
                    <button type="button" class="white-button" onclick="cancelEdit()">Zrušit</button>
                </p>

            </form>

            
        </div>
        <div id="edit" style="display: none;"><form method="post" action="" enctype="multipart/form-data">
            <div class="mb-3">
                <p>
                    <label for="current_password">Aktuální heslo:</label>
                    <input type="password" id="current_password" name="current_password" required>
                </p>
                <p>
                    <label for="new_password">Nové heslo:</label>
                    <input type="password" id="new_password" name="new_password" required>
                </p>
                
                <p>
                    <label for="confirm_password">Potvrzení hesla:</label>
                    <input type="password" id="confirm_password" name="confirm_password" required>
                </p>
                </div>
                <p>
                    <button type="submit" class="white-button" name="change_password">Změnit heslo</button>
                    <button type="button" class="white-button" onclick="cancelPassword()">Zrušit</button>
                </p>
            </form></div>
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
            document.getElementById('sex').innerText = '" . getGenderDisplayName($row['sex']) . "';
            document.getElementById('register_date').innerText = '{$row['register_date']}';

            var img = document.getElementById('profile_picture');
            img.src = " . ($row['img'] ? "'data:image/jpeg;base64," . base64_encode($row['img']) . "'" : getImagePathBasedOnGender($row['sex'])) . ";

            </script>";
} else {
    echo "Uživatel nebyl nalezen";
}
function getGenderDisplayName($gender)
{
    switch ($gender) {
        case 'male':
            return 'muž';
        case 'female':
            return 'žena';
        case 'other':
            return 'ostatní';
        default:
            return 'neznámé';
    }
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