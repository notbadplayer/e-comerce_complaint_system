<div class="modal fade" id="taskTypePopup" tabindex="-1" aria-labelledby="taskTypePopup" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Zmiana typu zlecenia</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="/?action=changeParam">
                <input type="hidden" name="id" value="<?php echo $taskData['id'] ?? '' ?>" />
                <input type="hidden" name="taskAction" value="type" />
                <input type="hidden" name="previousValue" value="<?php echo $taskData['type'] ?? '' ?>" />
                <div class="modal-body">
                    <label for="updatedValue" class="col-form-label-sm">Typ zlecenia:</label>
                    <select name="updatedValue" class="form-select-sm col-12 border mb-3" id="updatedValue">
                        <option value="Nie wybrano" <?php echo (!isset($taskData['type']) ? 'selected' : '') ?>>Nie wybrano</option>
                        <option value="Zwrot" <?php echo (isset($taskData['type']) && $taskData['type'] === 'Zwrot' ? 'selected' : '') ?>>Zwrot</option>
                        <option value="Gwarancyjne" <?php echo (isset($taskData['type']) && $taskData['type'] === 'Gwarancyjne' ? 'selected' : '') ?>>Gwarancyjne</option>
                    </select>

                    <label for="comment" class="col-form-label-sm">Dodatkowe informacje:</label>
                    <input type="text" class="form-control form-control-sm mb-5" id="comment" name="comment" placeholder="Tutaj można wpisać dodatkowy komentarz" maxlength="100">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Anuluj</button>
                    <button type="submit" class="btn btn-primary">Zatwierdź</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="taskPriorityPopup" tabindex="-1" aria-labelledby="taskPriorityPopup" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Zmiana priorytetu zlecenia</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="/?action=changeParam">
                <input type="hidden" name="id" value="<?php echo $taskData['id'] ?? '' ?>" />
                <input type="hidden" name="taskAction" value="priority" />
                <input type="hidden" name="previousValue" value="<?php echo $taskData['priority'] ?? '' ?>" />
                <div class="modal-body">
                    <label for="updatedValue" class="col-form-label-sm">Priorytet zlecenia:</label>
                    <select name="updatedValue" class="form-select-sm col-12 border" id="updatedValue">
                        <option value="Standardowy" <?php echo (!isset($taskData['priority']) ? 'selected' : '') ?>>Standardowy</option>
                        <option value="Wysoki" <?php echo (isset($taskData['priority']) && $taskData['priority'] === 'Wysoki' ? 'selected' : '') ?>>Wysoki</option>
                        <option value="Niski" <?php echo (isset($taskData['priority']) && $taskData['priority'] === 'Niski' ? 'selected' : '') ?>>Niski</option>
                    </select>

                    <label for="comment" class="col-form-label-sm">Dodatkowe informacje:</label>
                    <input type="text" class="form-control form-control-sm mb-5" id="comment" name="comment" placeholder="Tutaj można wpisać dodatkowy komentarz" maxlength="100">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Anuluj</button>
                    <button type="submit" class="btn btn-primary">Zatwierdź</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="taskStatusPopup" tabindex="-1" aria-labelledby="taskStatusPopup" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Zmiana statusu zlecenia</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="/?action=changeParam">
                <input type="hidden" name="id" value="<?php echo $taskData['id'] ?? '' ?>" />
                <input type="hidden" name="taskAction" value="status" />
                <input type="hidden" name="previousValue" value="<?php echo $taskData['status'] ?? '' ?>" />
                <div class="modal-body">
                    <label for="updatedValue" class="col-form-label-sm">Status zlecenia:</label>
                    <select name="updatedValue" class="form-select-sm col-12 border" id="status" name="status">
                        <option value="Przyjęte" <?php echo (isset($taskData['status']) && $taskData['status'] === 'Przyjęte' ? 'selected' : '') ?>>Przyjęte</option>
                        <option value="w trakcie realizacji" <?php echo (isset($taskData['status']) && $taskData['status'] === 'w trackie realizacji' ? 'selected' : '') ?>>w trakcie realizacji</option>
                        <option value="zrealizowane" <?php echo (isset($taskData['status']) && $taskData['status'] === 'zrealizowane' ? 'selected' : '') ?>>zrealizowane</option>
                        <option value="anulowane" <?php echo (isset($taskData['status']) && $taskData['status'] === 'anulowane' ? 'selected' : '') ?>>anulowane</option>
                    </select>

                    <label for="comment" class="col-form-label-sm">Dodatkowe informacje:</label>
                    <input type="text" class="form-control form-control-sm mb-5" id="comment" name="comment" placeholder="Tutaj można wpisać dodatkowy komentarz" maxlength="100">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Anuluj</button>
                    <button type="submit" class="btn btn-primary">Zatwierdź</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="taskTermPopup" tabindex="-1" aria-labelledby="taskTermPopup" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Zmiana terminu realizacji</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="/?action=changeParam">
                <input type="hidden" name="id" value="<?php echo $taskData['id'] ?? '' ?>" />
                <input type="hidden" name="taskAction" value="term" />
                <input type="hidden" name="previousValue" value="<?php echo $taskData['term'] ?? '' ?>" />
                <div class="modal-body">
                    <label for="updatedValue" class="col-form-label-sm">Termin realizacji zlecenia:</label>
                    <input name="updatedValue" type="date" class="form-control form-control-sm" id="term" value="<?php echo $taskData['term'] ?? '' ?>" min="<?php echo $taskData['created'] ?? '' ?>">
                    <label for="comment" class="col-form-label-sm">Dodatkowe informacje:</label>
                    <input type="text" class="form-control form-control-sm mb-5" id="comment" name="comment" placeholder="Tutaj można wpisać dodatkowy komentarz" maxlength="100">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Anuluj</button>
                    <button type="submit" class="btn btn-primary">Zatwierdź</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="taskOtherPopup" tabindex="-1" aria-labelledby="taskOtherPopup" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Dodaj niestandardowe zdarzenie</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="/?action=addParam">
                <input type="hidden" name="id" value="<?php echo $taskData['id'] ?? '' ?>" />
                <div class="modal-body">
                    <label for="event" class="col-form-label-sm">Nazwa zdarzenia:</label>
                    <input name="event" type="text" class="form-control form-control-sm" id="term" placeholder="wpisz nazwę zdarzenia">
                    <label for="comment" class="col-form-label-sm">Dodatkowe informacje:</label>
                    <input type="text" class="form-control form-control-sm mb-5" id="comment" name="comment" placeholder="Tutaj można wpisać dodatkowy komentarz" maxlength="100">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Anuluj</button>
                    <button type="submit" class="btn btn-primary">Zatwierdź</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="taskArchivePopup" tabindex="-1" aria-labelledby="taskArchivePopup" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Czy chcesz przenieść do archiwum?</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <span>Zlecenia w archiwum są bezpieczne, i można będzie je przeglądać.</span>
                <form method="post" action="/?action=delete">
                    <input type="hidden" name="id" value="<?php echo $taskData['id'] ?? '' ?>" />
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Anuluj</button>
                <button type="submit" class="btn btn-primary">Zatwierdź</button>
            </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="taskFileDelete" tabindex="-1" aria-labelledby="taskFileDelete" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Usunąć plik?</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <span>Załącznik <span id="fileNameField"></span> zostanie usunięty.</span>
                <form method="post" action="/?action=deleteFile">
                    <input type="hidden" name="id" value="<?php echo $taskData['id'] ?>" />
                    <input type="hidden" id="fileId" name="fileId" />
                    <input type="hidden" id="location" name="location" />
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Anuluj</button>
                <button type="submit" class="btn btn-primary">Zatwierdź</button>
            </div>
            </form>
        </div>
    </div>
</div>

<script>
    //Tutaj jest logika przekazywania parametrów do wyskakującego okienka, ona musi byc , bo w pętli wartości są nadpisywane :(
    var taskFileDeleteModal = document.getElementById('taskFileDelete')
    taskFileDeleteModal.addEventListener('show.bs.modal', function(event) {
        // Button that triggered the modal
        var button = event.relatedTarget
        // Extract info from data-bs-* attributes
        var fileName = button.getAttribute('data-bs-filename')
        var filenameField = document.getElementById('fileNameField')
        filenameField.textContent = fileName;

        var fileId = button.getAttribute('data-bs-fileId')
        var fileIdInput = document.getElementById('fileId')
        fileIdInput.value = fileId

        var location = button.getAttribute('data-bs-location')
        var locationInput = document.getElementById('location')
        locationInput.value = location
    })
</script>

<div class="modal fade" id="taskAddFile" tabindex="-1" aria-labelledby="taskAddFile" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Dodawanie załącznika</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" action="/?action=addFile" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?php echo $taskData['id'] ?>" />
                    <input type="file" class="form-control form-control-sm" id="file" name="file">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Anuluj</button>
                <button type="submit" class="btn btn-primary">Zatwierdź</button>
            </div>
            </form>
        </div>
    </div>
</div>
