<?php
function layDanhSachKH(): array
{
    $obj = new DatabaseMSSQLPDO();
    $getItsKH = 'SELECT ITS_REC_KH, MA_KH, TEN_KH, DIA_CHI, MA_SO_THUE, DIEN_THOAI FROM dbo.ITSKH';
    $getItsCNBHBT = 'SELECT ITS_REC_KH, NGAY_BD, NGAY_KT, GT_BH, TT_BHBT, DATETIME0, DATETIME2, USER_ID0, USER_ID2, STATUS  FROM ITSCNBHBT';

    $readItsKH      = $obj->xuatdulieu($getItsKH);
    $readItsCNBHBT    = $obj->xuatdulieu($getItsCNBHBT);

    $ItsKHMap = [];
    foreach ($readItsKH as $ItsKH) {
        $key = (string)$ItsKH['ITS_REC_KH'];

        $ItsKHMap[$key] = [
            'MA_KH'    => $ItsKH['MA_KH'],
            'TEN_KH'   => $ItsKH['TEN_KH'],
            'DIA_CHI'  => $ItsKH['DIA_CHI'],

        ];
    }


    $data = [];
    foreach ($readItsCNBHBT as $t) {
        $key = (string)$t['ITS_REC_KH'];
        $kh = $ItsKHMap[$key] ?? ['MA_KH' => '', 'TEN_KH' => '', 'DIA_CHI' => ''];

        $data[] = [
            'MA_KH'       => $kh['MA_KH'] ?? '',
            'TEN_KH'      => $kh['TEN_KH'] ?? '',
            'NGAY_BD'     => !empty($t['NGAY_BD']) ? date('d/m/Y', strtotime($t['NGAY_BD'])) : '',
            'NGAY_KT'     => !empty($t['NGAY_KT']) ? date('d/m/Y', strtotime($t['NGAY_KT'])) : '',
            'TT_BH'       => $t['TT_BHBT'] ?? '',
            'TT'          => $t['STATUS'],
            'GT_BH'       => $t['GT_BH'],
            'DIA_CHI'     => $kh['DIA_CHI'] ?? '',
            'MA_SO_THUE'     => $kh['MA_SO_THUE'] ?? '',
            'DIEN_THOAI'     => $kh['DIEN_THOAI'] ?? '',
            'USER_ID0'    => $t['USER_ID0'],
            'DATETIME0'   => !empty($t['DATETIME0']) ? date('d/m/Y H:i:s', strtotime($t['DATETIME0'])) : '',
            'USER_ID2'    => $t['USER_ID2'],
            'DATETIME2'   => !empty($t['DATETIME2']) ? date('d/m/Y H:i:s', strtotime($t['DATETIME2'])) : '',

        ];
    }

    return $data;
}
