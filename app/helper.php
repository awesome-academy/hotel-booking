<?php

if (!function_exists('uploadImage')) {
    function uploadImage($dir, $file) {
        if (!file_exists($dir)) {
            mkdir($dir, 0777, true);
        }
        $fileName = uniqid() . '-' . $file->getClientOriginalName();
        $file->move($dir, $fileName);
        
        return $fileName;
    }
}
