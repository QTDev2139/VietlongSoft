<?php
header('Content-Type: application/json; charset=utf-8');
include_once("../../class/clsdatabase.php");

if (!isset($_GET['phienban']) || $_GET['phienban'] === '') {
    echo json_encode(['error' => 'Thiếu mã khách']);
    exit;
}

$phienban = $_GET['phienban'];

try {
    $obj = new DatabaseMSSQLPDO();

    $sql = "SELECT ITS_REC_VER, MA_VER, TEN_VER FROM dbo.ITSVER

            WHERE LTRIM(RTRIM(MA_VER)) LIKE ?";
    $param = ['%' . $phienban . '%'];
    $dspb = $obj->xuatdulieu($sql, $param);

    echo json_encode($dspb, JSON_UNESCAPED_UNICODE);
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Server error']);
}
