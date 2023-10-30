<!DOCTYPE html>
<html lang="en">

<head>
    <title>Infosystém</title>

    <!-- CSS Files -->
    <link rel="stylesheet" href="https://unpkg.com/bootstrap@5.3.2/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://unpkg.com/bs-brain@2.0.2/components/logins/login-5/assets/css/login-5.css" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" data-no-delete="yes" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
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



    /* Bílý pruh ve středu stránky */
    .center-container {
        background-color: #fff;
        padding: 20px;
        border-radius: 5px;
        margin: 30px auto;
        max-width: 800px;
        height: 100vh;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);

    }

    /* Bílé tlačítko */
    .white-button {
        background-color: #2069f5;
        /* Modrá barva */
        color: white;
        /* Bílý text */
        border: none;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.4);
        border-radius: 20px;
        padding: 10px 15px;
        cursor: pointer;
        margin-top: auto;
        text-align: center;
        /* Zarovnání textu na střed */
        position: sticky;
        bottom: 10%;
        left: 45%;
    }

    .white-button:hover {
        background-color: white;
        /* Bílé pozadí při najetí myší */
        color: #2069f5;
        /* Modrý text při najetí myší */
    }

    /* Zarovnání tlačítka doprava */
    .button-container {
        display: flex;
        justify-content: flex-end;
        margin-right: 40px;
    }

    /* Barva textu pro odkaz "Příspěvky" */
    .nav-link[href="chat.php"] {
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
</style>

<body>

    <!-- Navigační bar -->
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

    <!-- Tlačítko vedle center kontejneru -->
    <button class="white-button">+ Přidat příspěvek</button>
    </div>

</body>

</html>