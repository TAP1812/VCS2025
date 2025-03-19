<?php
// Hàm kiểm tra URL có hợp lệ và an toàn không
function isSafeUrl($url) {
    // Kiểm tra URL hợp lệ
    if (!filter_var($url, FILTER_VALIDATE_URL)) {
        return false;
    }

    // Kiểm tra xem URL có trỏ đến một hình ảnh hợp lệ không
    $headers = @get_headers($url, 1);
    if (!$headers || strpos($headers[0], '200') === false) {
        return false;
    }

    // Kiểm tra loại nội dung (Content-Type) có phải là ảnh không
    if (isset($headers['Content-Type'])) {
        $content_type = strtolower($headers['Content-Type']);
        if (strpos($content_type, 'image/') !== 0) {
            return false;
        }
    } else {
        return false;
    }

    // Ngăn chặn SSRF: Không cho phép URL trỏ đến các địa chỉ nội bộ
    $parsed_url = parse_url($url);
    $host = $parsed_url['host'];
    $ip = gethostbyname($host);

    // Kiểm tra xem IP có phải là private IP không
    if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)) {
        return true;
    }

    return false;
}

// Hàm kiểm tra file upload có phải là ảnh hợp lệ không
function isImageFile($file) {
    $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
    $file_extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

    // Kiểm tra phần mở rộng của file
    if (!in_array($file_extension, $allowed_extensions)) {
        return false;
    }

    // Kiểm tra MIME type của file
    $mime_type = mime_content_type($file['tmp_name']);
    if (strpos($mime_type, 'image/') !== 0) {
        return false;
    }

    // Kiểm tra kích thước file (tối đa 5MB)
    if ($file['size'] > 5 * 1024 * 1024) {
        return false;
    }

    return true;
}
?>
