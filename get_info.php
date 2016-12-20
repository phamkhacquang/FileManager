<?php

$MAX_UPLOAD_SIZE = min(asBytes(ini_get('post_max_size')), asBytes(ini_get('upload_max_filesize')));
echo $MAX_UPLOAD_SIZE;

function asBytes($ini_v) {
    $ini_v = trim($ini_v);
    $s = array('g' => 1 << 30, 'm' => 1 << 20, 'k' => 1 << 10);
    return intval($ini_v) * ($s[strtolower(substr($ini_v, -1))] ?: 1);
}

