<?php
$articles = $params['articles'] ?? [];
switch ($params['status']) {
    case 'added':
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
        Artykuł został dodany.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
        break;
    case 'edited':
        echo '<div class="alert alert-primary alert-dismissible fade show" role="alert">
        Artykuł został aktualizowany.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
        break;
    case 'deleted':
        echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
        Artykuł został usunięty.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
        break;
}
?>

<div class="card" style="min-height: 80vh;">
    <div class="navbar navbar-expand-lg navbar-light bg-light h5">
        <div class="container-fluid">
            <div><i class="fas fa-list me-2"></i>Lista artykułów</div>
        </div>
    </div>

    <div class="card-body">
        <div class="table-responsive text-nowrap">
            <table class="table table-primary table-striped table-bordered table-hover ">
                <thead>
                    <th>Id</th>
                    <th>Tytuł</th>
                    <th>Kategoria</th>
                    <th>Status</th>
                    <th>Opcje</th>
                </thead>
                <?php foreach ($articles as $article) : ?>
                    <tr>
                        <td><?php echo $article['id'] ?></td>
                        <td><?php echo $article['title'] ?></td>
                        <td><?php echo ((bool) $article['category']) ? $article['category'] : 'brak kategorii' ?></td>
                        <td><?php echo ((int)$article['status']) ? 'Opublikowany' : 'Ukryty' ?></td>
                        <td>
                            <a href="/?action=show&id=<?php echo $article['id'] ?>" class="btn btn-primary"><i class="far fa-eye"></i><span class="d-none d-lg-inline ms-1">Wyświetl<span></a>
                            <a href="/?action=edit&id=<?php echo $article['id'] ?>" class="btn btn-primary"><i class="fas fa-pencil-alt"></i><span class="d-none d-lg-inline ms-1">Edycja<span></a>
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#deletePopup"><i class="far fa-trash-alt"></i><span class="d-none d-lg-inline ms-1">Usuń<span></button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </div>

    <div class="card-footer">
        <a href="/?action=add" class="btn btn-primary">Dodaj nowy artykuł</a>
    </div>
</div>