<?php
$messages = $params['messages'] ?? [];
$taskData = $params['taskData'] ?? [];
?>
<div class="card" style="min-height: 80vh;">
    <div class="navbar navbar-expand-lg navbar-light bg-light h5">
        <div class="container-fluid">
            <div><i class="far fa-file-alt me-2"></i>Dodawanie zlecenia</div>
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
                    <input type="text" class="form-control form-control-sm" id="entryNumber" placeholder="numer zgłoszenia" value="<?php echo $params['entryNumber'] ?? '' ?>" disabled>
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
                    <select name="type" class="form-select-sm col-sm-12 border" id="type">
                        <option value="Nie wybrano" <?php echo (!isset($taskData['type']) ? 'selected' : '') ?>>Nie wybrano</option>
                        <option value="Zwrot" <?php echo (isset($taskData['type']) && $taskData['type'] === 'Zwrot' ? 'selected' : '') ?>>Zwrot</option>
                        <option value="Gwarancyjne" <?php echo (isset($taskData['type']) && $taskData['type'] === 'Gwarancyjne' ? 'selected' : '') ?>>Gwarancyjne</option>
                    </select>
                </div>
            </div>

            <div class="row mb-2">
                <label for="priority" class="col-lg-2 col-form-label-sm">Priorytet:</label>
                <div class="col-lg-5">
                    <select name="priority" class="form-select-sm col-sm-12 border" id="priority">
                        <option value="" <?php echo (!isset($taskData['priority']) ? 'selected' : '') ?>>Standardowy</option>
                        <option value="Wysoki" <?php echo (isset($taskData['priority']) && $taskData['priority'] === 'Wysoki' ? 'selected' : '') ?>>Wysoki</option>
                        <option value="Niski" <?php echo (isset($taskData['priority']) && $taskData['priority'] === 'Niski' ? 'selected' : '') ?>>Niski</option>
                    </select>
                </div>
            </div>

            <div class="row mb-2">
                <label for="status" class="col-lg-2 col-form-label-sm">Status:</label>
                <div class="col-lg-5">
                    <select name="category" class="form-select-sm col-sm-12 border" id="status" name="status" disabled>
                        <option value="Przyjęte" selected>Przyjęte</option>
                    </select>
                </div>
            </div>

            <div class="row mb-2">
                <label for="term" class="col-lg-2 col-form-label-sm">Termin zlecenia:</label>
                <div class="col-lg-5">
                    <input type="date" class="form-control form-control-sm <?php echo (isset($messages['term']) ? 'is-invalid' : '') ?>" id="term" name="term" value="<?php echo $params['date'] ?? '' ?>">
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
    </div>
</div>