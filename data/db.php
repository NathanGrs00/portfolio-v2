<?php
// Loads Supabase settings and provides a helper for calling the Supabase REST API (PostgREST)
// instead of connecting directly to a database.
define('BASE_URL', '/portfolio-v2/public');

$env = parse_ini_file(__DIR__ . '/../.env');

define('SUPABASE_URL', rtrim($env['SUPABASE_URL'], '/'));
define('SUPABASE_KEY', $env['SUPABASE_KEY']);

/**
 * Makes a request to the Supabase REST API (PostgREST).
 *
 * @param string     $endpoint e.g. "projects?select=*&order=id.asc"
 * @param string     $method   GET, POST, PATCH, DELETE
 * @param array|null $data     body for POST/PATCH requests
 * @return array                decoded JSON response
 */
function supabaseRequest($endpoint, $method = 'GET', $data = null)
{
    $ch = curl_init(SUPABASE_URL . '/rest/v1/' . $endpoint);

    $headers = [
        'apikey: ' . SUPABASE_KEY,
        'Authorization: Bearer ' . SUPABASE_KEY,
        'Content-Type: application/json',
    ];

    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CUSTOMREQUEST  => $method,
        CURLOPT_HTTPHEADER     => $headers,
        CURLOPT_TIMEOUT        => 10,
    ]);

    if ($data !== null) {
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    }

    $response = curl_exec($ch);


    if ($response === false) {
        $error = curl_error($ch);
        curl_close($ch);
        error_log("Supabase request failed: $error");
        return array();
    }

    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpCode >= 400) {
        error_log("Supabase error ($httpCode): $response");
        return array();
    }

    $decoded = json_decode($response, true);

    if ($decoded === null) {
        return array();
    }

    return $decoded;
}