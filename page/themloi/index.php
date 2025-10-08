<?php
// SELECT * FROM dbo.ITSTRANGTHAI

$obj = new DatabaseMSSQLPDO();

$getItsTrangthai = 'SELECT * FROM dbo.ITSTRANGTHAI';

$readItsTrangthai = $obj->xuatdulieu($getItsTrangthai);
?>

<form method="post" style="margin: 0 40px">
    <table style="width: 100%; ">
        <tr>
            <td style="width: 100px">
                <span>Mã khách</span>
            </td>
            <td id="dskhGroup">
                <div class="d-flex align-items-center" style="position: relative;">
                    <input class="d-none" id="ITS_REC_KH" name="ITS_REC_KH" />
                    <input type="text" class="form-control" id="maKH" style="width: 160px; margin: 5px 0" name="MA_KH">
                    <div class="ps-2" id="tenKH" style="position: absolute; width: 500px; left: 160px;"></div>
                </div>
                <div style="position: absolute; top: 155px; border: 1px solid #333; left: 141px; width: 500px; max-height: 50vh; overflow-x:auto; display: none; background-color: #fff;" id="dskh">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th style="min-width: 105px">Mã khách hàng</th>
                                <th style="min-width: 200px">Tên khách hàng</th>
                                <th>TT_BHANH</th>
                                <th style="min-width: 80px">NGAY_KT</th>
                                <th style="min-width: 80px">NGAY_BD</th>
                                <th style="min-width: 200px">Địa chỉ</th>
                                <th style="min-width: 80px">Mã số thuế</th>
                                <th style="min-width: 80px">Điện thoại</th>
                                <th style="min-width: 120px">Tên khách hàng 2</th>
                            </tr>
                        </thead>
                        <tbody id="kh-tbody">
                        </tbody>

                    </table>
                </div>
            </td>
        </tr>
        <tr>
            <td style="width: 100px"><span>Trạng thái khách</span></td>
            <td style="width: 260px;"><input type="text" class="form-control me-3" id="TT_KH" name="TT_BH" disabled></td>
            <td style="width: 100px" class="ps-2">
                <div>Phiên bản</div>
            </td>
            <td id="dspbGroup">
                <div class="d-flex align-items-center" style="width: 300px;">
                    <input class="d-none" id="ITS_REC_VER" name="ITS_REC_VER" />
                    <input type="text" class="form-control" style="width: 120px; margin: 5px 0" id="maphienban" name="MA_PHIENBAN">
                    <div class="ps-2" id="tenphienban"></div>
                </div>
                <div style="position: absolute; top: 200px; border: 1px solid #333;  max-height: 50vh; overflow-x:auto; display: none; background-color: #fff;" id="dspb">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th style="min-width: 80px">Phiên bản</th>
                                <th style="min-width: 120px">Tên phiên bản</th>
                            </tr>
                        </thead>
                        <tbody id="pb-tbody">
                        </tbody>

                    </table>
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <span>Chủ đề</span>
            </td>
            <td colspan="3"><input type="text" class="form-control" style="width: 100%; margin: 5px 0" value="Hoá đơn dịch vụ bán --> Hoá đơn điện tử BKAV" name="subjectGroup"></td>
        </tr>
        <tr>
            <td>
                <span>Ngày bắt đầu</span>
            </td>
            <td><input style="width: 200px; margin: 5px 0" type="date" class="form-control" value="<?php echo date('Y-m-d'); ?>" name="StartDate" disabled></td>
            <td><span>Ngày kết thúc</span></td>
            <td><input style="width: 200px;" type="date" class="form-control" name="dueDate"></td>
        </tr>
        <tr>
            <td>
                <span>Tiêu đề</span>
            </td>
            <td colspan="3"><input type="text" class="form-control" style="width: 100%; margin: 5px 0" name="subject"></td>
        </tr>
        <tr>
            <td>
                <span>Ngày yêu cầu</span>
            </td>
            <td><input style="width: 200px; margin: 5px 0" type="date" class="form-control" name="DateTime0"></td>
        </tr>

        <tr>
            <td><span>Mức độ</span></td>
            <td><select class="form-select " style="width: 200px; margin: 5px 0" name="important">
                    <option value="0" selected>Normal</option>
                    <option value="1">low</option>
                    <option value="2">hight</option>
                </select>
            </td>
            <td><span>% Hoàn thành</span></td>
            <td>
                <div>
                    <input type="range" class="form-range" min="0" max="100" style="width: 200px;" step="10" value="0" name="COMPERCENT">
                    <div class="d-flex justify-content-between" style="width: 210px; ">
                        <span class="d-block">0</span>
                        <span class="d-block">20</span>
                        <span class="d-block">40</span>
                        <span class="d-block">60</span>
                        <span class="d-block">80</span>
                        <span class="d-block">100</span>
                    </div>
                </div>
            </td>
        </tr>
        <tr>
            <td><span>Màu chữ</span></td>
            <td><input style="width: 80px;  margin: 5px 0" type="color" class="form-control" name="color"></td>
        </tr>
        <tr>
            <td><span>Trạng thái</span></td>
            <td>
                <select class="form-select " style="width: 200px; margin: 5px 0" id="select-trangthai" name="trangthai">
                    <?php foreach ($readItsTrangthai as $tt): ?>
                        <option value="<?= $tt['ID_TRANGTHAI'] ?>" <?= $tt['ID_TRANGTHAI'] == 0 ? 'selected' : '' ?>>
                            <?= htmlspecialchars($tt['TEN_TRANGTHAI']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </td>
        </tr>
        <tr>
            <td><span>Tệp update</span></td>
            <td><input style="width: 200px;  margin: 5px 0" type="text" class="form-control"></td>
        </tr>
        <tr>
            <td colspan='4'>
                <div id="quill-editor" style="min-height:220px;"></div>
                <input type="hidden" name="editorContent" id="hidden-editor-content">

            </td>
        </tr>
        <tr>
            <td colspan='4'>
                <input type="submit" name="themLoiMoi" class="btn btn-primary mt-2" value="Thêm lỗi">
            </td>
        </tr>
    </table>
</form>

<?php

$obj = new DatabaseMSSQLPDO();

if (isset($_POST["themLoiMoi"])) {
    // Capture the POST data
    $ma_kh          = $_POST['MA_KH']        ?? '';
    $tt_bh          = $_POST['TT_BH']        ?? '';
    $subject        = $_POST['subject']      ?? '';
    $subjectGroup   = $_POST['subjectGroup'] ?? '';
    $start_date     = $_POST['StartDate']    ?? date('Y-m-d');
    $due_date       = $_POST['dueDate'];    
    $title          = $_POST['Title']        ?? '';
    $dateTime0      = $_POST['DateTime0']    ?? '';
    $important      = $_POST['important']    ?? '0';
    $compercent     = $_POST['COMPERCENT']   ?? 0;
    $color          = $_POST['color']        ?? '#000000';
    $status         = $_POST['trangthai']    ?? '';
    $content        = $_POST['editorContent'] ?? '';
    $ITS_REC_KH     = $_POST['ITS_REC_KH'] ?? '';
    $ITS_REC_VER    = $_POST['ITS_REC_VER'] ?? '';
    // $ckeditor_content = $content; // nếu cần gán riêng


    try {
        $sql = "INSERT INTO dbo.VLSTASKS (
            Subject, Content, User_id2, DateTime2, User_id0, DateTime0,
            StartDate, DueDate, Color, Important, Status, COMPERCENT,
            FormID, MenuID, Ext, FILEUPDATE, EditDate, SubjectGroup,
            CHILDRENT_YN, ITS_REC_KH, ITS_REC_VER
        ) VALUES (
            ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?
        )";
//              $subject, $content, 1, $dateTime2, 1, $dateTime0,
//              $start_date, $due_date, '-16777216', $important, $status, $compercent,
//              ' ', ' ', 0, ' ', $dateTime0, $subjectGroup,
//              ' ', $ITS_REC_VER, $ITS_REC_VER
        // echo $sql;
        // datetime2, itsRecKh, itsRecVer ??
        $stmt = $pdo->prepare($sql);
        $result = $stmt->execute([
            $subject, $content, 1, $dateTime2, 1, $dateTime0,
            $start_date, $due_date, '-16777216', $important, $status, $compercent,
            ' ', ' ', 0, ' ', $dateTime0, $subjectGroup,
            ' ', $itsRecKh, $itsRecVer
        ]);

        // if ($result) {
        //     echo '<script>alert("Thêm thành công"); window.location.href="index.php?page=baocao&bc=1";</script>';
        // } else {
        //     echo '<script>alert("Thêm thất bại"); window.location.href="index.php?page=baocao&bc=1";</script>';
        // }
    } catch (PDOException $e) {
        echo '<script>alert("Lỗi: ' . $e->getMessage() . '");</script>';
    }

}

?>


<script src="layout/js/editor.js"></script>

<script>
    $(document).ready(function() {
        let debounceTimer;

        function getTT_BH(ttbh) {
            switch (ttbh) {
                case '0':
                    return 'Đang Bảo Hành';
                case '1':
                    return 'Tạm ngừng BH';
                case '2':
                    return 'Ngừng BH';
                case '3':
                    return 'Đang Bảo trì';
                case '4':
                    return 'Tạm ngừng bảo trì';
                case '5':
                    return 'Ngừng bảo trì';
                default:
                    return 'Chưa cập nhật trạng thái';
            }
        }

        $('#maKH').on('input', function() {
            let val = $(this).val().toString().toUpperCase();
            $(this).val(val);

            clearTimeout(debounceTimer);
            var idkh = $(this).val();

            debounceTimer = setTimeout(() => {
                if (idkh.length > 0) {
                    $.ajax({
                        url: 'page/themloi/get-khachhang.php',
                        type: 'GET',
                        data: {
                            idkh: idkh
                        },
                        success: function(data) {
                            console.log('Kết quả trả về từ PHP:', data);

                            const $body = $('#kh-tbody');
                            $body.empty();
                            if (data.length > 0) {
                                $('#dskh').removeClass('d-none');
                                $('#dskh').addClass('d-block');
                                data.forEach((kh) => {
                                    const row = `
                                    <tr class="row-kh" data-id="${kh.MA_KH}">
                                        <td>
                                            <div class="limitLineCss">${kh.MA_KH}</div>
                                        </td>
                                        <td>
                                            <div class="limitLineCss" data-bs-toggle="tooltip" data-bs-placement="bottom" title="${kh.TEN_KH}">${kh.TEN_KH || ''}</div>
                                        </td>
                                        <td>
                                            <div class="limitLineCss" data-bs-toggle="tooltip" data-bs-placement="bottom" title="${getTT_BH(kh.BH[0]["TT_BHBT"])}">${getTT_BH(kh.BH[0]["TT_BHBT"])}</div>
                                        </td>
                                        <td>
                                            <div class="limitLineCss">${kh.BH[0]["NGAY_KT"] || ''}</div>
                                        </td>
                                        <td>
                                            <div class="limitLineCss">${kh.BH[0]["NGAY_BD"] || ''}</div>
                                        </td>
                                        <td>
                                            <div class="limitLineCss" data-bs-toggle="tooltip" data-bs-placement="bottom" title="${kh.DIA_CHI}">${kh.DIA_CHI || ''}</div>
                                        </td>
                                        <td>
                                            <div class="limitLineCss">${kh.MA_SO_THUE || ''}</div>
                                        </td>
                                        <td>
                                            <div class="limitLineCss">${kh.DIEN_THOAI || ''}</div>
                                        </td>
                                        <td>
                                            <div class="limitLineCss"></div>
                                        </td>
                                    </tr>
                                    `
                                    $body.append(row);

                                })
                                $('#kh-tbody').on('click', 'tr.row-kh', function() {
                                    const id = $(this).data('id');
                                    const kh = data.find(ttkh => String(ttkh.MA_KH) === String(id));
                                    if (!kh) return;

                                    console.log('Khách hàng đã click:', kh);

                                    $('#ITS_REC_KH').val(kh.ITS_REC_KH);
                                    $('#maKH').val(kh.MA_KH);
                                    $('#tenKH').html(kh.TEN_KH)
                                    $('#TT_KH').val(getTT_BH(kh.BH[0]["TT_BHBT"]));
                                    $('#maphienban').focus();
                                    $('#dskh').addClass('d-none');
                                });
                            } else {
                                $('#dskh').removeClass('d-none');
                                $('#dskh').addClass('d-block');
                                $row = `<tr>
                                    <td>abc</td>
                                    <td>abc</td>
                                    <td>abc</td>
                                    <td>abc</td>
                                    <td>abc</td>
                                    <td>abc</td>
                                    <td>abc</td>
                                    <td>abc</td>
                                    <td>abc</td>
                                </tr>`;
                                $body.append(row);
                            }
                        },
                        error: function(xhr, status, err) {
                            console.error('AJAX ERROR ->',
                                'status:', xhr.status,
                                'statusText:', xhr.statusText,
                                'responseText:', xhr.responseText
                            );
                        }
                    });
                }
            }, 1000)
        });
        $('#maphienban').on('input', function() {
            let val = $(this).val().toString().toUpperCase();
            $(this).val(val);

            clearTimeout(debounceTimer);
            var maphienban = $(this).val();

            debounceTimer = setTimeout(() => {
                if (maphienban.length > 0) {
                    $.ajax({
                        url: 'page/themloi/get-phienban.php',
                        type: 'GET',
                        data: {
                            phienban: maphienban
                        },
                        success: function(data) {
                            console.log('Kết quả trả về từ PHP:', data);

                            const $body = $('#pb-tbody');
                            $body.empty();
                            if (data.length > 0) {
                                $('#dspb').removeClass('d-none');
                                $('#dspb').addClass('d-block');
                                data.forEach((pb) => {
                                    const row = `
                                    <tr class="row-pb" data-id="${pb.MA_VER}">
                                        <td>
                                            <div class="limitLineCss">${pb.MA_VER}</div>
                                        </td>
                                        <td>
                                            <div class="limitLineCss">${pb.TEN_VER}</div>
                                        </td>
                                        
                                    </tr>
                                    `
                                    $body.append(row);

                                })
                                $('#pb-tbody').on('click', 'tr.row-pb', function() {
                                    const id = $(this).data('id');
                                    const pb = data.find(ttpb => String(ttpb.MA_VER) === String(id));
                                    if (!pb) return;

                                    console.log('Khách hàng đã click:', pb);

                                    $('#ITS_REC_VER').val(pb.ITS_REC_VER);
                                    $('#maphienban').val(pb.MA_VER);
                                    $('#tenphienban').html(pb.TEN_VER)

                                    $('#dspb').addClass('d-none');
                                });
                            } else {
                                $('#dspb').removeClass('d-none');
                                $('#dspb').addClass('d-block');
                                $row = `<tr>
                                    <td>abc</td>
                                    <td>abc</td>
                                </tr>`;
                                $body.append(row);
                            }
                        },
                        error: function(xhr, status, err) {
                            console.error('AJAX ERROR ->',
                                'status:', xhr.status,
                                'statusText:', xhr.statusText,
                                'responseText:', xhr.responseText
                            );
                        }
                    });
                }
            }, 1000)
        });

        $(document).on('mousedown touchstart', function(e) {
            if (!$(e.target).closest('#dskhGroup').length) {
                $('#dskh').addClass('d-none');
            }
        });
        $(document).on('mousedown touchstart', function(e) {
            if (!$(e.target).closest('#dspbGroup').length) {
                $('#dspb').addClass('d-none');
            }
        });


        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    });
</script>


<script>
    const selectTrangthai = document.getElementById('select-trangthai');
    const inputRange = document.querySelector('input[type="range"]');

    selectTrangthai.addEventListener('change', function() {
        const val = parseInt(this.value);
        if (val === 0 || val === 1) {
            inputRange.value = 0;
        } else {
            inputRange.value = 100;
        }
    });
</script>