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

// Získání informací o uživateli na základě ID z parametru
if (isset($_GET['id'])) {
    $userId = $_GET['id'];

    $sql = "SELECT * FROM user WHERE id = :user_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':user_id', $userId);
    $stmt->execute();
    $userData = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$userData) {
        echo "Uživatel nebyl nalezen.";
        exit;
    }
} else {
    echo "Chybějící ID uživatele.";
    exit;
}

// Zpracování formuláře pro úpravu uživatele
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Zde implementujte logiku pro aktualizaci údajů v databázi
    $firstName = $_POST['first_name'];
    $lastName = $_POST['last_name'];
    $email = $_POST['email'];
    $phoneNumber = $_POST['phone_number'];
    $sex = $_POST['sex'];
    $isAdmin = isset($_POST['is_administrator']) ? 1 : 0;


    $updateSql = "UPDATE user SET first_name = :first_name, last_name = :last_name, email = :email, phone_number = :phone_number, sex = :sex, is_administrator = :is_administrator WHERE id = :user_id";

    $updateStmt = $conn->prepare($updateSql);
    $updateStmt->bindParam(':first_name', $firstName);
    $updateStmt->bindParam(':last_name', $lastName);
    $updateStmt->bindParam(':email', $email);
    $updateStmt->bindParam(':phone_number', $phoneNumber);
    $updateStmt->bindParam(':sex', $sex);
    $updateStmt->bindParam(':is_administrator', $isAdmin);

    $updateStmt->bindParam(':user_id', $userId);

    try {
        $updateStmt->execute();
        // Přesměrování na seznam uživatelů po úpravě
        header('Location: admin_page.php');
        exit;
    } catch (PDOException $e) {
        echo "Chyba při aktualizaci uživatele: " . $e->getMessage();
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upravit uživatele</title>

    <!-- CSS Files -->
    <link rel="stylesheet" href="https://unpkg.com/bootstrap@5.3.2/dist/css/bootstrap.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" data-no-delete="yes" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</head>

<body>
    <div class="container mt-5">
        <h1>Upravit uživatele</h1>
        <form method="post" action="edit_user.php?id=<?php echo $userData['id']; ?>">
            <label for="first_name">Jméno:</label>
            <input type="text" id="first_name" name="first_name" value="<?php echo $userData['first_name']; ?>" required>

            <label for="last_name">Příjmení:</label>
            <input type="text" id="last_name" name="last_name" value="<?php echo $userData['last_name']; ?>" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo $userData['email']; ?>" required>

            <label for="phone_number">Telefonní číslo:</label>
            <input type="number" id="phone_number" name="phone_number" value="<?php echo $userData['phone_number']; ?>">

            <label for="sex">Pohlaví:</label>
            <select id="sex" name="sex" required>
                <option value="male" <?php echo $userData['sex'] === 'male' ? 'selected' : ''; ?>>Muž</option>
                <option value="female" <?php echo $userData['sex'] === 'female' ? 'selected' : ''; ?>>Žena</option>
                <option value="other" <?php echo $userData['sex'] === 'other' ? 'selected' : ''; ?>>Ostatní</option>
            </select>

            <label for="is_administrator">Administrátor:</label>
            <input type="checkbox" id="is_administrator" name="is_administrator" <?php echo $userData['is_administrator'] ? 'checked' : ''; ?>>

            <button type="submit" class="btn btn-primary">Uložit změny</button>
        </form>
    </div>

    <?php
    // Uzavření spojení s databází
    $conn = null;
    ?>
</body>

</html>
