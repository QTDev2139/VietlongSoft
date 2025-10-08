<?php
$key = sodium_crypto_aead_xchacha20poly1305_ietf_keygen(); // 32 bytes
file_put_contents('./.sodium.key', base64_encode($key)); // chỉ 1 dòng base64

echo "Saved .sodium.key (base64)\n";
header('Location: encrypt-and-save.php');
