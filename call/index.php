<?php
$ch = curl_init();

$url = "http://tuo_sito.com/api/login.php"; // Sostituisci con l'URL effettivo del tuo server

$data = array(
    'username' => 'utente',
    'password' => 'password'
);

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

$response = curl_exec($ch);

$result = json_decode($response, true);

$token = $result['token'];

curl_close($ch);


/////////////////////////////////////////////////////



$apiUrl = 'http://tuo_indirizzo_api/api/products';
$token = 'il_tuo_token_jwt';

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $apiUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer ' . $token));

$response = curl_exec($ch);

if (curl_errno($ch)) {
    echo 'Errore durante la richiesta API: ' . curl_error($ch);
}

curl_close($ch);

// La risposta contiene i dati ottenuti dalla richiesta API
$data = json_decode($response, true);

// Esempio: stampa i dati ottenuti
print_r($data);
?>
