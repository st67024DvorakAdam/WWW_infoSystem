<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    // Uživatel není přihlášen, takže zrušíme jeho relaci
    session_destroy();

    // Přesměrujte ho na stránku odhlášení nebo jinou vhodnou stránku
    header('Location: logout.php'); 
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Infosystém</title>

    <!-- CSS Files -->
    <link rel="stylesheet" href="https://unpkg.com/bootstrap@5.3.2/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://unpkg.com/bs-brain@2.0.2/components/logins/login-5/assets/css/login-5.css" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" data-no-delete="yes"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
    
</head>


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





    /* Barva textu pro odkaz "Příspěvky" */
    .nav-link[href="posts.php"] {
        font-weight: bold;
    }

    .navbar {
        background-color: #fff;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
        /* Zvětšený stín */
        border-radius: 0;
        /* Ostré rohy */
    }

    .navbar-brand {
        font-size: 24px;
        font-weight: bold;
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

    .list {
        width: 50%;
        background-color: transparent;
        margin: auto;        
        box-sizing: border-box;
        display: block;
   
    
    }

    .row {
        width: auto;
        height: auto;        
        margin-top: 20px;
        margin-bottom: 10px;
        padding-top: 10px;
        padding-bottom: 10px;        
        background: white;
        border-radius: 15px;

        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);

    }
   
    .form-control {
width: 100%;

    }
        /* Nastavení výšky obrázků na stejnou výšku */
        .picture img {
        height: 100px;
        width: 100px;
    }


    

   
</style>

<body>

    <!-- Navigační bar -->
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
     <!-- vytvoření nového postu -->
     <div class="list">
    
     <div class="row">
    <div class="col-md-6 offset-md-3">
        <div class="new-post">
            <form action="submit_post.php" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="post_text">Text příspěvku</label>
                    <textarea class="form-control" id="post_text" name="post_text" placeholder="Zadejte text" rows="4" required></textarea>
                </div>
                <div class="form-group">
                    <label for="post_image">Obrázek</label>
                    <div class="input-group">
                        <input type="file" class="form-control" id="post_image" name="post_image" accept="image/*">
                    </div>
                </div>
                <div class="text-center" style="padding-top: 10px;">
                    <button type="submit" class="btn btn-primary">Přidat</button>
                </div>
            </form>
        </div>
    </div>
</div>


</div>

     </div>
     
    <!-- post list -->
    <div class="list">
    <?php
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

// Získání dat z tabulky "Post" seřazených podle postDateTime sestupně
$sql = "SELECT * FROM Post ORDER BY postDateTime DESC";
$result = $conn->query($sql);

if ($result->rowCount() > 0) {
    foreach ($result as $row) {
        // Získání dat z řádku
        $imgData = $row['img'];
        $text = $row['text'];
        $postDateTime = $row['postDateTime'];
        $user_id = $row['user_id'];

        // Získání jména uživatele z tabulky "User" na základě user_id
        $userQuery = "SELECT first_name FROM User WHERE id = $user_id";
        $userResult = $conn->query($userQuery);

        if ($userResult->rowCount() > 0) {
            $userRow = $userResult->fetch(PDO::FETCH_ASSOC);
            $username = $userRow['first_name'];
        } else {
            $username = "Neznámý uživatel";
        }
?>
<div class="row">
    <div class="col-sm-6">
        <div class="post-content">
            <h4>
                <a href="#" class="username"><?= $username ?></a>
            </h4>
            <h5>
                <i class="date" style="font-size: 12px;"><?= $postDateTime ?></i>
            </h5>
            <p class="description"><?= $text ?></p>
        </div>
    </div>
    <div class="col-sm-6">
        <?php if ($imgData != null) { ?>
            <div class="picture">
                <img alt="Image" src="data:image/jpeg;base64,<?= base64_encode($imgData) ?>" style="width: 100%; height: 100%;">
            </div>
        <?php } ?>
    </div>
</div>


<?php
    }
} else {
    echo " ";
}

// Uzavření připojení k databázi
$conn = null;
?>
    </div>
</html>
