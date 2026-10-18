<?php
// Set correct OpenSSL config path
putenv("OPENSSL_CONF=D:/xampp/apache/conf/openssl.cnf");


$config = [
    "private_key_bits" => 2048,
    "private_key_type" => OPENSSL_KEYTYPE_RSA,
];

$privateKey = openssl_pkey_new($config);

if ($privateKey === false) {
    echo "Key generation failed. OpenSSL error: " . openssl_error_string();
    exit;
}

openssl_pkey_export($privateKey, $privatePEM);
$publicPEM = openssl_pkey_get_details($privateKey)['key'];

file_put_contents(__DIR__ . '/rsa_private.pem', $privatePEM);
file_put_contents(__DIR__ . '/rsa_public.pem', $publicPEM);

echo "RSA keys generated successfully.";
