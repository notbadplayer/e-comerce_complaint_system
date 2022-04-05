<?php
$taskData = $params['taskData'] ?? [];
$filestoDecode = str_replace('&quot;', '"', $taskData['files']);
$files = json_Decode($filestoDecode, true) ?? [];
$historytoDecode = str_replace('&quot;', '"', $taskData['history']);
$history = json_decode($historytoDecode, true);

?>
<div class="card" style="min-height: 80vh;">
    <div class="navbar navbar-expand-lg navbar-light bg-light h5">
        <div class="container-fluid">
            <div><i class="far fa-file-alt me-2"></i>Podgląd zlecenia</div>
            <div>
                <?php if (!empty($_SESSION['login'])) : ?>
                    <button onclick="history.back()" class="btn btn-primary btn-sm"><i class="fas fa-chevron-left me-1"></i><span class="d-none d-md-inline ms-1">Anuluj<span></button>
                <?php endif; ?>
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
                    <input type="text" class="form-control form-control-sm" id="customer" placeholder="nazwa zleceniodawcy" name="customer" value="<?php echo $taskData['customer'] ?? '' ?>" disabled>
                </div>

                <label for="customerEmail" class="col-lg-2 col-form-label-sm">e-mail klienta:</label>
                <div class="col-lg-4">
                    <input type="text" name="customerEmail" class="form-control form-control-sm" id="customerEmail" placeholder="email klienta" value="<?php echo $taskData['email'] ?? '' ?>" disabled>
                </div>
            </div>

            <div class="row mb-2">
                <label for="object" class="col-lg-2 col-form-label-sm">Przedmiot zlecenia:</label>
                <div class="col-lg-4">
                    <input type="text" class="form-control form-control-sm" id="object" placeholder="nazwa produktu" name="object" value="<?php echo $taskData['object'] ?? '' ?>" disabled>
                </div>

                <label for="receipt" class="col-lg-2 col-form-label-sm">numer paragonu:</label>
                <div class="col-lg-4">
                    <input type="text" class="form-control form-control-sm <?php echo (isset($messages['receipt']) ? 'is-invalid' : '') ?>" id="receipt" placeholder="nr dokumentu sprzedaży" name="receipt" value="<?php echo $taskData['receipt'] ?? '' ?>" disabled>
                </div>
            </div>

            <div class="row mb-2">
                <label for="type" class="col-lg-2 col-form-label-sm">Typ zlecenia:</label>
                <div class="col-lg-4">
                    <input type="text" class="form-control form-control-sm col-auto" id="type" placeholder="typ zlecenia" name="type" value="<?php echo $taskData['type'] ?? '' ?>" disabled>
                </div>
            </div>

            <div class="row mb-2">
                <label for="priority" class="col-lg-2 col-form-label-sm">Priorytet:</label>
                <div class="col-lg-4">
                    <input type="text" class="form-control form-control-sm col-auto" id="priority" placeholder="priorytet zgłoszenia" name="priority" value="<?php echo $taskData['priority'] ?? '' ?>" disabled>
                </div>
            </div>

            <div class="row mb-2">
                <label for="status" class="col-lg-2 col-form-label-sm">Status:</label>
                <div class="col-lg-4">
                    <input type="text" class="form-control form-control-sm col-auto" id="status" placeholder="status zgłoszenia" name="status" value="<?php echo $taskData['status'] ?? '' ?>" disabled>

                </div>
            </div>

            <div class="row mb-2">
                <label for="term" class="col-lg-2 col-form-label-sm">Termin realizacji:</label>
                <div class="col-lg-4">
                    <input type="text" class="form-control form-control-sm col-auto" id="status" placeholder="status zgłoszenia" name="status" value="<?php echo $taskData['term'] ?? '' ?>" disabled>
                </div>
            </div>

            <div class="row mb-2">
                <label for="description" class="col-lg-2 col-form-label-sm">Opis zlecenia:</label>
                <div class="col-sm-10">
                    <textarea rows="5" style="resize:none" class="form-control form-control-sm" id="description" placeholder="Wpisz opis zlecenia" name="description" disabled><?php echo $taskData['description'] ?? '' ?></textarea>
                </div>
            </div>

            <div class="row mt-5 mx-1 mb-2 border rounded">
                <div class="d-inline fs-6 mb-2">Lista dołączonych plików:</div>
                <?php if (count($files)) : ?>
                    <ul class="list-unstyled">
                        <?php foreach ($files as $file => $fileValue) : ?>
                            <li>
                                <a class="text-decoration-none" href="<?php echo $fileValue['location'] ?>"><i class="far fa-file me-2"></i><?php echo $fileValue['filename'] ?></a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php else : ?>
                    <span class="text-muted">Brak dodanych załączników</span>
                <?php endif; ?>
            </div>

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
                            <td class="d-none d-lg-table-cell"><?php echo str_replace('-&gt;', ' <i class="fas fa-arrow-right"></i> ', ($value['detail'] ?? '')) ?></td>
                            <td class="d-none d-lg-table-cell"><?php echo $value['comment'] ?? '' ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        </div>
    </div>
</div>