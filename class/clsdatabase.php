<?php


class DatabaseMSSQLPDO
{
    private PDO $pdo;

    public function __construct()
    {
        // Xác định đường dẫn tuyệt đối tới file
        $file = __DIR__ . '/../encrypt/crypto_env.php';

        // Kiểm tra file có tồn tại không
        if (file_exists($file)) {
            include_once($file);
        } else {
            echo "Không tìm thấy file: $file";
            exit;
        }



        $envPath = __DIR__ . '/../.env';

        // Đọc file .env (giử nguyên value kể cả có kí tự lạ)
        $env = parse_ini_file($envPath, false, INI_SCANNER_RAW) ?: [];

        $aad = 'db-conn-v1';
        $server = crypto_decrypt_env_value($env['DB_SERVER'] ?? '', $aad);
        $db   = crypto_decrypt_env_value($env['DB_NAME']   ?? '', $aad);
        $user   = crypto_decrypt_env_value($env['DB_USER']   ?? '', $aad);
        $pass   = crypto_decrypt_env_value($env['DB_PASS']   ?? '', $aad);

        $dsn = "sqlsrv:Server=$server;Database=$db;TrustServerCertificate=1";

        try {
            $this->pdo = new PDO($dsn, $user, $pass, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::SQLSRV_ATTR_ENCODING => PDO::SQLSRV_ENCODING_UTF8,
            ]);
        } catch (PDOException $e) {
            die("Kết nối thất bại: " . $e->getMessage());
        }
    }

    public function xuatdulieu($sql, array $params = [])
    {
        $stm = $this->pdo->prepare($sql);
        $stm->execute($params);
        return $stm->fetchAll() ?: [];
    }

    public function themxoasua($sql, array $params = [])
    {
        $stm = $this->pdo->prepare($sql);
        $stm->execute($params);
        return $stm->rowCount();
    }
}
