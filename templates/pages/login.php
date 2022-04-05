<!doctype html>
<html lang="pl">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="K.Rogaczewski">
    <title>System Obsługi Reklamacji - logowanie</title>

    <link href="src/Libraries/bootstrap/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }
    </style>

    <link href="templates/css/signin.css" rel="stylesheet">
</head>

<body class="text-center">
    <main class="form-signin">
        <form method="post" action="/?action=login">
            <?php echo (!empty($logoLocation)) ? "<img class='mb-4' src=$logoLocation style='max-height:725px;max-width:500px'></img>" : '' ?>
            <h1 class="h3 mb-3 fw-normal">Zaloguj się</h1>

            <div class="form-floating">
                <input type="text" name="username" class="form-control" id="floatingInput" placeholder="Nazwa użytkownika">
                <label for="floatingInput">Nazwa użytkownika</label>
            </div>
            <div class="form-floating">
                <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="Hasło">
                <label for="floatingPassword">Hasło</label>
            </div>
            <?php if ($error) : ?>
                <span class="text-danger mb-3"><?php echo $error ?></span>
            <?php endif; ?>

            <button class="w-100 btn btn-lg btn-primary" type="submit">Zaloguj się</button>
            <p class="mt-5 mb-3 text-muted">&copy; 2022 K.Rogaczewski</p>
        </form>
    </main>

</body>

</html>