<?php
$tasks = $params['tasks'] ?? [];
switch ($params['status']) {
    case 'added':
        echo '<div class="alert alert-primary alert-dismissible fade show" role="alert">
        Zlecenie zostało dodane.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
        break;
    case 'archived':
        echo '<div class="alert alert-primary alert-dismissible fade show" role="alert">
        Zlecenie zostało zarchiwizowane.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
        break;
}
?>

<div class="card" style="min-height: 80vh;">
    <div class="navbar navbar-expand-lg navbar-light bg-light h5">
        <div class="container-fluid">
            <div><i class="fas fa-list me-2"></i>Lista zleceń</div>
        </div>
    </div>

    <div class="card-body">
        <?php if (count($tasks)) : ?>
            <div class="table-responsive text-nowrap">
                <table class="table table-striped table-hover table-sm">
                    <thead>
                        <th id="id" class="th_sort" role="button">Numer<i id="id_icon" class="<?php echo ($params['sort']['sortBy'] === 'id') ? ($params['sort']['order'] === '2' ? 'fas fa-sort-down ms-2' : 'fas fa-sort-up ms-2') : 'fas fa-sort ms-2' ?>"></i></th>
                        <th id="customer" class="th_sort" role="button">Klient<i id="customer_icon" class="<?php echo ($params['sort']['sortBy'] === 'customer') ? ($params['sort']['order'] === '2' ? 'fas fa-sort-down ms-2' : 'fas fa-sort-up ms-2') : 'fas fa-sort ms-2' ?>"></i></th>
                        <th id="type" class="th_sort d-none d-lg-table-cell" role="button">Typ<i id="type_icon" class="<?php echo ($params['sort']['sortBy'] === 'type') ? ($params['sort']['order'] === '2' ? 'fas fa-sort-down ms-2' : 'fas fa-sort-up ms-2') : 'fas fa-sort ms-2' ?>"></i></th>
                        <th id="priority" class="th_sort d-none d-lg-table-cell" role="button">Priorytet<i id="priority_icon" class="<?php echo ($params['sort']['sortBy'] === 'priority') ? ($params['sort']['order'] === '2' ? 'fas fa-sort-down ms-2' : 'fas fa-sort-up ms-2') : 'fas fa-sort ms-2' ?>"></i></th>
                        <th id="status" class="th_sort d-none d-md-table-cell" role="button">Status<i id="status_icon" class="<?php echo ($params['sort']['sortBy'] === 'status') ? ($params['sort']['order'] === '2' ? 'fas fa-sort-down ms-2' : 'fas fa-sort-up ms-2') : 'fas fa-sort ms-2' ?>"></i></th>
                        <th></th>
                    </thead>
                    <?php foreach ($tasks as $task) : ?>
                        <tr>
                            <td><?php echo $task['number'] ?></td>
                            <td class="text-wrap"><?php echo $task['customer'] ?></td>
                            <td class="d-none d-lg-table-cell"><?php echo $task['type'] ?></td>
                            <td class="d-none d-lg-table-cell"><?php echo $task['priority'] ?></td>
                            <td class="d-none d-md-table-cell"><?php echo $task['status'] ?></td>
                            <td>
                                <a href="/?action=show&id=<?php echo $task['id'] ?>" class="btn btn-secondary btn-sm"><i class="far fa-eye"></i><span class="d-none d-lg-inline ms-1">Podgląd<span></a>
                                <a href="/?action=edit&id=<?php echo $task['id'] ?>" class="btn btn-secondary btn-sm"><i class="fas fa-pencil-alt"></i><span class="d-none d-lg-inline ms-1">Edycja<span></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        <?php else : ?>
            <span class="text-muted">Brak wpisów w bazie danych, kliknij <a href="/?action=add" class="text-muted">tutaj</a>, aby dodać nowy</span>
        <?php endif; ?>
    </div>

    <div class="card-footer">
        <a href="/?action=add" class="btn btn-primary"><i class="fas fa-plus me-2"></i>Dodaj nowe zlecenie</a>
    </div>
</div>

<script>
    var th_sort = document.getElementsByClassName('th_sort');
    id = customer = type = priority = status = '<?php echo $params['sort']['order'] ?? 1 ?>'; //przypisanie jednej wartości do wielu zmiennych
    //korzystam z id a nie z number, bo w rzeczywistości sortuję po id
    for (let th of th_sort) {
        th.onclick = function() {
            changeParam(th.id);
            reloadPage(th.id);
        }
    }

    function changeParam(column) {
        icon = document.getElementById(column.concat('_icon'));
        window[column]++;
        if (window[column] == 3) {
            window[column] = 1;
        };
    }

    function reloadPage(column) {
        window.location.href = '/?sortBy=' + column + '&order=' + window[column];
    }
</script>