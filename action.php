<?php
//setlocale(LC_ALL, 'en_US.UTF-8');
//Gán giá trị này bằng false để không cho xóa.
$allow_delete = true;
$file = $_REQUEST['file'] ?: '.';
if ($_POST['do'] == 'delete') {
    if ($allow_delete) {
        rmrf($file);
    }
    exit;
} elseif ($_POST['do'] == 'mkdir') {
    // Không cho tạo file ngoài mục root. Xảy ra khi thằng nào chơi đểu nhập tên file thế này './../outside'
    $dir = $_POST['name'];
    $dir = str_replace('/', '', $dir);
    if (substr($dir, 0, 2) === '..') {
        exit;
    }
    chdir($file);
    @mkdir($_POST['name']); //Thêm dấu @ để khi có lỗi sẽ không hiện
    exit;
} elseif ($_POST['do'] == 'upload') {
    var_dump($_POST);
    var_dump($_FILES);
    var_dump($_FILES['file_data']['tmp_name']);
    var_dump(move_uploaded_file($_FILES['file_data']['tmp_name'], $file . '/' . $_FILES['file_data']['name']));
    exit;
} elseif ($_GET['do'] == 'download') {
    $filename = basename($file);
    header('Content-Type: ' . mime_content_type($file));
    header('Content-Length: ' . filesize($file));
    header(sprintf('Content-Disposition: attachment; filename=%s', strpos('MSIE', $_SERVER['HTTP_REFERER']) ? rawurlencode($filename) : "\"$filename\"" ));
    ob_flush();
    readfile($file);
    exit;
}

/**
 * Xóa thư mục hoặc file
 * @param type $dir
 */
function rmrf($dir) {
    if (is_dir($dir)) {
        $files = array_diff(scandir($dir), array('.', '..'));
        foreach ($files as $file) {
            rmrf("$dir/$file");
        }
        rmdir($dir);
    } else {
        unlink($dir);
    }
}


