<!-- Modal Update-->
<div class="modal fade" id="updateModel" tabindex="-1" aria-labelledby="updateLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div id="update-draggable" class="p-5 rounded">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="updateLabel">Sửa</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form method="post">
          <div class="modal-body">
            <input type="hidden" id="edit_id" name="ITS_REC_VT">

            <!-- <div class="row py-1">
            <div class="col-sm-3">
              <label class="col-form-label">ITS_REC_VT:</label>
            </div>
            <div class="col-sm-9">
              <input type="text" class="form-control" id="edit_id" name="ITS_REC_VT" placeholder="ITS_REC_VT" readonly>
            </div>
          </div> -->
            <div class="row py-1">
              <div class="col-sm-3">
                <label class="col-form-label">MA_VT:</label>
              </div>
              <div class="col-sm-9">
                <input type="text" class="form-control" id="ma_vt" name="mavt_update" placeholder="MA_VT">
              </div>
            </div>
            <div class="row py-1">
              <div class="col-sm-3">
                <label class="col-form-label">BAR_CODE:</label>
              </div>
              <div class="col-sm-9">
                <input type="text" class="form-control" id="bar_code" name="barcode_update" placeholder="BAR_CODE">
              </div>
            </div>
            <div class="row py-1">
              <div class="col-sm-3">
                <label class="col-form-label">TEN_VT:</label>
              </div>
              <div class="col-sm-9">
                <input type="text" class="form-control" id="ten_vt" name="tenvt_update" placeholder="TEN_VT">
              </div>
            </div>
            <div class="row py-1">
              <div class="col-sm-3">
                <label class="col-form-label">TSUAT_VT:</label>
              </div>
              <div class="col-sm-9">
                <input type="text" class="form-control" id="tsuat_vt" name="tsuatvt_update" placeholder="TSUAT_VT">
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" name="submitUpdate" class="btn btn-success">Lưu</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<?php
$obj = new DatabaseMSSQLPDO();
if (isset($_POST["submitUpdate"])) {
  $itsrecvt = $_POST["ITS_REC_VT"];
  $mavt = $_POST["mavt_update"] ?? null;
  $barcode = $_POST["barcode_update"] ?? null;
  $tenvt = $_POST["tenvt_update"] ?? null;
  $tsuat =  is_numeric($_POST["tsuatvt_update"]) ? $_POST["tsuatvt_update"] : 0;
  $checkmavt = "SELECT MA_VT FROM ITSVT WHERE MA_VT = '$mavt' AND ITS_REC_VT != '$itsrecvt'";
  if ($obj->xuatdulieu($checkmavt)) {
    echo '<script>alert("Trùng MA_VT");
                window.location.href="index.php?page=baocao&bc=1";</script>';
  } else {
    $sql = "Update ITSVT set MA_VT='$mavt', BAR_CODE='$barcode', TEN_VT=N'$tenvt', TSUAT_VT=$tsuat where ITS_REC_VT='$itsrecvt' ";
    $obj->themxoasua($sql);
    // echo '<script>window.location.href="index.php?page=baocao&bc=1";</script>';
    
  }
}

?>