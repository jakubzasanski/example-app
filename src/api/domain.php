<?php

// Załadowanie klasy do komunikacji z redis
require '../RedisDomainAPI.php';

// Utworzenie instancji Redis Domain API
$domainAPI = new RedisDomainAPI();

function handlePostRequest(object &$domainAPI, array &$response): void
{
    $data = json_decode(file_get_contents("php://input"), true);

    if (!empty($data) && is_array($data) && count($data) > 10) {
        $response['code'] = 413;
        $response['body'] = [
            'error' => 'content_too_large'
        ];

        $data = array_slice($data, 0, 10);
    }

    if (!$data || !isset($data['domain'])) {
        $response['code'] = 400;
        $response['body'] = [
            'error' => 'invalid_data'
        ];

        return;
    }

    if ($domainAPI->addDomain($data)) {
        $response['code'] = 200;
        $response['body'] = [
            'success' => true
        ];
    }
}

function handleGetRequest(object &$domainAPI, array &$response): void
{
    $domain = $_GET['domain'] ?? null;

    $response['body'] = $domainAPI->getDomain($domain);
}

function handleDeleteRequest(object &$domainAPI, array &$response): void
{
    $data = json_decode(file_get_contents("php://input"), true);

    if (!empty($data) && is_array($data) && count($data) > 1) {
        $response['code'] = 413;
        $response['body'] = [
            'error' => 'content_too_large'
        ];

        return;
    }

    if (!isset($data['domain'])) {
        $response['code'] = 400;
        $response['body'] = [
            'error' => 'invalid_data'
        ];

        return;
    }

    if ($domainAPI->deleteDomain($data['domain'])) {
        $response['code'] = 200;
        $response['body'] = [
            'success' => true
        ];
    }
}

// #########################################################################

$response = [
    'header' => 'Content-Type: application/json',
    'code' => 200,
    'body' => []
];

switch ($_SERVER['REQUEST_METHOD']) {
    case 'POST':
        handlePostRequest($domainAPI, $response);
        break;

    case 'GET':
        handleGetRequest($domainAPI, $response);
        break;

    case 'DELETE':
        handleDeleteRequest($domainAPI, $response);
        break;

    default:
        $response['code'] = 405;
        $response['header'] = $response['header'] . '; Allow: POST, GET, DELETE';

}

header($response['header']);
http_response_code($response['code']);
echo json_encode($response['body']);
