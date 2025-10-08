<?php
include_once("layout/modal/modal-baocao/addModal.php");
include_once("layout/modal/modal-baocao/updateModal.php");
include_once("layout/modal/modal-baocao/deleteModal.php");

$obj = new DatabaseMSSQLPDO();

$getVlsUser = 'SELECT id, UserName FROM dbo.VLSUSER';
$getItsTrangthai = 'SELECT * FROM dbo.ITSTRANGTHAI';
$getItsver = 'SELECT ITS_REC_VER, MA_VER FROM dbo.ITSVER';
$getItsKH = 'SELECT ITS_REC_KH, TEN_KH FROM dbo.ITSKH';
$getTT_BH = 'SELECT ITS_REC_KH, TT_BHBT FROM ITSCNBHBT';

$getVlsTasks = 'SELECT ID, Subject, User_id2, DateTime2, User_id0, DateTime0, StartDate, DueDate, Color, COMPERCENT, Status, FormID, EditDate, SubjectGroup, FormID, ITS_REC_KH, ITS_REC_VER 
                FROM dbo.VLSTASKS 
                ORDER BY StartDate DESC';

$readVlsUser     = $obj->xuatdulieu($getVlsUser);
$readItsTrangthai = $obj->xuatdulieu($getItsTrangthai);
$readItsver      = $obj->xuatdulieu($getItsver);
$readItsKH      = $obj->xuatdulieu($getItsKH);
$readVlsTasks    = $obj->xuatdulieu($getVlsTasks);
$readTT_BH = $obj->xuatdulieu($getTT_BH);

// Map user, status, version
$userMap = [];
foreach ($readVlsUser as $user) $userMap[(int)$user['id']] = $user['UserName'];

$statusMap = [];
foreach ($readItsTrangthai as $state) $statusMap[(int)$state['ID_TRANGTHAI']] = $state['TEN_TRANGTHAI'];

$itsKHMap = [];
foreach ($readItsKH as $itsKH) $itsKHMap[(string)$itsKH['ITS_REC_KH']] = $itsKH['TEN_KH'];

$verMap = [];
foreach ($readItsver as $ver) $verMap[$ver['ITS_REC_VER']] = $ver['MA_VER'];

$TT_BHMap = [];
foreach ($readTT_BH as $TT_BH) $TT_BHMap[$TT_BH['ITS_REC_KH']] = $TT_BH['TT_BHBT'];

// Chuẩn hoá rows và nhóm theo StartDate (đã format d/m/Y)
$grouped = [];
foreach ($readVlsTasks as $t) {
    $keyStart = !empty($t['StartDate']) ? date('d/m/Y', strtotime($t['StartDate'])) : '';
    $grouped[$keyStart][] = [
        'Subject'       => $t['Subject'],
        'TEN_TRANGTHAI' => $statusMap[(int)$t['Status']] ?? 'N/A',
        'ITS_KH'        => $itsKHMap[(string)$t['ITS_REC_KH']] ?? '',
        'UserName'      => $userMap[(int)$t['User_id0']] ?? 'N/A',  // người tạo
        'UpdatedBy'     => $userMap[(int)$t['User_id2']] ?? 'N/A',
        'Version'       => $verMap[$t['ITS_REC_VER']] ?? '',
        'TT_BH'         => $TT_BHMap[$t['ITS_REC_KH']] ?? '',
        'COMPERCENT'    => $t['COMPERCENT'],
        'StartDate'     => $keyStart,
        'DueDate'       => !empty($t['DueDate']) ? date('d/m/Y', strtotime($t['DueDate'])) : '',
        'DateTime0'     => !empty($t['DateTime0']) ? date('d/m/Y', strtotime($t['DateTime0'])) : '',
        'DateTime2'     => !empty($t['DateTime2']) ? date('d/m/Y', strtotime($t['DateTime2'])) : '',
    ];
}

function getStatusClass($statusName)
{
    return match ($statusName) {
        'Chờ sửa' => 'status-cho-sua',
        'Đang sửa' => 'status-dang-sua',
        'Hoàn thành' => 'status-hoan-thanh',
        'Chờ test' => 'status-cho-test',
        'Chờ khách phản hồi' => 'status-cho-khach',
        'Hủy' => 'status-huy',
        'Chưa update' => 'status-chua-update',
        'Chưa update lỗi' => 'status-chua-update',
        'Chăm sóc' => 'status-cham-soc',
        default => 'status-default'
    };
}
function getPrecentClass($precent)
{
    return match ($precent) {
        '100' => 'percent-style',
        default => ''
    };
}
function getTT_BH($ttbh)
{
    return match ($ttbh) {
        '0' => 'Đang Bảo Hành',
        '1' => 'Tạm ngừng BH',
        '2' => 'Ngừng BH',
        '3' => 'Đang Bảo trì',
        '4' => 'Tạm ngừng bảo trì',
        '5' => 'Ngừng bảo trì',
        default => 'Chưa cập nhật trạng thái'
    };
}

?>
<div style="padding-bottom: 20px;">
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModel">Thêm mới F3</button>
    <button type="button" class="btn btn-success ms-3" data-bs-target="#updateModel" id="btnUpdate">Sửa F4</button>
    <button type="button" class="btn btn-danger ms-3" data-bs-target="#deleteModel" id="btnDelete">Xóa F8</button>
</div>
<div style=" margin: 0; border-radius:5px; width:100%; max-height: 75vh; overflow-x:auto;">
    <table class="table table-hover table-bordered" id="myTable"> <!-- style="table-layout: fixed;" -->
        <tr>
            <th class="w-200 truncate-scroll">Chủ đề</th>
            <th class="w-100 truncate-scroll">Ngày yêu cầu</th>
            <th class="w-100 truncate-scroll">Trạng thái</th>
            <th class="w-260 truncate-scroll">Tên khách</th>
            <th class="w-200 truncate-scroll">Tiêu đề</th>
            <th class="w-100 truncate-scroll">% Hoàn thành</th>
            <th class="w-140 truncate-scroll">Trạng thái khách</th>
            <th class="w-100 truncate-scroll">Phiên bản</th>
            <th class="w-100 truncate-scroll">Ngày bắt đầu</th>
            <th class="w-100 truncate-scroll">Ngày kết thúc</th>
            <th class="w-100 truncate-scroll">Ngày tạo</th>
            <th class="w-100 truncate-scroll">Ngày sửa</th>
            <th class="w-140 truncate-scroll">Người đăng</th>
            <th class="w-100 truncate-scroll">Mã khách</th>
            <th class="w-200 truncate-scroll">Form</th> 
        </tr>
        <?php if (!empty($grouped)) : ?>
            <?php foreach ($grouped as $startDate => $items): ?>
                <?php
                $label = $startDate ?: '';
                $count = count($items);
                ?>
                <!--  -->
                <tr class="table group-toggle" style="background-color: #f5f9ffff;" data-group="<?= $label ?>">
                    <td colspan="15">
                        <strong>Ngày bắt đầu: <?= $label ?> (<?= $count ?>)</strong>
                    </td>
                </tr>

                <!--  -->
                <?php foreach ($items as $r): ?>
                    <tr class="<?= getStatusClass($r['TEN_TRANGTHAI']) ?> group-row" data-group="<?= $label ?>" data-id="<?= $r['ITS_KH'] ?>">
                        <td></td>
                        <td>
                            <div class="limitLineCss"><?= $r['DateTime0'] ?></div>
                        </td>
                        <td>
                            <div class="limitLineCss" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="<?= $r['TEN_TRANGTHAI'] ?>"><?= $r['TEN_TRANGTHAI'] ?></div>
                        </td>
                        <td>
                            <div class="limitLineCss" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="<?= $r['ITS_KH'] ?>"><?= $r['ITS_KH'] ?></div>
                        </td>
                        <td>
                            <div class="limitLineCss" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="<?= $r['Subject'] ?>"><?= $r['Subject'] ?></div>
                        </td>
                        <td>
                            <div class="limitLineCss <?= getPrecentClass($r['COMPERCENT']) ?> text-center"><?= $r['COMPERCENT'] ?>%</div>
                        </td>
                        <td>
                            <div class="limitLineCss"><?= getTT_BH($r['TT_BH']) ?></div>
                        </td>
                        <td>
                            <div class="limitLineCss"><?= $r['Version'] ?></div>
                        </td>
                        <td>
                            <div class="limitLineCss"><?= $r['StartDate'] ?></div>
                        </td>
                        <td>
                            <div class="limitLineCss"><?= $r['DueDate'] ?></div>
                        </td>
                        <td>
                            <div class="limitLineCss"><?= $r['DateTime0'] ?></div>
                        </td>
                        <td>
                            <div class="limitLineCss"><?= $r['DateTime2'] ?></div>
                        </td>
                        <td>
                            <div class="limitLineCss"><?= $r['UserName'] ?></div>
                        </td>
                        <td>
                            <div></div>
                        </td>
                        <td>
                            <div class="limitLineCss"><?= $r['FormID'] ?></div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="14" class="text-center text-danger">Không có dữ liệu</td>
            </tr>
        <?php endif; ?>
    </table>
</div>


<script src="layout/js/xulymodal.js"></script>
<script>
    // $(function() {
    //     $("#myTable").colResizable({
    //         resizeMode: 'overflow',
    //         minWidth: 40,
    //         liveDrag: false,
    //     });
    // });
    $('.group-toggle').on('dblclick', function() {
        const group = $(this).data('group');
        const rows = $(`.group-row[data-group="${group}"]`);
        rows.toggle(); // ẩn / hiện
    });

    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })
</script>