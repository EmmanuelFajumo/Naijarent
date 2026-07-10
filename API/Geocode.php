<?php
    include_once '../Process_pages/classes/config.php';

    
function geocodeAddress($address) {
    $apiKey = MAP_API_KEY;
    $url    = "https://maps.googleapis.com/maps/api/geocode/json?"
            . "address=" . urlencode($address)
            . "&key=" . $apiKey
            . "&region=NG"; // bias results to Nigeria

    $response = file_get_contents($url);
    $data     = json_decode($response, true);

    if ($data['status'] === 'OK') {
        $location = $data['results'][0]['geometry']['location'];
        return [
            'lat'           => $location['lat'],
            'lng'           => $location['lng'],
            'formatted_address' => $data['results'][0]['formatted_address']
        ];
    }

    return null; // address not found
}



$address = "1, Adeola Adeoye Street, Toyin Street, Ikeja, Lagos State";
$coords = geocodeAddress($address);

if ($coords) {
    echo "Latitude: " . $coords['lat'] . "\n";
    echo "Longitude: " . $coords['lng'] . "\n";
    echo "Formatted: " . $coords['formatted_address'] . "\n";
} else {
    echo "Address not found.";
}
