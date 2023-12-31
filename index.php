<?php
/*
$url = "index.php";
  
  header("Location: " . $url);
  exit;
*/
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <title>INFOSYSTEM s r.o.</title>

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
        background-color: #108FFD;
        background-size: cover;
        /* Nastaví obrázek tak, aby pokrýval celou plochu */
        background-attachment: fixed;
        /* Umožní zafixovat pozadí, aby zůstalo viditelné při posouvání stránky */
    }

    .card {
        border: none;
        /* Removes the border */
        border-radius: 40px;
        /* Rounded corners with different values */
    }

    section {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
    }

    @media (max-width: 576px) {
        section {
            height: auto;
            min-height: 100vh;
        }
    }
</style>

<body>

    <section class="p-3 p-md-4 p-xl-5">
        <div class="container">
            <div class="card border-light-subtle shadow-sm">
                <div class="row g-0">
                    <div class="col-12 col-md-6 text-bg-primary" style="border-radius: 37px 0px 0px 37px;">
                        <div class="d-flex align-items-center justify-content-center h-100">
                            <div class="col-10 col-xl-8 py-3">
                                <img class="img-fluid rounded mb-4" loading="lazy" src="https://images-wixmp-ed30a86b8c4ca887773594c2.wixmp.com/f/c0840e59-db43-4681-ae7b-31a04dc4bc55/d7eqdvw-4e97ac92-e4b9-4498-9655-e4d612eb478b.png/v1/fill/w_1192,h_670/random_logo_by_criticl_d7eqdvw-pre.png?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJ1cm46YXBwOjdlMGQxODg5ODIyNjQzNzNhNWYwZDQxNWVhMGQyNmUwIiwiaXNzIjoidXJuOmFwcDo3ZTBkMTg4OTgyMjY0MzczYTVmMGQ0MTVlYTBkMjZlMCIsIm9iaiI6W1t7ImhlaWdodCI6Ijw9OTAwIiwicGF0aCI6IlwvZlwvYzA4NDBlNTktZGI0My00NjgxLWFlN2ItMzFhMDRkYzRiYzU1XC9kN2VxZHZ3LTRlOTdhYzkyLWU0YjktNDQ5OC05NjU1LWU0ZDYxMmViNDc4Yi5wbmciLCJ3aWR0aCI6Ijw9MTYwMCJ9XV0sImF1ZCI6WyJ1cm46c2VydmljZTppbWFnZS5vcGVyYXRpb25zIl19.X991O1jF5lTNZbbEoHEfoo6nlHEihBMHMIm5-uBCXcU" width="400" height="160" alt="">
                                <hr class="border-primary-subtle mb-4">
                                <h2 class="h1 mb-4">INFOSYSTEM</h2>
                                <p class="lead m-0">Jsme specializovanou firmou, která se zaměřuje na vývoj
                                    a implementaci moderních informačních systémů a webových aplikací, které umožňují
                                    efektivní správu dat a procesů pro naše klienty.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="card-body p-3 p-md-4 p-xl-5">
                            <div class="row">
                                <div class="col-12">
                                    <div class="mb-5">
                                        <h3>Přihlášení</h3>
                                    </div>
                                </div>
                            </div>
                            <form action="login_register.php" method="post">
                                <div class="row gy-3 gy-md-4 overflow-hidden">
                                    <div class="col-12">
                                        <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                        <input type="email" class="form-control" name="email" id="email" placeholder="JanNovak@priklad.com" required>
                                    </div>
                                    <div class="col-12">
                                        <label for="password" class="form-label">Heslo <span class="text-danger">*</span></label>
                                        <input type="password" class="form-control" name="password" id="password" value="" required>
                                    </div>
                                    <div class="col-12">
                                        
                                    </div>
                                    <div class="col-12">
                                        <div class="d-grid">
                                            <button class="btn bsb-btn-xl btn-primary" type="submit" name="login">Přihlásit se</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <div class="row">
                                <div class="col-12">
                                    <hr class="mt-5 mb-4 border-secondary-subtle">
                                    <div class="d-flex gap-2 gap-md-4 flex-column flex-md-row justify-content-md-end">
                                        <a href="register.php" class="link-secondary text-decoration-none">Vytvořit nový učet</a>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>

</html>
