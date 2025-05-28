<?php
// ملف server.php لتشغيل سيرفر PHP مدمج مع Laravel

$uri = urldecode(
    parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)
);

// تحقق هل الملف المطلوب موجود في مجلد public (مثل css, js, صور)
// إذا موجود، اترك PHP يخدم الملف مباشرة
if ($uri !== '/' && file_exists(__DIR__ . '/public' . $uri)) {
    return false;
}

// إذا الملف غير موجود، وجه الطلب إلى index.php داخل public ليتم معالجته من Laravel
require_once __DIR__ . '/public/index.php';
