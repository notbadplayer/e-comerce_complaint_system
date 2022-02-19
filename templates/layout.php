<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Artykuły</title>
    <link href="src/Libraries/bootstrap/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="src/Libraries/fontawesome/css/all.min.css" rel="stylesheet">
</head>

<body>
    <script src="src/Libraries/bootstrap/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    <nav class="navbar navbar-expand-lg navbar navbar-dark bg-primary mb-5">
        <div class="container-fluid">
            <a class="navbar-brand me-5" href="/">Artykuły</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav">
                    <a class="nav-link " aria-current="page" href="/">Lista artykułów</a>
                    <a class="nav-link" href="/?action=add">Dodaj artykuł</a>
                </div>
            </div>
        </div>
    </nav>

    <div class="container">
        <?php 
        require_once("templates/pages/$page.php"); 
        require_once("templates/pages/delete.php"); 
        require_once("templates/pages/popups.php"); 
        ?>
    </div>
</body>

</html>