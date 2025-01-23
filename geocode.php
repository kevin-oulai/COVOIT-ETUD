<?php
// OpenCage API key
$apiKey = '2ec2e982f7ce4c70b7731202ddbcc659';

// Return the latitude and longitude
function geocodeAddress($address, $apiKey) {
    $url = "https://api.opencagedata.com/geocode/v1/json?q=" . urlencode($address) . "&key=$apiKey";

    // Fetch JSON response
    $response = file_get_contents($url);
    $data = json_decode($response, true);

    // Check if a valid
    if (isset($data['results'][0])) {
        return [
            'lat' => $data['results'][0]['geometry']['lat'],
            'lng' => $data['results'][0]['geometry']['lng'],
            'address' => $data['results'][0]['formatted']
        ];
    }
    return null;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $lieuDepart = $_POST['lieuDepart'];
    $lieuArrivee = $_POST['lieuArrivee'];

    // Geocode
    $location1 = geocodeAddress($lieuDepart, $apiKey);
    $location2 = geocodeAddress($lieuArrivee, $apiKey);

    // Prepare the response
    if ($location1 && $location2) {
        $response = [
            'status' => 'success',
            'location1' => $location1,
            'location2' => $location2
        ];
    } else {
        $response = [
            'status' => 'error',
            'message' => 'One or both addresses could not be geocoded.'
        ];
    }

    // Send
    echo json_encode($response);
}