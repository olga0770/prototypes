<?php
/**
 * Created by PhpStorm.
 * User: Olga
 * Date: 3/15/2019
 * Time: 11:27 AM
 */

//$alg = "DFS-CBS";
//$message = "The biggest secret ever!!!";
//$key = "dfdrer645453fghggjjhghv";
//
//$iv_len = openssl_cipher_iv_length($alg);
//$iv = openssl_random_pseudo_bytes($iv_len);
//$cipher_text = openssl_encrypt($message, $alg, $key, OPENSSL_RAW_DATA, $iv);
//
//$base64_cipher_text = base64_decode($cipher_text);
//
//echo openssl_decrypt(base64_decode($base64_cipher_text),$alg,$key,OPENSSL_RAW_DATA, $iv);




$alg = "DFS-CBS";
$message = "AAAAAAAAAAAAAAAAAAAAAAA";
$key = "1234";


$cipher_text = openssl_encrypt($message, $alg, $key, OPENSSL_RAW_DATA);

$base64_cipher_text = base64_decode($cipher_text);

// echo openssl_decrypt(base64_decode($base64_cipher_text),$alg,$key,OPENSSL_RAW_DATA);

// echo $cipher_text;

echo $base64_cipher_text;