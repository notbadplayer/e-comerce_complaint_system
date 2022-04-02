<?php
$tasks = $params['tasks'] ?? [];
?>

<div class="card" style="min-height: 80vh;">
    <div class="navbar navbar-expand-lg navbar-light bg-light h5">
        <div class="container-fluid">
            <div><i class="fas fa-archive me-2"></i>Zlecenia archiwalne</div>
        </div>
    </div>

    <div class="card-body">
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
                            <a href="/?action=showArchived&id=<?php echo $task['id'] ?>" class="btn btn-sm"><i class="far fa-eye"></i><span class="d-none d-lg-inline ms-1">Podgląd<span></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </div>

    <div class="card-footer">
    <?php 
        $paginatorRedirect = 'listArchive';
        require_once('templates/pages/paginator.php'); 
        ?>
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
        window.location.href = '/?action=listArchive&sortBy=' + column + '&order=' + window[column];
    }
</script>