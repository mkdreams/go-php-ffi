<?php
$ffi = FFI::cdef(
    "
    typedef struct { char* p; long n } GoString;
    char* getPhpStringAndReturnString(char* p0);
    char* getGoStringAndReturnString(GoString str);
    int sum(int p0, int p1);
    char* httpGet(GoString url);
    ",
    __DIR__ . "/libutil.so"
);

function makeGoStr(FFI $ffi, string $str): FFI\CData
{
    $goStr = $ffi->new('GoString', 0);
    $size = strlen($str);
    $cStr = FFI::new("char[$size]", 0);

    FFI::memcpy($cStr, $str, $size);
    $goStr->p = $cStr;
    $goStr->n = strlen($str);
    return $goStr;
}

$string = FFI::string($ffi->getPhpStringAndReturnString(
    (string) $ffi->sum(2, 4)
));
var_dump($string);

$string = FFI::string($ffi->getGoStringAndReturnString(makeGoStr($ffi,'ok')));
var_dump($string);


$string = FFI::string($ffi->httpGet(makeGoStr($ffi,"http://cwoods.online")));
var_dump($string);
