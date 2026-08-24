<?php
/**
 * Notfall-Ersatz für mbstring.
 *
 * Manche PHP-Installationen (auch bei Hostern) liefern die mbstring-Erweiterung
 * nicht mit. Damit das Panel dort nicht mit einem Fatal Error abbricht, werden
 * die drei hier benutzten Funktionen bei Bedarf UTF-8-tauglich nachgebaut.
 * Ist mbstring vorhanden, passiert in dieser Datei nichts.
 */

declare(strict_types=1);

if (!function_exists('mb_strlen')) {
    function mb_strlen(string $string, ?string $encoding = null): int
    {
        if (function_exists('iconv_strlen')) {
            $length = @iconv_strlen($string, 'UTF-8');
            if ($length !== false) {
                return $length;
            }
        }
        $length = preg_match_all('/./us', $string);
        return $length === false ? strlen($string) : $length;
    }
}

if (!function_exists('mb_substr')) {
    function mb_substr(string $string, int $start, ?int $length = null, ?string $encoding = null): string
    {
        if (function_exists('iconv_substr')) {
            $result = @iconv_substr($string, $start, $length ?? PHP_INT_MAX, 'UTF-8');
            if (is_string($result)) {
                return $result;
            }
        }
        $chars = preg_split('//u', $string, -1, PREG_SPLIT_NO_EMPTY);
        if ($chars === false) {
            return substr($string, $start, $length ?? PHP_INT_MAX);
        }
        return implode('', array_slice($chars, $start, $length));
    }
}

if (!function_exists('mb_strtolower')) {
    /** Deckt ASCII plus die im Deutschen üblichen Akzentbuchstaben ab. */
    function mb_strtolower(string $string, ?string $encoding = null): string
    {
        static $map = [
            'À' => 'à', 'Á' => 'á', 'Â' => 'â', 'Ã' => 'ã', 'Ä' => 'ä', 'Å' => 'å',
            'Æ' => 'æ', 'Ç' => 'ç', 'È' => 'è', 'É' => 'é', 'Ê' => 'ê', 'Ë' => 'ë',
            'Ì' => 'ì', 'Í' => 'í', 'Î' => 'î', 'Ï' => 'ï', 'Ñ' => 'ñ', 'Ò' => 'ò',
            'Ó' => 'ó', 'Ô' => 'ô', 'Õ' => 'õ', 'Ö' => 'ö', 'Ø' => 'ø', 'Ù' => 'ù',
            'Ú' => 'ú', 'Û' => 'û', 'Ü' => 'ü', 'Ý' => 'ý',
        ];

        return strtr(strtolower($string), $map);
    }
}
