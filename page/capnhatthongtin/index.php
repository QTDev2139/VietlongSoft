<?php

include('func/danhsachkh/index.php');

$data = layDanhSachKH();

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

<div style=" margin: 0; border-radius:5px; width:100%; height: 80vh; overflow-x:auto;">
    <table class="table table-hover table-bordered" id="myTable"> <!-- style="table-layout: fixed;" -->
        <tr>
            <th class="truncate-scroll"></th>
            <th class="w-100 truncate-scroll">Mã khách</th>
            <th class="w-200 truncate-scroll">Tên khách</th>
            <th class="w-100 truncate-scroll">Ngày bắt đầu</th>
            <th class="w-100 truncate-scroll">Ngày kết thúc</th>
            <th class="w-140 truncate-scroll">Trạng thái BH/BT</th>
            <th class="w-100 truncate-scroll">Trạng thái</th>
            <th class="w-100 truncate-scroll">GT_BH</th>
            <th class="w-100 truncate-scroll">Địa chỉ</th>
            <th class="w-100 truncate-scroll">Người tạo</th>
            <th class="w-140 truncate-scroll">Ngày tạo</th>
            <th class="w-100 truncate-scroll">Người sửa</th>
            <th class="w-140 truncate-scroll">Ngày sửa</th>
            <th class="w-140 truncate-scroll">Trạng thái</th>
        </tr>

        <!--  -->
        <?php foreach ($data as $d): ?>
            <tr>
                <td class=" text-center"><?= ++$dem; ?></td>
                <td>
                    <div class="limitLineCss"><?= $d['MA_KH'] ?></div>
                </td>
                <td>
                    <div class="limitLineCss" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="<?= $d['TEN_KH'] ?>"><?= $d['TEN_KH'] ?></div>
                </td>
                <td>
                    <div class="limitLineCss"><?= $d['NGAY_BD'] ?></div>
                </td>
                <td>
                    <div class="limitLineCss"><?= $d['NGAY_KT'] ?></div>
                </td>
                <td>
                    <div class="limitLineCss"><?= getTT_BH($d['TT_BH']) ?></div>
                </td>
                <td>
                    <div class="limitLineCss"><?= $d['TT'] ?></div>
                </td>
                <td>
                    <div class="limitLineCss"><?= number_format((float)$d['GT_BH'], 2) ?></div>
                </td>
                <td>
                    <div class="limitLineCss" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="<?= $d['DIA_CHI'] ?>"><?= $d['DIA_CHI'] ?></div>
                </td>
                <td>
                    <div class="limitLineCss"><?= $d['USER_ID0'] ?></div>
                </td>
                <td>
                    <div class="limitLineCss"><?= $d['DATETIME0'] ?></div>
                </td>
                <td>
                    <div class="limitLineCss"><?= $d['USER_ID2'] ?></div>
                </td>
                <td>
                    <div class="limitLineCss"><?= $d['DATETIME2'] ?></div>
                </td>
                <td>
                    <div class="limitLineCss">Đang sử dụng</div>
                </td>

            </tr>
        <?php endforeach; ?>

    </table>
</div>

<script>
    // $(function() {
    //     $("#myTable").colResizable({
    //         resizeMode: 'overflow',
    //         minWidth: 40,
    //         liveDrag: false,
    //     });
    // });

    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })
</script>