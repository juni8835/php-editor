<?php

class Helper {
    static function generateRandomId($length = 24) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $uniqueId = '';
        for ($i = 0; $i < $length; $i++) {
            $uniqueId .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $uniqueId;
    }
}