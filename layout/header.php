<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <base href="http://localhost/report/">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="layout/css/styles.css?t=1">
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <script src="bootstrap/js/jquery-3.7.1.min.js"></script>
    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="bootstrap/js/jquery-ui.min.js"></script>

    <link rel="stylesheet" href="editor/quill.snow.css" />
    <script src="editor/quill.min.js"></script>


    <title>Document</title>
    <style>
        .modal-dialog {
            cursor: move;
        }
    </style>

</head>

<body>
    <?php
    $obj = new DatabaseMSSQLPDO();

    $sql = "SELECT * FROM [dbo].[VLSMENUTEXT2] ORDER BY MenuID ASC";
    $data = $obj->xuatdulieu($sql);

    function getMenu($menu)
    {
        return match ($menu) {
            2 => 'quanlyloi',
            3 => 'capnhatthongtin',
            4 => 'xemtrangthaikh',
            5 => 'danhmucphienban',
            6 => 'danhmuckhachhang',
            default => 'error',
        };
    }

    $currentPage = $_GET['page']
    ?>
    <header style="padding: 0;">
        <h4 style=" text-align: center;">
            <a href="index.php?page=baocao" class="nav-link" style="color: #0f9cc7 !important;">
                Công ty cổ phần mềm Việt Long
            </a>
        </h4>
        <ul class="nav nav-tabs small mb-3 ps-3 container-fluid">
            <?php for ($i = 2; $i < count($data); $i++): ?>
                <?php $activePage = $currentPage === getMenu($i) ? 'active' : '' ?>
                <li class="nav-item">
                    <a href='index.php?page=<?= getMenu($i) ?>' class="nav-link <?= $activePage ?>">
                        <?= htmlspecialchars($data[$i]['Text']) ?>
                    </a>
                </li>
            <?php endfor; ?>
        </ul>
    </header>