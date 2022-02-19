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
                    <input type="text" class="form-control form-control-sm mb-5" id="comment" name="comment" placeholder="Tutaj można wpisać dodatkowy komentarz">
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
                <h5 class="modal-title">Zmiana Priorytetu zlecenia</h5>
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
                    <input type="text" class="form-control form-control-sm mb-5" id="comment" name="comment" placeholder="Tutaj można wpisać dodatkowy komentarz">
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
                    <input type="text" class="form-control form-control-sm mb-5" id="comment" name="comment" placeholder="Tutaj można wpisać dodatkowy komentarz">
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
                    <input name ="updatedValue" type="date" class="form-control form-control-sm <?php echo (isset($messages['term']) ? 'is-invalid' : '') ?>" id="term" value="<?php echo $taskData['term'] ?? '' ?>">
                    <?php foreach ($messages['term'] ?? [] as $message) : ?>
                        <span class="text-danger"><?php echo $message ?></span>
                    <?php endforeach; ?>

                    <label for="comment" class="col-form-label-sm">Dodatkowe informacje:</label>
                    <input type="text" class="form-control form-control-sm mb-5" id="comment" name="comment" placeholder="Tutaj można wpisać dodatkowy komentarz">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Anuluj</button>
                    <button type="submit" class="btn btn-primary">Zatwierdź</button>
                </div>
            </form>
        </div>
    </div>
</div>