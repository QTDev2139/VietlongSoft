<?php
header('Content-Type: application/json; charset=utf-8');
include_once("../../class/clsdatabase.php");

if (!isset($_GET['idkh']) || $_GET['idkh'] === '') {
    echo json_encode(['error' => 'Thiếu mã khách']);
    exit;
}

$idkh = $_GET['idkh'];

try {
    $obj = new DatabaseMSSQLPDO();

    $sql = "SELECT ITS_REC_KH, MA_KH, TEN_KH, DATETIME0, DATETIME2, DIA_CHI, MA_SO_THUE, DIEN_THOAI
            FROM dbo.ITSKH
            WHERE LTRIM(RTRIM(MA_KH)) LIKE ?";
    $param = ['%' . $idkh . '%'];
    $dskh = $obj->xuatdulieu($sql, $param);

    $its_dskh = array_column($dskh, 'ITS_REC_KH');
    if (empty($its_dskh)) {
        echo json_encode([]);
        exit;
    }

    $quoted = array_map(function ($val) {
        return "'" . $val . "'";
    }, $its_dskh);
    $its_dskhToString = implode(',', $quoted);

    $dskhbh = $obj->xuatdulieu("
        SELECT ITS_REC_KH, NGAY_BD, NGAY_KT, TT_BHBT, DATETIME0, DATETIME2, STATUS, USER_ID2 
        FROM dbo.ITSCNBHBT 
        WHERE ITS_REC_KH IN ($its_dskhToString)
    ");

    // Map BH theo ITS_REC_KH
    $mapBH = [];
    foreach ($dskhbh as $bh) {
        $key = (string) $bh['ITS_REC_KH'];
        $mapBH[$key][] = [
            'NGAY_BD' => $bh['NGAY_BD'],
            'NGAY_KT' => $bh['NGAY_KT'],
            'TT_BHBT'   => $bh['TT_BHBT'],
            'DATETIME0' => $bh['DATETIME0'],
            'DATETIME2' => $bh['DATETIME2'],
            'STATUS'    => $bh['STATUS'],
        ];
    }

    // Gộp  KH và BH
    $result = [];
    foreach ($dskh as $kh) {
        $key = (string) $kh['ITS_REC_KH'];
        $result[] = [
            'MA_KH'      => $kh['MA_KH'],
            'TEN_KH'     => $kh['TEN_KH'],
            'DIA_CHI'    => $kh['DIA_CHI'],
            'MA_SO_THUE' => $kh['MA_SO_THUE'],
            'DIEN_THOAI' => $kh['DIEN_THOAI'],
            'DATETIME0'  => $kh['DATETIME0'],
            'DATETIME2'  => $kh['DATETIME2'],
            'BH'         => $mapBH[$key] ?? [] // Lấy danh sách bảo hiểm liên quan
        ];
    }

    echo json_encode($result, JSON_UNESCAPED_UNICODE);
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Server error']);
}
