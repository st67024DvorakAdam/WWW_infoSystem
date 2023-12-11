<?php
session_start();

// Kontrola, zda je uživatel přihlášen jako administrátor
if (!isset($_SESSION['user_id']) || !isset($_SESSION['isAdmin']) || !$_SESSION['isAdmin']) {
    session_destroy();
    header('Location: logout.php');
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
    die("Nepodařilo se připojit k databázi: " . $e->getMessage());
}

// Získání seznamu všech uživatelů
$sql = "SELECT id, first_name, last_name, sex, email, phone_number, register_date FROM user";
$stmt = $conn->prepare($sql);
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);


function deleteUser($userId, $conn)
{
    $sql = "DELETE FROM user WHERE id = :user_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':user_id', $userId);

    try {
        $stmt->execute();
        // Přesměrování na stejnou stránku po smazání
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit;
    } catch (PDOException $e) {
        echo "Chyba při mazání uživatele: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrace uživatelů</title>

    <!-- CSS Files -->
    <link rel="stylesheet" href="https://unpkg.com/bootstrap@5.3.2/dist/css/bootstrap.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" data-no-delete="yes" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
<style>
        body,
        html {
            height: 100%;
            margin: 0;
        }

        body {
            background-color: #fff;
            background-size: cover;
            background-attachment: fixed;
        }

        img {
            width: 225px;
            height: 225px;
            border: 2px solid black;
        }

        .navbar {
            background-color: #2069f5;
            color: white;
        }

        .navbar-brand {
            font-size: 24px;
        }

        .navbar-nav .nav-item {
            padding: 0 15px;
        }

        .navbar-nav .nav-link {
            color: #fff!important;
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


        


        .button-container {
            display: flex;
            justify-content: flex-end;
            margin-right: 40px;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light ">
        <div class="container">
            <a class="navbar-brand" href="#" style="color: #fff;">Infosystém</a>
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
                        <a class="nav-link" href="admin_page.php">Administrace</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Odhlásit</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container mt-5">
        <h1>Administrace uživatelů</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Jméno</th>
                    <th>Příjmení</th>
                    <th>Pohlaví</th>
                    <th>Email</th>
                    <th>Telefonní číslo</th>
                    <th>Registrován</th>
                    <th>Akce</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user) : ?>
                    <tr>
                        <td><?php echo $user['id']; ?></td>
                        <td><?php echo $user['first_name']; ?></td>
                        <td><?php echo $user['last_name']; ?></td>
                        <td><?php echo $user['sex']; ?></td>
                        <td><?php echo $user['email']; ?></td>
                        <td><?php echo $user['phone_number']; ?></td>
                        <td><?php echo $user['register_date']; ?></td>
                        <td>
                        <a href="edit_user.php?id=<?php echo $user['id']; ?>" class="btn btn-primary">Upravit</a>

                            <a href="admin_page.php?delete_id=<?php echo $user['id']; ?>" class="btn btn-danger" onclick="return confirm('Opravdu chcete smazat uživatele?')">Odebrat</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>

</html>

<?php
    
   
    

    
    $conn = null;
    ?>
