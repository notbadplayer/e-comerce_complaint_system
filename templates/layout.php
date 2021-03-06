<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>System Obsługi Reklamacji</title>
    <link href="src/Libraries/bootstrap/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="src/Libraries/fontawesome/css/all.min.css" rel="stylesheet">
</head>

<body>
    <script src="src/Libraries/bootstrap/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <nav class="navbar navbar-expand-lg navbar navbar-dark bg-primary mb-5">
        <div class="container-fluid">
            <a class="navbar-brand me-5" href="/">
                Obsługa Reklamacji</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <?php if (!empty($_SESSION['login'])) : ?>
                <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                    <div class="navbar-nav">
                        <a class="nav-link <?php echo(isset($page) && $page === 'list') ? 'active' : ''?>" aria-current="page" href="/">Lista zleceń</a>
                        <a class="nav-link <?php echo(isset($page) && $page === 'add') ? 'active' : ''?>" href="/?action=add">Dodaj zlecenie</a>
                        <a class="nav-link <?php echo(isset($page) && $page === 'archive') ? 'active' : ''?>" href="/?action=listArchive">Przeglądaj archiwum</a>
                    </div>
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item dropdown-menu-end">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user me-2"></i><?php echo $_SESSION['login'] ?>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownMenuLink">
                                <li><a class="dropdown-item" href="/?action=changeUserSettings"><i class="fas fa-cog me-2"></i>Ustawienia</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="/?action=logout"><i class="fas fa-sign-out-alt me-2"></i>Wyloguj się</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            <?php endif; ?>
        </div>
    </nav>

    <div class="container">
        
        <?php
        require_once("templates/pages/$page.php");
        require_once("templates/pages/popups.php");
        ?>
    </div>
</body>

</html>