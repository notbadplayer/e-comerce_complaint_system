<div class="modal fade" id="deletePopup" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalLabel">Usunąć artykuł?</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Ta operacja jest nieodwracalna
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="far fa-arrow-alt-circle-left me-2"></i>Anuluj</button>
        <form method="post" action="/?action=delete">
            <input type="hidden" name="id" value="<?php echo $article['id'] ?>"/>
            <button type="submit" class="btn btn-danger"><i class="far fa-trash-alt me-2"></i>Usuń</button>
        </form>
      </div>
    </div>
  </div>
</div>