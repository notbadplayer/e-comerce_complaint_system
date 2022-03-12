<?php
$messages = $params['messages'] ?? [];
$taskData = $params['taskData'] ?? [];
$filestoDecode = str_replace('&quot;', '"', $taskData['files']);
$files = json_Decode($filestoDecode, true) ?? [];
$historytoDecode = (str_replace('&quot;', '"', $taskData['history']));
$history = json_decode($historytoDecode, true);

switch ($params['status'] ?? '') {
    case 'edited':
        echo '<div class="alert alert-primary alert-dismissible fade show" role="alert">
        Podstawowe dane zlecenia zostały aktualizowane.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
        break;
    case 'paramChanged':
        echo '<div class="alert alert-primary alert-dismissible fade show" role="alert">
            Parametr zlecenia został aktualizowany. Dopisano do historii.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
        break;
    case 'paramAdded':
        echo '<div class="alert alert-primary alert-dismissible fade show" role="alert">
            Dodano parametr do zlecenia. Dopisano do historii.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
        break;
    case 'fileAddError':
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
        Błąd dodawania pliku.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
        break;
}
?>

<div class="card" style="min-height: 80vh;">
    <div class="navbar navbar-expand-lg navbar-light bg-light h5">
        <div class="container-fluid">
            <div><i class="far fa-file-alt me-2"></i>Edycja zlecenia</div>
            <div>
                <a href="/" class="btn btn-primary btn-sm"><i class="fas fa-chevron-left me-1"></i><span class="d-none d-md-inline ms-1">Anuluj<span></a>
            </div>
        </div>
    </div>

    <div class="card-body p-5">
        <form method="post" action="/?action=edit">
            <input type="hidden" name="id" value="<?php echo $taskData['id'] ?? '' ?>" />
            <div class="row mb-2">
                <label for="entryNumber" class="col-lg-2 col-form-label-sm">Numer zlecenia:</label>
                <div class="col-lg-4">
                    <input type="text" class="form-control form-control-sm" id="entryNumber" placeholder="numer zgłoszenia" value="<?php echo $taskData['number'] ?>" disabled>
                </div>

                <label for="created" class="col-lg-2 col-form-label-sm">Data zlecenia:</label>
                <div class="col-lg-4">
                    <input type="text" name="created" class="form-control form-control-sm" id="created" placeholder="Data zgłoszenia" value="<?php echo $taskData['created'] ?? '' ?>" disabled>
                </div>
            </div>

            <div class="row mb-2">
                <label for="customer" class="col-lg-2 col-form-label-sm">Zleceniodawca:</label>
                <div class="col-lg-4">
                    <input type="text" class="form-control form-control-sm <?php echo (isset($messages['customer']) ? 'is-invalid' : '') ?>" id="customer" placeholder="nazwa zleceniodawcy" name="customer" value="<?php echo $taskData['customer'] ?? '' ?>">
                    <?php foreach ($messages['customer'] ?? [] as $message) : ?>
                        <span class="text-danger"><?php echo $message ?></span>
                    <?php endforeach; ?>
                </div>

                <label for="customerEmail" class="col-lg-2 col-form-label-sm">e-mail klienta:</label>
                <div class="col-lg-4">
                    <input type="text" name="customerEmail" class="form-control form-control-sm <?php echo (isset($messages['email']) ? 'is-invalid' : '') ?>" id="customerEmail" placeholder="email klienta" value="<?php echo $taskData['email'] ?? '' ?>">
                    <?php foreach ($messages['email'] ?? [] as $message) : ?>
                        <span class="text-danger"><?php echo $message ?></span>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="row mb-2">
                <label for="object" class="col-lg-2 col-form-label-sm">Przedmiot zlecenia:</label>
                <div class="col-lg-4">
                    <input type="text" class="form-control form-control-sm <?php echo (isset($messages['object']) ? 'is-invalid' : '') ?>" id="object" placeholder="nazwa produktu" name="object" value="<?php echo $taskData['object'] ?? '' ?>">
                    <?php foreach ($messages['object'] ?? [] as $message) : ?>
                        <span class="text-danger"><?php echo $message ?></span>
                    <?php endforeach; ?>
                </div>

                <label for="receipt" class="col-lg-2 col-form-label-sm">numer paragonu:</label>
                <div class="col-lg-4">
                    <input type="text" class="form-control form-control-sm <?php echo (isset($messages['receipt']) ? 'is-invalid' : '') ?>" id="receipt" placeholder="nr dokumentu sprzedaży" name="receipt" value="<?php echo $taskData['receipt'] ?? '' ?>">
                    <?php foreach ($messages['receipt'] ?? [] as $message) : ?>
                        <span class="text-danger"><?php echo $message ?></span>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="row mb-2">
                <label for="type" class="col-lg-2 col-form-label-sm">Typ zlecenia:</label>
                <div class="col-lg-4">
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
                <div class="col-lg-4">
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
                <div class="col-lg-4">
                    <a class="text-decoration-none" data-bs-toggle="modal" data-bs-target="#taskStatusPopup">
                        <div class="input-group">
                            <input type="text" class="form-control form-control-sm col-auto border-end-0 bg-white" id="status" placeholder="status zgłoszenia" name="status" value="<?php echo $taskData['status'] ?? '' ?>" disabled role="button">
                            <span class="input-group-text bg-white"><i class="fas fa-pencil-alt"></i></span>
                        </div>
                    </a>
                </div>
            </div>

            <div class="row mb-2">
                <label for="term" class="col-lg-2 col-form-label-sm">Termin realizacji:</label>
                <div class="col-lg-4">
                    <a class="text-decoration-none" data-bs-toggle="modal" data-bs-target="#taskTermPopup">
                        <div class="input-group">
                            <input type="text" class="form-control form-control-sm col-auto border-end-0 bg-white" id="status" placeholder="status zgłoszenia" name="status" value="<?php echo $taskData['term'] ?? '' ?>" disabled role="button">
                            <span class="input-group-text bg-white"><i class="fas fa-calendar-alt"></i></span>
                        </div>
                    </a>
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

            <div class="row mt-5 mb-2 border rounded <?php echo (isset($messages['file']) ? 'border border-danger' : '') ?>">
                <div class="d-inline fs-6 ">Lista dołączonych plików: <a class="btn btn-sm fs-5 link-primary" data-bs-toggle="modal" data-bs-target="#taskAddFile"><i class="fas fa-plus-circle"></i></a></div>
                <?php foreach ($messages['file'] ?? [] as $message) : ?>
                        <span class="text-danger"><?php echo $message ?></span>
                <?php endforeach; ?>
                <?php if (count($files)) : ?>
                    <ul class="list-unstyled">
                        <?php foreach ($files as $file => $fileValue) : ?>
                            <li>
                                <a class="text-decoration-none" href="<?php echo $fileValue['location'] ?>"><?php echo $fileValue['filename'] ?></a>
                                <a class="text-decoration-none link-danger" data-bs-toggle="modal" data-bs-target="#taskFileDelete" data-bs-filename="<?php echo $fileValue['filename']?>" data-bs-location="<?php echo $fileValue['location']?>" data-bs-fileId="<?php echo $file?>">
                                    <i class="far fa-trash-alt ms-2"></i></a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php else : ?>
                    <span class="text-muted">Brak dodanych załączników</span>
                <?php endif; ?>
            </div>




            <button type="submit" class="btn btn-primary me-3 mt-4 d-inline-block"><i class="fas fa-check me-2"></i>Zapisz zmiany</button>
            <a class="text-decoration-none btn btn-primary me-3 mt-4 d-inline-block" data-bs-toggle="modal" data-bs-target="#taskOtherPopup"><i class="fas fa-feather-alt me-2"></i>Dodaj inne zdarzenie</a>
            <a class="text-decoration-none btn btn-secondary me-3 mt-4 d-inline-block" data-bs-toggle="modal" data-bs-target="#taskArchivePopup"><i class="fas fa-archive me-2"></i>Przenieś do archiwum</a>
        </form>


        <div class="card mt-5">
            <div class="card-header">
                <h5 class="card-title"><i class="fas fa-history me-2"></i>Historia zmian</h5>
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
                            <td class="d-none d-lg-table-cell"><?php echo $value['detail'] ?? '' ?></td>
                            <td class="d-none d-lg-table-cell"><?php echo $value['comment'] ?? '' ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>


            </div>
        </div>


    </div>
</div>