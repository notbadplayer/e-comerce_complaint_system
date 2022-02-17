<?php
$article = $params['article'] ?? [];
?>
<div class="card" style="min-height: 80vh;">
    <div class="navbar navbar-expand-lg navbar-light bg-light h5">
        <div class="container-fluid">
            <div><i class="far fa-file-alt me-2"></i>Wyświetlanie artukułu</div>
            <div>
                <a href="/" class="btn btn-primary"><i class="far fa-arrow-alt-circle-left"></i><span class="d-none d-md-inline ms-1">Powrót<span></a>
                <a href="/?action=edit&id=<?php echo $article['id'] ?>" class="btn btn-primary"><i class="fas fa-pencil-alt"></i><span class="d-none d-md-inline ms-1">Edycja<span></a>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#deletePopup"><i class="far fa-trash-alt"></i><span class="d-none d-md-inline ms-1">Usuń<span></button>
            </div>
        </div>
    </div>

    <div class="card-body p-5">
        <div class="headerArticle mb-5">
            <div class="h1 display-1">
                <?php echo $article['title']; ?>
            </div>
            <div class="blockquote">
                <span class="me-4">Kategoria: <?php echo ((bool) $article['category']) ? $article['category'] : 'brak kategorii' ?></span>
                <span class="me-4">Status: <?php echo ((int)$article['status']) ? 'Opublikowany' : 'Ukryty' ?></span>
            </div>
        </div>
        <div>
            <div>
                <?php echo $article['content'] ?>
            </div>
        </div>
    </div>

</div>