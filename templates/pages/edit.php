<?php
$messages = $params['messages'] ?? [];
$articleData = $params['articleData'] ?? [];
?>
<div class="card" style="min-height: 80vh;">
    <div class="navbar navbar-expand-lg navbar-light bg-light h5">
        <div class="container-fluid">
            <div><i class="far fa-file-alt me-2"></i>Edycja artykułu</div>
            <div>
                <a href="/" class="btn btn-primary"><i class="far fa-arrow-alt-circle-left"></i><span class="d-none d-md-inline ms-1">Anuluj<span></a>
            </div>
        </div>
    </div>

    <div class="card-body p-5">
        <form method="post" action="/?action=edit">
            <input type="hidden" name="id" value="<?php echo $articleData['id']; ?>"/>
            <div class="form-group mb-3">
                <label for="title">Tytuł artykułu</label>
                <input type="text" name="title" class="form-control <?php echo (isset($messages['title']) ? 'is-invalid' : '') ?>" id="title" aria-describedby="titleField" placeholder="Tytuł artykułu" value="<?php echo $articleData['title'] ?? '' ?>">
                <?php foreach ($messages['title'] ?? [] as $message) : ?>
                    <div class="text-danger"><?php echo $message ?></div>
                <?php endforeach; ?>
            </div>
            <div class="form-group">
                <label for="content">Treść</label>
                <textarea rows="10" class="form-control <?php echo (isset($messages['content']) ? 'is-invalid' : '') ?>" id="content" name="content" placeholder="Treść artykułu"><?php echo $articleData['content']; ?></textarea>
                <?php foreach ($messages['content'] ?? [] as $message) : ?>
                    <div class="text-danger"><?php echo $message ?></div>
                <?php endforeach; ?>
            </div>

            <div class="form-group mt-4">
                <div class="d-inline-block">Status:
                    <label class="m-3">Opublikowany <input type="radio" name="status" value="1" <?php echo (isset($articleData['status']) && $articleData['status'] == 1 ? 'checked' : '') ?> /></label>
                    <label>Ukryty <input type="radio" name="status" value="0" <?php echo (!isset($articleData['status']) || (int)$articleData['status'] === 0 ? 'checked' : '') ?>></label>
                </div>
                <div class="d-inline-block ms-5">
                    <label>Kategoria:
                        <div class="d-inline-block">
                            <select name="category" class="form-select">
                                <option value="" <?php echo (!isset($articleData['category']) ? 'selected' : '') ?>>Brak kategorii</option>
                                <option value="Kategoria 1" <?php echo (isset($articleData['category']) && $articleData['category'] === 'Kategoria 1' ? 'selected' : '') ?>>Kategoria 1</option>
                                <option value="Kategoria 2" <?php echo (isset($articleData['category']) && $articleData['category'] === 'Kategoria 2' ? 'selected' : '') ?>>Kategoria 2</option>
                                <option value="Kategoria 3" <?php echo (isset($articleData['category']) && $articleData['category'] === 'Kategoria 3' ? 'selected' : '') ?>>Kategoria 3</option>
                            </select>
                        </div>
                    </label>
                </div>
            </div>
            <button type="submit" class="btn btn-primary mt-3"><i class="fas fa-check me-2"></i>Zapisz</button>
        </form>
    </div>
</div>