<!-- Modal Xóa-->
<div class="modal fade" id="deleteModel" tabindex="-1" aria-labelledby="deleteLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div id="delete-draggable" class="p-5 rounded">
      <div class="modal-content">
        <form method="post">
          <input type="hidden" id="delete_id" name="ITS_REC_VT_DELETE">
          <div class="modal-header">
            <h5 class="modal-title" id="deleteLabel">Xóa</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            Bạn có chắc chắn muốn xóa không?
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" name="btnDelete" class="btn btn-danger">Xóa</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<?php
if (isset($_POST['btnDelete'])) {
  $sql = "delete from ITSVT where ITS_REC_VT='" . $_POST['ITS_REC_VT_DELETE'] . "'";
  $obj->themxoasua($sql);
}
?>