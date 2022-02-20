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
            <div><i class="fas fa-archive me-2"></i>Zlecenia archiwalne</div>
        </div>
    </div>

    <div class="card-body">
        <div class="table-responsive text-nowrap">
            <table class="table table-striped table-hover table-sm">
                <thead>
                    <th>Numer</th>
                    <th>Klient</th>
                    <th class="d-none d-lg-table-cell">Typ</th>
                    <th class="d-none d-lg-table-cell">Priorytet</th>
                    <th class="d-none d-md-table-cell">Status</th>
                    <th></th>
                </thead>
                <?php foreach ($tasks as $task) : ?>
                    <tr>
                        <td><?php echo $task['number'] ?></td>
                        <td><?php echo $task['customer'] ?></td>
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
    </div>

    <div class="card-footer">
    </div>
</div>