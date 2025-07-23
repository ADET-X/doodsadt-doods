<?php
// API Key DoodStream
$apiKey = "156828ewsv8ijt78ja815s";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file'])) {
    $file = $_FILES['file']['tmp_name'];

    // Ambil server upload dari DoodStream
    $serverUrl = "https://doodapi.co/api/upload/server?key={$apiKey}";
    $serverData = json_decode(file_get_contents($serverUrl), true);

    if (!$serverData || !isset($serverData['result'])) {
        echo json_encode(["error" => "Gagal mengambil server upload"]);
        exit;
    }

    $uploadUrl = $serverData['result'];

    // Kirim file ke server DoodStream via cURL
    $cfile = new CURLFile($file, $_FILES['file']['type'], $_FILES['file']['name']);
    $postFields = [
        'api_key' => $apiKey,
        'file' => $cfile
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $uploadUrl);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);

    echo $response; // Hasil langsung dikirim ke JS
} else {
    echo json_encode(["error" => "Tidak ada file diupload"]);
}
?>