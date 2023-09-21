<?php
$ch = curl_init();

$url = "https://api-login-php.davidebalice.dev/products/api/login";

$data = json_encode(array(
    'username' => 'thomas.anderson',
    'password' => '12345678'
));


curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

$response = curl_exec($ch);

$result = json_decode($response, true);

echo $response."<br /><br />";

$token = $result['token'];

curl_close($ch);




$apiUrl = 'https://api-login-php.davidebalice.dev/products/api/products';

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $apiUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer ' . $token));

$response = curl_exec($ch);

if (curl_errno($ch)) {
    echo 'Errore durante la richiesta API: ' . curl_error($ch);
}

curl_close($ch);

echo $response;

$data = json_decode($response, true);


echo json_encode($data, JSON_PRETTY_PRINT);
?>
