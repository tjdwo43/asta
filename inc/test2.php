<?
	$secret_key = "ehatm!@#";          //돔스!@#
	$secret_iv = "#@$%^&*()_+=-";

	$pw = $_GET["passwd"];

	$str = base64_decode($str);

	$key = hash('sha256', $secret_key);
	$iv = substr(hash('sha256', $secret_iv), 0, 32);

	echo str_replace("=", "", base64_encode(
				 openssl_encrypt($str, "AES-256-CBC", $key, 0, $iv))
    );
?>