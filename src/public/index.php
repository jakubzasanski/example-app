<?php

if (str_contains($_SERVER['REQUEST_URI'], '/api/')) {
    require "../api.php";
} else {
    echo 'Everything works fine!';
}
