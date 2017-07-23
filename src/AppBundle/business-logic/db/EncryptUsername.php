<?
$encryptedUsername = openssl_encrypt(
    $username,
    'RC4-40',
    'regularUserPassword'
);
?>