<?php

namespace spaceboy;

class Base20 {

    public static $bArr = array(
        'bckwhmgldfvnxzqrsptj',
        'mhdzfptlxbjwvkrsgcqn',
        'fmrcvxjswzdqlbhgnkpt',
        //'prfnvxwsjcdqlthbmgkz',
        //'dmthwsjpbxglfznrqvck',
    );

    public static $aArr = 'yueioa';

    public static function decode ($source) {
        $num = sizeof(self::$bArr);
        $len = strlen($source);
        $out = 0;
        if (3 > $len) {
            throw new \Exception("Given code ({$source}} is too short; at least 3 letters expected.");
        }
        if (1 != ($len % 2)) {
            throw new \Exception("Wrong code ({$source}} given.");
        }
        if ($len != (($num * 2) - 1)) {
            throw new \Exception("Given code ({$source}} doesn't match given number size.");
        }
        $tmp = array();
        for ($i = 0; $i < $len; $i += 2) {
            array_unshift($tmp, strToLower($source[$i]));
        }
        $exp = 1;
        foreach ($tmp as $i => $v) {
            $p = strpos(self::$bArr[$i], $v);
            if (false === $p) {
                $v = strToUpper($v);
                throw new \Exception("Index \"{$v}\" not found in ({$source}), at least 2 required.");
            }
            $out += $p * $exp;
            $exp = $exp * 20;
        }
        $p = strpos(self::$aArr, strToLower($source[1]));
        if ($p != ($out % 5)) {
            throw new \Exception("Control number in ({$source}) doesn't match.");
        }
        return $out;
    }

    public static function encode ($source) {
        $exp = 0;
        $tmp = array();
        $out = array();
        $num = sizeof(self::$bArr);
        if (2 > $num) {
            throw new \Exception("Too small base number sets ({$num}), at least 2 required.");
        }
        $src = $source;
        // Compute base number:
        while (0 < $src) {
            if ($exp >= $num) {
                throw new \Exception("Too big number ({$source})");
            }
            $tmp[] = self::$bArr[$exp][$src % 20];
            $src = floor($src / 20);
            $exp++;
        };
        // Add leading "zeroes":
        while ($exp < $num) {
            array_unshift($tmp, self::$bArr[$exp++][0]);
        }
        // Add control number (source mod 5 in first gap, self::$aArr[5] to others)
        --$num;
        for ($i = 0; $i <= $num; $i++) {
            $out[] = $tmp[$i];
            if ($i != $num) {
                $out[] = (
                    $i
                    ? self::$aArr[5]
                    : self::$aArr[$source % 5]
                );
            }
        }
        return implode('', $out);
    }

    public static function explode ($str) {
        $a = array();
        $l = strlen($str);
        for ($i = 0; $i < $l; $i++) {
            $a[] = $str[$i];
        }
        return $a;
    }

    public static function getRandomSet () {
        $a = self::explode('bcdfghjklmnpqrstvwxz');
        shuffle($a);
        return join('', $a);
    }
}
