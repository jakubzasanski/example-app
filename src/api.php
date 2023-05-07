<?php

$path = explode('/', parse_url($_SERVER['REQUEST_URI'])['path'], 4);
if (is_array($path)) {
    $path = array_filter($path, function ($element) {
        return !empty($element);
    });

    if (!empty($path) && count($path) === 2 && file_exists('../api/' . basename($path[2]) . '.php')) {
        require '../api/' . basename($path[2]) . '.php';
    } else {
        header('Location: ' . 'http://' . $_SERVER['HTTP_HOST'], true, 301);
    }
}
