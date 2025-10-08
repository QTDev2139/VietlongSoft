<?php
// crypto_env.php
if (!extension_loaded('sodium')) { throw new RuntimeException("Cần bật sodium"); }

function crypto_load_key(): string {
  if ($k = getenv('SODIUM_KEY')) return base64_decode($k, true);
  $file = __DIR__.'/.sodium.key';
  if (is_file($file)) return base64_decode(trim(file_get_contents($file)), true);
  throw new RuntimeException("Không tìm thấy khóa (SODIUM_KEY hoặc .sodium.key)");
}

function crypto_decrypt_env_value(string $value, string $aad='db-conn-v1'): string {
  // Nếu không có prefix ENC_XCHACHA(...), trả nguyên văn (cho phép mix plain+enc)
  if (!preg_match('/^ENC_XCHACHA\(([^:]+):([^)]+)\)$/', trim($value), $m)) {
    return $value;
  }
  $key   = crypto_load_key();
  $nonce = base64_decode($m[1], true);
  $ct    = base64_decode($m[2], true);

  $pt = sodium_crypto_aead_xchacha20poly1305_ietf_decrypt($ct, $aad, $nonce, $key);
  if ($pt === false) throw new RuntimeException("Giải mã thất bại: sai key/nonce/AAD hoặc dữ liệu bị sửa");
  return $pt;
}
