<?php

$allow_delete = true;
$tmp = realpath($_REQUEST['file']);
if ($tmp === false) {
    err(404, 'File or Directory Not Found');
}
//Không cho truy cập đến thư mục khác.
if (substr($tmp, 0, strlen(__DIR__)) !== __DIR__) {
//__DIR__ Đường dẫn thư mục hiện tại.
    err(403, "Forbidden");
}

$file = $_REQUEST['file'] ?: '.'; //ternary operator cái này dị vãi
$system_file = array(
    "nbproject",
    "action.php",
    "get_info.php",
    "get_list_file.php",
    "index.php",
    "script.js",
    "style.css",
    "lib",
    "fonts",
);
if (is_dir($file)) {
    $directory = $file;
    $result = array();
    $files = array_diff(scandir($directory), array('.', '..'));
    foreach ($files as $entry) {
        if (in_array($entry, $system_file)) {
            continue;
        }
        $i = $directory . '/' . $entry;
        $stat = stat($i);
        $result[] = array(
            'mtime' => $stat['mtime'],
            'size' => $stat['size'],
            'name' => basename($i),
            'path' => preg_replace('@^\./@', '', $i),
            'is_dir' => is_dir($i),
            'is_deleteable' => $allow_delete && ((!is_dir($i) && is_writable($directory)) ||
            (is_dir($i) && is_writable($directory) && is_recursively_deleteable($i))),
            'is_readable' => is_readable($i),
            'is_writable' => is_writable($i),
            'is_executable' => is_executable($i),
        );
    }
} else {
    err(412, "Not a Directory");
}
echo json_encode(array('success' => true, 'is_writable' => is_writable($file), 'results' => $result));

/**
 * Kiểm tra tính xóa được của folder
 */
function is_recursively_deleteable($d) {
    $stack = array($d);
    while ($dir = array_pop($stack)) {
        if (!is_readable($dir) || !is_writable($dir)) {
            return false;
        }
        $files = array_diff(scandir($dir), array('.', '..'));
        foreach ($files as $file) {
            if (is_dir($file)) {
                $stack[] = "$dir/$file";
            }
        }
    }
    return true;
}

function err($code, $msg) {
    echo json_encode(array('error' => array('code' => intval($code), 'msg' => $msg)));
    exit;
}
