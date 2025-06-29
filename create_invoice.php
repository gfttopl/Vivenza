<?php
header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

$nick = $data['nick'] ?? '';
$productName = $data['product'] ?? 'Товар';
$amount = $data['amount'] ?? 0;

if (strlen($nick) < 5 || $amount < 100) {
  http_response_code(400);
  echo json_encode(['error' => 'Invalid input']);
  exit;
}

$token = 'mLyajY13hup79e3Y91MaN9g'; // <- Заміни на свій X-Token з кабінету Monobank

$payload = [
  "amount" => $amount,
  "ccy" => 980,
  "merchantPaymInfo" => [
    "reference" => uniqid(),
    "destination" => $productName,
    "comment" => "Telegram: $nick"
  ]
];

$ch = curl_init("https://api.monobank.ua/api/merchant/invoice/create");
curl_setopt_array($ch, [
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_HTTPHEADER => [
    'Content-Type: application/json',
    'X-Token: ' . $token
  ],
  CURLOPT_POST => true,
  CURLOPT_POSTFIELDS => json_encode($payload)
]);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

http_response_code($httpCode);
echo $response;
