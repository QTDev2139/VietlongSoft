<!-- Modal Thêm-->
<div class="modal fade" id="addModel" tabindex="-1" aria-labelledby="addLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div id="add-draggable" class="p-5 rounded">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addLabel">Thêm</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="post">
                    <div class="modal-body">
                        <div class="row py-1">
                            <div class="col-sm-3">
                                <label class="col-form-label">MA_VT:</label>
                            </div>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="mavt_add" placeholder="MA_VT">
                            </div>
                        </div>
                        <div class="row py-1">
                            <div class="col-sm-3">
                                <label class="col-form-label">BAR_CODE:</label>
                            </div>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="barcode_add" placeholder="BAR_CODE">
                            </div>
                        </div>
                        <div class="row py-1">
                            <div class="col-sm-3">
                                <label class="col-form-label">TEN_VT:</label>
                            </div>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="tenvt_add" placeholder="TEN_VT">
                            </div>
                        </div>
                        <div class="row py-1">
                            <div class="col-sm-3">
                                <label class="col-form-label">TSUAT_VT:</label>
                            </div>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="tsuat_add" placeholder="TSUAT_VT">
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" name="submitAdd" class="btn btn-primary">Thêm mới</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
function nextItsRecVtg()
{
    $obj = new DatabaseMSSQLPDO();
    $sql = "SELECT MAX(CAST(SUBSTRING(ITS_REC_VT, 3, LEN(ITS_REC_VT) - 5) AS INT)) AS maxnum
            FROM ITSVT WHERE ITS_REC_VT LIKE 'KK%VTG'";

    $max = (int)($obj->xuatdulieu($sql)[0]['maxnum'] ?? 0);

    return 'KK' . str_pad((string)($max + 1), 8, '0', STR_PAD_LEFT) . 'VTG';
}

$obj = new DatabaseMSSQLPDO();
if (isset($_POST["submitAdd"])) {
    $id = nextItsRecVtg();
    $mavt = $_POST["mavt_add"];
    $barcode = $_POST["barcode_add"];
    $tenvt = $_POST["tenvt_add"];
    $tsuat = is_numeric($_POST["tsuat_add"]) ? (float)$_POST["tsuat_add"] : 0;
    $checkmavt = "SELECT MA_VT FROM ITSVT WHERE MA_VT = '$mavt'";
    if ($obj->xuatdulieu($checkmavt)) {
        echo '<script>alert("Trùng MA_VT");
                window.location.href="index.php?page=baocao&bc=1";</script>';
    } else {
        $sql = "insert into ITSVT(ITS_REC_VT, MA_VT, BAR_CODE, TEN_VT, TSUAT_VT) values ('$id', '$mavt', '$barcode',N'$tenvt', $tsuat)";
        // echo "<script>console.log(\"" . $sql . "\")</script>";
        if ($obj->themxoasua($sql))
            echo '';
        else {
            echo '<script>alert("Thêm thất bại");
                window.location.href="index.php?page=baocao&bc=1";</script>';
        }
    }
}

?>