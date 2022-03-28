<?php
$userConfiguration = $params['userConfiguration'];
$taskTypes = explode(';', $userConfiguration['tasks_types']);
$statusTypes = explode(';', $userConfiguration['status_types']);
$messages = $params['messages'] ?? [];
switch ($params['status'] ?? '') {
    case 'configModified':
        echo '<div class="alert alert-primary alert-dismissible fade show" role="alert">
        Konfiguracja została zapisana.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
        break;
    case 'configEditError':
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            Błąd zapisu konfiguracji. 
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
        break;
}
?>
<div class="card" style="min-height: 80vh;">
    <div class="navbar navbar-expand-lg navbar-light bg-light h5">
        <div class="container-fluid">
            <div><i class="far fa-file-alt me-2"></i>Konfiguracja systemu</div>
            <div>
                <a href="/" class="btn btn-primary btn-sm"><i class="fas fa-chevron-left me-1"></i><span class="d-none d-md-inline ms-1">Anuluj<span></a>
            </div>
        </div>
    </div>

    <div class="card-body p-0 p-md-2 p-xl-5">

        <form method="post" action="/?action=changeUserSettings">
            <div class="container">
                <div class="row row-cols-1 row-cols-md-2 g-4">
                    <div class="col">

                        <div class="card p-3" style="height: 25rem;">
                            <div class="card-body">
                                <h5 class="card-title mb-3"><i class="far fa-envelope me-2"></i>Mailing</h5>
                                <div class="form-check form-switch mb-2 mb-lg-4">
                                    <input class="form-check-input" name="enableMails" type="checkbox" role="switch" value="1" id="enable_mails_switch" <?php echo (isset($userConfiguration['enableMails']) && $userConfiguration['enableMails'] === '1' ? 'checked' : '') ?>>
                                    <label class="form-check-label" for="enable_mails_switch">Włącz powiadomienia mailowe</label>
                                </div>

                                <div id="mails_detailed_switches">
                                    <div class="mb-2">Powiadamiaj o:</div>
                                    <div class="px-3">
                                        <div class="row mb-2">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input mail_secondary" name="mail_register" type="checkbox" role="switch" value="1" id="mail_register" <?php echo (isset($userConfiguration['mail_register']) && $userConfiguration['mail_register'] === '1' ? 'checked' : '') ?>>
                                                <label class="form-check-label" for="mail_register">utworzeniu nowego zlecenia</label>
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input mail_secondary" name="mail_type" type="checkbox" role="switch" value="1" id="mail_type" <?php echo (isset($userConfiguration['mail_type']) && $userConfiguration['mail_type'] === '1' ? 'checked' : '') ?>>
                                                <label class="form-check-label" for="mail_type">zmianie typu zgłoszenia</label>
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input mail_secondary" name="mail_priority" type="checkbox" role="switch" value="1" id="mail_priority" <?php echo (isset($userConfiguration['mail_priority']) && $userConfiguration['mail_priority'] === '1' ? 'checked' : '') ?>>
                                                <label class="form-check-label" for="mail_priority">zmianie priorytetu zgłoszenia</label>
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input mail_secondary" name="mail_status" type="checkbox" role="switch" value="1" id="mail_status" <?php echo (isset($userConfiguration['mail_status']) && $userConfiguration['mail_status'] === '1' ? 'checked' : '') ?>>
                                                <label class="form-check-label" for="mail_status">zmianie statusu zgłoszenia</label>
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input mail_secondary" name="mail_term" type="checkbox" role="switch" value="1" id="mail_term" <?php echo (isset($userConfiguration['mail_term']) && $userConfiguration['mail_term'] === '1' ? 'checked' : '') ?>>
                                                <label class="form-check-label" for="mail_term">zmianie terminu realizacji</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="col">
                        <div class="card p-3 <?php echo (isset($messages['task_types']) ? 'border border-danger' : '') ?>" style="height: 25rem;">
                            <div class="card-body">
                                <h5 class="card-title mb-3"><i class="fas fa-bars me-2"></i>Typy zleceń</h5>
                                <div class="mb-2">Zdefiniuj typy zleceń:</div>
                                <div id="taskTypesField">
                                    <?php for ($i = 0; $i < count($taskTypes); $i++) : ?>
                                        <input type="text" class="form-control form-control-sm task_type_input mb-1" id="task_type_input" placeholder="wpisz typ zlecenia" name="task_type_<?php echo $i ?>" value="<?php echo $taskTypes[$i] ?? '' ?>">
                                    <?php endfor; ?>
                                </div>
                                <button id="addTaskType" class="btn btn-primary btn-sm mt-2"><i class="fas fa-plus me-2"></i>Dodaj</button>
                                <?php foreach ($messages['task_types'] ?? [] as $message) : ?>
                                    <div class="text-danger"><?php echo $message ?></div>
                                <?php endforeach; ?>
                            </div>
                            <div class="card-footer bg-transparent p-0 m-md-2">
                                <small class="text-muted">Zmiany zostaną wprowadzone dla nowych zleceń.</small>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card p-3 <?php echo (isset($messages['status_types']) ? 'border border-danger' : '') ?>" style="height: 25rem;">
                            <div class="card-body">
                                <h5 class="card-title mb-3"><i class="fas fa-tasks me-2"></i>Statusy zleceń</h5>
                                <div class="mb-2">Zdefiniuj statusy zleceń:</div>
                                <div id="statusTypesField">
                                    <?php for ($i = 0; $i < count($statusTypes); $i++) : ?>
                                        <input type="text" class="form-control form-control-sm task_status_input mb-1" id="status_type_input" placeholder="wpisz status zlecenia" name="status_type_<?php echo $i ?>" value="<?php echo $statusTypes[$i] ?? '' ?>">
                                    <?php endfor; ?>
                                </div>
                                <button id="addStatusType" class="btn btn-primary btn-sm mt-2"><i class="fas fa-plus me-2"></i>Dodaj</button>
                                <?php foreach ($messages['status_types'] ?? [] as $message) : ?>
                                    <div class="text-danger"><?php echo $message ?></div>
                                <?php endforeach; ?>
                            </div>
                            <div class="card-footer bg-transparent p-0 m-md-2">
                                <small class="text-muted">Zmiany zostaną wprowadzone dla nowych zleceń.</small>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card p-3" style="height: 25rem;">
                            <div class="card-body">
                                <h5 class="card-title mb-3"><i class="fas fa-ellipsis-h me-2"></i>Inne ustawienia</h5>
                                <div class="row row-cols-1 row-cols-xl-2 g-0 mb-2">
                                    <label for="taskPeriod" class="col col-form-label-sm">Domyślny czas realizacji: <span id="rangeValueView"></span> dni</label>
                                    <div class="col">
                                        <input type="range" name="taskPeriod" class="form-range" min="1" max="14" step="1" id="taskPeriod" value="<?php echo $userConfiguration['task_period']?>">
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>


                </div>
            </div>
    </div>
    <div class="card-footer text-end">
    <a href="/" class="btn btn-secondary"><i class="fas fa-chevron-left me-1"></i><span class="ms-1">Anuluj<span></a>
        <button type="submit" class="btn btn-primary"><i class="fas fa-check me-2"></i>Zapisz zmiany</button>
        </form>
    </div>
</div>

<script>
    //to jest skrypt do obsługi wyłączania checkboxów mailowych
    var mailSwitch = document.getElementById('enable_mails_switch');
    var mailSwitches = document.getElementById("mails_detailed_switches");
    //przy ładowaniu strony
    window.onload = function() {
        if (mailSwitch.checked === true) {
            mailSwitches.style.display = 'block';
        } else {
            mailSwitches.style.display = 'none';
        }
        rangeValueView.textContent = rangeBar.value;
    };
    //przy zmianie checkboxa
    mailSwitch.addEventListener('change', (event) => {
        if (event.currentTarget.checked) {
            mailSwitches.style.display = 'block';
        } else {
            mailSwitches.style.display = 'none';
        }
    })

    //logika dodawania inputów
    const addTaskTypeButton = document.getElementById('addTaskType');
    const addStatusTypeButton = document.getElementById('addStatusType');
    const rangeBar = document.getElementById('taskPeriod');
    let rangeValueView = document.getElementById('rangeValueView');
    addTaskTypeButton.addEventListener("click", function(event) {
        event.preventDefault()
        const taskTypesFields = document.getElementsByClassName('task_type_input')
        let lastFieldNumber = taskTypesFields[taskTypesFields.length - 1];
        let nextFieldNumber = lastFieldNumber.name.slice(10);
        nextFieldNumber++;
        if (nextFieldNumber >= 5) {
            let modal = new bootstrap.Modal(document.getElementById('maxTaskTypesReached'), {})
            modal.show();
        } else {
            let field = document.createElement("input");
            field.setAttribute("type", "text");
            field.setAttribute("class", "form-control form-control-sm task_type_input mb-1");
            field.setAttribute("placeholder", "wpisz typ zlecenia");
            field.setAttribute("name", "task_type_".concat(nextFieldNumber));
            taskTypesField.appendChild(field);
        };
    });
    addStatusTypeButton.addEventListener("click", function(event) {
        event.preventDefault()
        const statusTypesFields = document.getElementsByClassName('task_status_input')
        let lastFieldNumber = statusTypesFields[statusTypesFields.length - 1];
        let nextFieldNumber = lastFieldNumber.name.slice(12);
        nextFieldNumber++;
        if (nextFieldNumber >= 5) {
            let modal = new bootstrap.Modal(document.getElementById('maxTaskTypesReached'), {})
            modal.show();
        } else {
            let field = document.createElement("input");
            field.setAttribute("type", "text");
            field.setAttribute("class", "form-control form-control-sm task_status_input mb-1");
            field.setAttribute("placeholder", "wpisz status zlecenia");
            field.setAttribute("name", "status_type_".concat(nextFieldNumber));
            statusTypesField.appendChild(field);
        };
    });

    //logika paska czasu zgłoszenia
    rangeBar.addEventListener("change", function(event) {
        rangeValueView.textContent = rangeBar.value;
    });
</script>