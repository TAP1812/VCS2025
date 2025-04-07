<?php

function isSafeUrl($url) {
    if (empty($url) || !filter_var($url, FILTER_VALIDATE_URL)) {
        return false;
    }

    $parsed_url = parse_url($url);
    if (!isset($parsed_url['scheme']) || !isset($parsed_url['host'])) {
        return false;
    }

    $scheme = strtolower($parsed_url['scheme']);
    if (!in_array($scheme, ['http', 'https'])) {
        return false;
    }

    $host = strtolower($parsed_url['host']);
    $blocked_hosts = ['localhost', '127.0.0.1', '0.0.0.0', '::1'];
    if (in_array($host, $blocked_hosts) || empty($host)) {
        return false;
    }

    $ip = gethostbyname($host);
    if ($ip === $host || filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) === false) {
        return false;
    }

    $headers = @get_headers($url, 1);
    if ($headers === false || !isset($headers['Content-Type']) || strpos(strtolower($headers['Content-Type']), 'image/') !== 0) {
        return false;
    }

    return true;
}

function generateUniqueFilename($originalName) {
    $ext = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));
    return uniqid() . '_' . time() . '.' . $ext;
}

function isImageFile($file) {
    $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
    $file_extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

    if (!in_array($file_extension, $allowed_extensions)) {
        return false;
    }

    $mime_type = mime_content_type($file['tmp_name']);
    if (strpos($mime_type, 'image/') !== 0) {
        return false;
    }

    if ($file['size'] > 5 * 1024 * 1024) {
        return false;
    }

    return true;
}

function isValidFile($file) {
    $allowed_extensions = ['txt', 'docx', 'pdf'];
    $file_extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

    if (!in_array($file_extension, $allowed_extensions)) {
        return false;
    }

    if ($file['size'] > 5 * 1024 * 1024) {
        return false;
    }

    return true;
}
?>
