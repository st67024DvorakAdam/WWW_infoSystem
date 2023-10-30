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
    body, html {
        height: 100%;
        margin: 0;
    }

    body {
        background-color: #2069f5;
        background-size: cover;
        background-attachment: fixed;
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
                        <a class="nav-link" href="acount.php">Můj Účet</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Odhlásit</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Bílý pruh ve středu stránky -->
    <div class="center-container">
        <!-- Zde můžete umístit další obsah nebo kontejnery -->
        <h2>Vítejte ve vašem Infosystému</h2>
        <p>Toto je bílý pruh uprostřed stránky, kde můžete umístit další obsah.</p>
    </div>

    <!-- Bílé tlačítko zarovnané doprava mezi okrajem celé stránky a pravým okrajem bílého kontejneru -->
    <div class="button-container">
        <button class="white-button">+ Přidat příspěvek</button>
    </div>

</body>

</html>
