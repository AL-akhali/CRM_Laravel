<?php

if (php_sapi_name() === 'cli-server') {
    $url = parse_url($_SERVER['REQUEST_URI']);
    $file = __DIR__ . $url['path'];

    // إذا الملف موجود (css, js, صورة...)، خليه يخدم الملف مباشرة
    if (is_file($file)) {
        return false;
    }
}

// غير ذلك، خذ كل الطلبات وحولها لـ index.php
require_once __DIR__ . '/index.php';
