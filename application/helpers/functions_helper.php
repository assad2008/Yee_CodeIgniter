<?php

/**
 * @file functions_helper.php
 * @synopsis  自定义函数
 * @author Yee, <rlk002@gmail.com>
 * @version 1.0
 * @date 2012-10-14 00:18:41
 */

function debug($var = null, $type = 2)
{
    if ($var === null) {
        $var = $GLOBALS;
    }
    header("Content-type:text/html;charset=utf-8");
    if ($type == 1) {
        dump_r($var);
    } elseif ($type == 2) {
        dump_r($var);
    }
    exit();
}

function rc4($string, $operation = 'DECODE', $key = 'dhzj2017', $expiry = 0)
{
    $ckey_length = 4;
    $keya = md5(substr($key, 0, 16));
    $keyb = md5(substr($key, 16, 16));
    $keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length) : substr(md5(microtime()), -$ckey_length)) : '';

    $cryptkey = $keya . md5($keya . $keyc);
    $key_length = strlen($cryptkey);

    $string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', $expiry ? $expiry + time() : 0) . substr(md5($string . $keyb), 0, 16) . $string;
    $string_length = strlen($string);

    $result = '';
    $box = range(0, 255);

    $rndkey = array();
    for ($i = 0; $i <= 255; $i++) {
        $rndkey[$i] = ord($cryptkey[$i % $key_length]);
    }

    for ($j = $i = 0; $i < 256; $i++) {
        $j = ($j + $box[$i] + $rndkey[$i]) % 256;
        $tmp = $box[$i];
        $box[$i] = $box[$j];
        $box[$j] = $tmp;
    }

    for ($a = $j = $i = 0; $i < $string_length; $i++) {
        $a = ($a + 1) % 256;
        $j = ($j + $box[$a]) % 256;
        $tmp = $box[$a];
        $box[$a] = $box[$j];
        $box[$j] = $tmp;
        $result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
    }

    if ($operation == 'DECODE') {
        if ((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26) . $keyb), 0, 16)) {
            return substr($result, 26);
        } else {
            return '';
        }
    } else {
        return $keyc . str_replace('=', '', base64_encode($result));
    }
}

function cutstr($string, $length, $dot = ' ...') //截取字符串 来自:Discuz

{
    global $charset;
    $charset = 'utf-8';
    if (strlen($string) <= $length) {
        return $string;
    }

    $string = str_replace(array('&amp;', '&quot;', '&lt;', '&gt;'), array('&', '"', '<', '>'), $string);

    $strcut = '';
    if (strtolower($charset) == 'utf-8') {
        $n = $tn = $noc = 0;
        while ($n < strlen($string)) {
            $t = ord($string[$n]);
            if ($t == 9 || $t == 10 || (32 <= $t && $t <= 126)) {
                $tn = 1;
                $n++;
                $noc++;
            } elseif (194 <= $t && $t <= 223) {
                $tn = 2;
                $n += 2;
                $noc += 2;
            } elseif (224 <= $t && $t <= 239) {
                $tn = 3;
                $n += 3;
                $noc += 2;
            } elseif (240 <= $t && $t <= 247) {
                $tn = 4;
                $n += 4;
                $noc += 2;
            } elseif (248 <= $t && $t <= 251) {
                $tn = 5;
                $n += 5;
                $noc += 2;
            } elseif ($t == 252 || $t == 253) {
                $tn = 6;
                $n += 6;
                $noc += 2;
            } else {
                $n++;
            }

            if ($noc >= $length) {
                break;
            }

        }
        if ($noc > $length) {
            $n -= $tn;
        }

        $strcut = substr($string, 0, $n);

    } else {
        for ($i = 0; $i < $length; $i++) {
            $strcut .= ord($string[$i]) > 127 ? $string[$i] . $string[++$i] : $string[$i];
        }
    }

    $strcut = str_replace(array('&', '"', '<', '>'), array('&amp;', '&quot;', '&lt;', '&gt;'), $strcut);

    return $strcut . $dot;
}

function random($length, $numeric = 0)
{
    PHP_VERSION < '4.2.0' ? mt_srand((double) microtime() * 1000000) : mt_srand();
    $seed = base_convert(md5(print_r($_SERVER, 1) . microtime()), 16, $numeric ? 10 : 35);
    $seed = $numeric ? (str_replace('0', '', $seed) . '012340567890') : ($seed . 'zZ' . strtoupper($seed));
    $hash = '';
    $max = strlen($seed) - 1;
    for ($i = 0; $i < $length; $i++) {
        $hash .= $seed[mt_rand(0, $max)];
    }
    return $hash;
}

function ffile_get_contents($url)
{
    $ctx = stream_context_create(
        array(
            'http' => array(
                'timeout' => 1, //设置一个超时时间，单位为秒
            ),
        )
    );
    $r = file_get_contents($url, 0, $ctx);
    unset($ctx);
    return $r;
}

function w_log($string, $t = 'day')
{
    if (is_array($string)) {
        $string = json_encode($string);
    }
    $timestamp = time();
    if ($t == 'day') {
        $f = date('Ymd', $timestamp);
        $filename = FCPATH . 'data/logs/wlog/' . $f . '.log';
    }
    $logtime = date('Y/m/d H:i:s', $timestamp);
    $record = $logtime . ' - ' . $string . "\n";
    writelog($filename, $record, 'ab');
}

function writelog($filename, $data, $method = 'wb+', $iflock = 1, $check = 1, $chmod = 1)
{
    if (empty($filename)) {
        return false;
    }

    if ($check && strpos($filename, '..') !== false) {
        return false;
    }
    if (!is_dir(dirname($filename)) && !mkdir_recursive(dirname($filename), 0777)) {
        return false;
    }
    if (false == ($handle = fopen($filename, $method))) {
        return false;
    }
    if ($iflock) {
        flock($handle, LOCK_EX);
    }
    fwrite($handle, $data);
    touch($filename);

    if ($method == "wb+") {
        ftruncate($handle, strlen($data));
    }
    fclose($handle);
    $chmod && @chmod($filename, 0777);
    return true;
}

function mkdir_recursive($pathname, $mode)
{
    if (strpos($pathname, '..') !== false) {
        return false;
    }
    $pathname = rtrim(preg_replace(array('/\\{1,}/', '/\/{2,}/'), '/', $pathname), '/');
    if (is_dir($pathname)) {
        return true;
    }

    is_dir(dirname($pathname)) || mkdir_recursive(dirname($pathname), $mode);
    return is_dir($pathname) || @mkdir($pathname, $mode);
}

function create_guidq()
{
    $charid = md5(uniqid(mt_rand(), true));
    $hyphen = chr(45);
    $uuid = substr($charid, 0, 8) . $hyphen
    . substr($charid, 8, 4) . $hyphen
    . substr($charid, 12, 4) . $hyphen
    . substr($charid, 16, 4) . $hyphen
    . substr($charid, 20, 12);
    return $uuid;
}

function get_charset()
{
    return '0123456789abcdefghijklmnopqrstuvwxyz-';
}

function stringtoint($string)
{
    $chars = get_charset();
    $integer = 0;
    $string = strrev($string);
    $baselen = strlen($chars);
    $inputlen = strlen($string);
    for ($i = 0; $i < $inputlen; $i++) {
        $index = strpos($chars, $string[$i]);
        $integer = bcadd($integer, bcmul($index, bcpow($baselen, $i)));
    }
    $integer = explode('.', $integer)[0];
    return $integer;
}

function inttostring($num)
{
    $chars = get_charset();
    $string = '';
    $len = strlen($chars);
    while ($num >= $len) {
        $mod = bcmod($num, $len);
        $num = bcdiv($num, $len);
        $string = $chars[$mod] . $string;
    }
    $string = $chars[$num] . $string;
    return $string;
}

function gensign($tokenLen = 60)
{
    if (file_exists('/dev/urandom')) {
        $randomData = file_get_contents('/dev/urandom', false, null, 0, 100) . uniqid(mt_rand(), true);
    } else {
        $randomData = mt_rand() . mt_rand() . mt_rand() . mt_rand() . microtime(true) . uniqid(mt_rand(), true);
    }
    return substr(hash('sha512', $randomData), 0, $tokenLen);
}

function download_file($file, $filename = "")
{
    $downfilename = $filename ?: basename($file);
    if (file_exists($file)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . $downfilename);
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file));
        ob_clean();
        flush();
        readfile($file);
        exit;
    }
}

function get_order_id()
{
    $time_order = time();
    list($usec, $sec) = explode(" ", microtime());
    $orderid = substr($uid * rand(11, 55), 0, 5);
    $orderid .= date('ymdHis', $sec) . ceil($usec * 10);
    $orderid = substr($orderid, 0, 18);
    return 'Y' . $orderid;
}
