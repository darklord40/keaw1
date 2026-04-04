<?php
$year = 2550;
$url = "http://127.0.0.1:8000/predict?year=" . $year;

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);
curl_close($ch);

$data = json_decode($response, true);

echo "Prediction: " . $data["prediction"];
?>