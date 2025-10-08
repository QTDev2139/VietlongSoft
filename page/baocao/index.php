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
?>

<?php if ($data): ?>
  <div class="btn p-0"
    type="button"
    data-bs-toggle="collapse"
    data-bs-target="#menuCollapse"
    aria-expanded="false"
    aria-controls="menuCollapse">
    <?= htmlspecialchars($data[1]['Text']) ?>
  </div>

  <div class="collapse mt-2" id="menuCollapse">
    <ul class="ps-0">
      <?php for ($i = 2; $i < count($data); $i++): ?>
        <li><a href='index.php?page=<?= getMenu($i) ?>' class="nav-link">
            <?= htmlspecialchars($data[$i]['Text']) ?>
          </a></li>
      <?php endfor; ?>
    </ul>
  </div>
<?php else: ?>
  <div>Không có dữ liệu</div>
<?php endif; ?>