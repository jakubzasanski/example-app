<?php

require '../RedisDomainAPI.php';

$domainAPI = new RedisDomainAPI();

function handlePostRequest(object &$domainAPI, array &$response): void
{
    $data = json_decode(file_get_contents("php://input"), true);

    if (!empty($data) && is_array($data) && count($data) > 1) {
        $response['code'] = 413;
        $response['body'] = [
            'error' => 'content_too_large'
        ];

        return;
    }

    if (empty($data['domain'])) {
        $response['code'] = 400;
        $response['body'] = [
            'error' => 'invalid_data'
        ];

        return;
    }

    if ($domainAPI->reportError($data['domain'])) {
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

    default:
        $response['code'] = 405;
        $response['header'] = $response['header'] . '; Allow: POST';
}

header($response['header']);
http_response_code($response['code']);
echo json_encode($response['body']);
