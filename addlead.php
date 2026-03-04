

<?php





$data = [
    "firstName" => $_POST['firstName'] ?? '',
    "lastName" => $_POST['lastName'] ?? '',
    "phone" => $_POST['phone'] ?? '',
    "email" => $_POST['email'] ?? '',
    "countryCode" => "GB",
    "box_id" => 28,
    "offer_id" => 5,
    "landingUrl" => (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http")
                . "://".$_SERVER['HTTP_HOST'],
    "ip" => $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1',
    "password" => "qwerty12",
    "language" => "en",
    "clickId"     => "",       
    "quizAnswers" => "",       
    "custom1"     => "",        
    "custom2"     => "",        
    "custom3"     => ""        
];


$ch = curl_init("https://crm.belmar.pro/api/v1/addlead");

curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Content-Type: application/json",
    "token: ba67df6a-a17c-476f-8e95-bcdb75ed3958"
]);

curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));


// curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
// curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);


$response = curl_exec($ch);
if ($response === false) {
    die("Curl error: " . curl_error($ch));
}
curl_close($ch);


$result = json_decode($response, true);


if (isset($result['status'])) {
    $result['status'] = (bool)$result['status'];
}


header('Content-Type: application/json; charset=utf-8');
echo json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);