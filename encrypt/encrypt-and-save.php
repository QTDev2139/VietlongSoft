<?php
// encrypt-and-save.php
error_reporting(E_ALL); ini_set('display_errors', 1);

function loadKey(): string {
  // Ưu tiên lấy từ biến môi trường SODIUM_KEY (base64)
  if ($k = getenv('SODIUM_KEY')) return base64_decode($k, true);
  // Hoặc đọc file .sodium.key (base64), chmod 600, KHÔNG commit
  $file = './.sodium.key';
  if (is_file($file)) return base64_decode(trim(file_get_contents($file)), true);
  die("Không tìm thấy khóa: export SODIUM_KEY hoặc tạo .sodium.key");
}

function enc(string $plain, string $key, string $aad='db-conn-v1'): array {
  $nonce = random_bytes(SODIUM_CRYPTO_AEAD_XCHACHA20POLY1305_IETF_NPUBBYTES);
  $ct    = sodium_crypto_aead_xchacha20poly1305_ietf_encrypt($plain, $aad, $nonce, $key);
  return ['nonce'=>base64_encode($nonce), 'cipher'=>base64_encode($ct)];
}

function upsertEnv(string $envPath, array $pairs): void {
  $lines = file_exists($envPath) ? file($envPath, FILE_IGNORE_NEW_LINES) : [];
  $map = [];
  foreach ($lines as $line) {
    if ($line==='' || str_starts_with(ltrim($line),'#') || !str_contains($line,'=')) continue;
    [$k,$v] = explode('=', $line, 2);
    $map[trim($k)] = $v;
  }
  foreach ($pairs as $k=>$v) { $map[$k] = $v; }

  // Backup cũ
  // if (file_exists($envPath)) { @copy($envPath, 'bak-env/'.$envPath.'.bak-'.date('Ymd-His')); }

  $out = '';
  foreach ($map as $k=>$v) { $out .= $k.'='.$v.PHP_EOL; }
  file_put_contents($envPath, $out, LOCK_EX);
  @chmod($envPath, 0600);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $server = trim($_POST['DB_SERVER'] ?? '');
  $name   = trim($_POST['DB_NAME']   ?? '');
  $user   = trim($_POST['DB_USER']   ?? '');
  $pass   = (string)($_POST['DB_PASS'] ?? '');

  if ($server===''||$name===''||$user===''||$pass==='') { die("Thiếu dữ liệu"); }

  $key = loadKey();
  $aad = 'db-conn-v1';

  $eServer = enc($server, $key, $aad);
  $eName   = enc($name,   $key, $aad);
  $eUser   = enc($user,   $key, $aad);
  $ePass   = enc($pass,   $key, $aad);

  // Lưu vào .env theo định dạng ENC_XCHACHA(nonce:cipher)
  $pairs = [
    'DB_SERVER' => 'ENC_XCHACHA(' . $eServer['nonce'] . ':' . $eServer['cipher'] . ')',
    'DB_NAME'   => 'ENC_XCHACHA(' . $eName['nonce']   . ':' . $eName['cipher']   . ')',
    'DB_USER'   => 'ENC_XCHACHA(' . $eUser['nonce']   . ':' . $eUser['cipher']   . ')',
    'DB_PASS'   => 'ENC_XCHACHA(' . $ePass['nonce']   . ':' . $ePass['cipher']   . ')',
  ];
  upsertEnv('../.env', $pairs);

  echo "<pre>Đã mã hóa và lưu vào .env\n";
  print_r($pairs);
  echo "</pre>";
  header('Location: /report/index.php?page=quanlyloi');
  exit;
}
?>
<!-- Form nhập -->
<form method="post" style="max-width:200px; border: 1px solid #333; margin: auto; padding: 20px; border-radius: 5px">
  <label>DB_SERVER</label><br><input name="DB_SERVER" required><br><br>
  <label>DB_NAME</label><br><input name="DB_NAME" required><br><br>
  <label>DB_USER</label><br><input name="DB_USER" required><br><br>
  <label>DB_PASS</label><br><input name="DB_PASS" type="password" required><br><br>
  <button type="submit">Kết nối</button>
</form>
