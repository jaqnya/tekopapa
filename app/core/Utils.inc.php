<?php
class Utils {

    public static function alltrim($string) {
        $string = trim($string);

        do {
            $string = str_replace('  ', ' ', $string);
        } while (strpos($string, '  ') > 0);

        return $string;
    }

    public static function upper($string) {
        return mb_convert_case($string, MB_CASE_UPPER, 'UTF-8');
    }

    public static function lower($string) {
        return mb_convert_case($string, MB_CASE_LOWER, 'UTF-8');
    }

    public static function proper($string) {
        return mb_convert_case($string, MB_CASE_TITLE, 'UTF-8');
    }

    public static function replace_by_entity_number($string) {
        $string = str_replace('á', '&#225;', $string);
        $string = str_replace('é', '&#233;', $string);
        $string = str_replace('í', '&#237;', $string);
        $string = str_replace('ó', '&#243;', $string);
        $string = str_replace('ú', '&#250;', $string);
        $string = str_replace('ñ', '&#241;', $string);

        return $string;
    }

    public static function base64_url_encode($string) {
        return strtr(base64_encode($string), '+/=', '-_,');
    }

    public static function base64_url_decode($string) {
        return base64_decode(strtr($string, '-_,', '+/='));
    }

    public static function prepare_for_search($string) {
        $string = self::alltrim(self::upper($string));

        if ($string !== '') {
            $string = '%' . $string . '%';
        }

        return $string;
    }

    public static function variable_initiated($variable) {
        if (isset($variable) && !empty($variable)) {
            return true;
        } else {
            return false;
        }
    }

}
?>