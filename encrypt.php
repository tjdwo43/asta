<?

$secret_key = "ehatm!@#";
$secret_iv = "#@$%^&*()_+=-";

$pw = $_REQUEST[passwd];

$str = base64_decode($pw);

$key = hash('sha256', $secret_key);
$iv = substr(hash('sha256', $secret_iv), 0, 32);

echo str_replace("=", "", base64_encode(
        openssl_encrypt($str, "AES-256-CBC", $key, 0, $iv))
);

?>