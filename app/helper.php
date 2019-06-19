<?php

if (!function_exists('uploadImage')) {
    function uploadImage($dir, $file)
    {
        if (!file_exists($dir)) {
            mkdir($dir, 0777, true);
        }
        $fileName = uniqid() . '-' . $file->getClientOriginalName();
        $file->move($dir, $fileName);

        return $fileName;
    }
}

if (!function_exists('uploadImageDrop')) {
    function uploadImageDrop($dir, $file)
    {
        if (!file_exists($dir)) {
            mkdir($dir, 0777, true);
        }
        $fileName = $file->getClientOriginalName();
        $file->move($dir, $fileName);

        return $fileName;
    }
}

if (!function_exists('roundRating')) {
    function roundRating($total_rating)
    {
        return round(($total_rating)/2, 1 , PHP_ROUND_HALF_EVEN);
    }
}

if (!function_exists('cutRedisKey')) {
    function cutRedisKey($key)
    {
        $new = str_replace('laravel_database_', '', $key);

        return $new;
    }
}

if (!function_exists('getEmailRedis')) {
    function getEmailRedis($key)
    {
        $email = str_replace('chat_log:', '', $key);

        return $email;
    }
}
