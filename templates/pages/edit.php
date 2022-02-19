<?php
$messages = $params['messages'] ?? [];
$taskData = $params['taskData'] ?? [];

$historytoDecode = str_replace('&quot;', '"', $taskData['historia']);
$history = json_decode($historytoDecode, true);
?>
<div class="card" style="min-height: 80vh;">
    <div class="navbar navbar-expand-lg navbar-light bg-light h5">
        <div class="container-fluid">
            <div><i class="far fa-file-alt me-2"></i>Edycja zlecenia</div>
            <div>
                <a href="/" class="btn btn-primary btn-sm"><i class="far fa-arrow-alt-circle-left"></i><span class="d-none d-md-inline ms-1">Anuluj<span></a>
            </div>
        </div>
    </div>

    <div class="card-body p-5">
        <form method="post" action="/?action=add">
            <div class="row mb-2">
                <label for="entryNumber" class="col-lg-2 col-form-label-sm">Numer zlecenia:</label>
                <div class="col-lg-5">
                    <input type="text" class="form-control form-control-sm" id="entryNumber" placeholder="numer zgłoszenia" value="<?php echo $taskData['number'] ?? '' ?>" disabled>
                </div>
            </div>

            <div class="row mb-2">
                <label for="customer" class="col-lg-2 col-form-label-sm">Zleceniodawca:</label>
                <div class="col-lg-5">
                    <input type="text" class="form-control form-control-sm <?php echo (isset($messages['customer']) ? 'is-invalid' : '') ?>" id="customer" placeholder="nazwa zleceniodawcy" name="customer" value="<?php echo $taskData['customer'] ?? '' ?>">
                    <?php foreach ($messages['customer'] ?? [] as $message) : ?>
                        <span class="text-danger"><?php echo $message ?></span>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="row mb-2">
                <label for="object" class="col-lg-2 col-form-label-sm">Przedmiot zlecenia:</label>
                <div class="col-lg-5">
                    <input type="text" class="form-control form-control-sm <?php echo (isset($messages['object']) ? 'is-invalid' : '') ?>" id="object" placeholder="nazwa produktu" name="object" value="<?php echo $taskData['object'] ?? '' ?>">
                    <?php foreach ($messages['object'] ?? [] as $message) : ?>
                        <span class="text-danger"><?php echo $message ?></span>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="row mb-2">
                <label for="type" class="col-lg-2 col-form-label-sm">Typ zlecenia:</label>
                <div class="col-lg-5">
                    <a class="text-decoration-none" data-bs-toggle="modal" data-bs-target="#taskTypePopup">
                        <div class="input-group">
                            <input type="text" class="form-control form-control-sm col-auto border-end-0 bg-white" id="type" placeholder="typ zlecenia" name="type" value="<?php echo $taskData['type'] ?? '' ?>" disabled role="button">
                            <span class="input-group-text bg-white"><i class="fas fa-pencil-alt"></i></span>
                        </div>
                    </a>
                </div>
            </div>

            <div class="row mb-2">
                <label for="priority" class="col-lg-2 col-form-label-sm">Priorytet:</label>
                <div class="col-lg-5">
                    <a class="text-decoration-none" data-bs-toggle="modal" data-bs-target="#taskPriorityPopup">
                        <div class="input-group">
                            <input type="text" class="form-control form-control-sm col-auto border-end-0 bg-white" id="priority" placeholder="priorytet zgłoszenia" name="priority" value="<?php echo $taskData['priority'] ?? '' ?>" disabled role="button">
                            <span class="input-group-text bg-white"><i class="fas fa-pencil-alt"></i></span>
                        </div>
                    </a>
                </div>
            </div>

            <div class="row mb-2">
                <label for="status" class="col-lg-2 col-form-label-sm">Status:</label>
                <div class="col-lg-5">
                    <a class="text-decoration-none" data-bs-toggle="modal" data-bs-target="#taskStatusPopup">
                        <div class="input-group">
                            <input type="text" class="form-control form-control-sm col-auto border-end-0 bg-white" id="status" placeholder="status zgłoszenia" name="status" value="<?php echo $taskData['status'] ?? '' ?>" disabled role="button">
                            <span class="input-group-text bg-white"><i class="fas fa-pencil-alt"></i></span>
                        </div>
                    </a>
                </div>
            </div>

            <div class="row mb-2">
                <label for="term" class="col-lg-2 col-form-label-sm">Termin zlecenia:</label>
                <div class="col-lg-5">
                    <input type="date" class="form-control form-control-sm <?php echo (isset($messages['term']) ? 'is-invalid' : '') ?>" id="term" name="term" value="<?php echo $taskData['term'] ?? '' ?>">
                    <?php foreach ($messages['term'] ?? [] as $message) : ?>
                        <span class="text-danger"><?php echo $message ?></span>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="row mb-2">
                <label for="description" class="col-lg-2 col-form-label-sm">Opis zlecenia:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control form-control-sm <?php echo (isset($messages['description']) ? 'is-invalid' : '') ?>" id="description" placeholder="Wpisz opis zlecenia" name="description" value="<?php echo $taskData['description'] ?? '' ?>">
                    <?php foreach ($messages['description'] ?? [] as $message) : ?>
                        <span class="text-danger"><?php echo $message ?></span>
                    <?php endforeach; ?>
                </div>
            </div>



            <button type="submit" class="btn btn-primary mt-3"><i class="fas fa-plus-circle me-2"></i>Dodaj</button>
        </form>

        <div class="card mt-5">
            <div class="card-header">
                <h5 class="card-title">Historia zmian</h5>
            </div>
            <div class="card-body">
                <table class="table table-striped table-hover table-sm">
                    <thead>
                        <th>Data</th>
                        <th>Zdarzenie</th>
                        <th class="d-none d-lg-table-cell">Szczegóły</th>
                        <th class="d-none d-lg-table-cell">Dodatkowe informacje</th>
                    </thead>
                    <?php foreach ($history as $key => $value) : ?>
                        <tr>
                            <td><?php echo $key ?></td>
                            <td><?php echo $value['action'] ?? '' ?></td>
                            <td><?php echo $value['detail'] ?? '' ?></td>
                            <td><?php echo $value['comment'] ?? '' ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>


            </div>
        </div>


    </div>
</div>