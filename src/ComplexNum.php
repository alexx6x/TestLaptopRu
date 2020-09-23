<?php

namespace Alexx6x\TestLaptopRu;

//You need "pecl install operator-beta" if you whant use oprators
define('PECL_OPERATOR_INSTALLED', extension_loaded('operator'));

class ComplexNum {

    protected $a;
    protected $b;

    public function __construct($obj) {
        $arr = [0, 0];
        if (is_string($obj)) {
            $str = str_replace('{', '', $obj);
            $str = str_replace('{', '', $str);

            $arr = explode(';', $str);
        } elseif (is_array($obj)) {
            $arr = $obj;
        } else {
            $arr[0] = (double) $obj;
        }

        $this->a = (double) $arr[0];
        $this->b = (double) $arr[1];
    }

    public function __add($num) {
        $ret = clone $this;
        if ($num instanceof ComplexNum) {
            $ret->a += $num->a;
            $ret->b += $num->b;
        } else {
            $ret->a += (double) $num;
        }
        return $ret;
    }

    public function __sub($num) {
        self::safeArg($num);
        if (PECL_OPERATOR_INSTALLED) {
            $ret = $this + (-1) * $num;
        } else {
            $ret = $this->__add($num->__mul(-1));
        }
        return $ret;
    }

    //z1⋅z2=(x1+y1i)⋅(x2+y2i)=(x1⋅x2−y1⋅y2)+(x2⋅y1+x1⋅y2)i
    public function __mul($num) {
        self::safeArg($num);

        $a = $this->a * $num->a - $this->b * $num->b;
        $b = $this->a * $num->b + $this->b * $num->a;
        $ret = new ComplexNum([$a, $b]);
        return $ret;
    }

    //z1/z2=a1+b1i/a2+b2i=(a1+b1i)(a2−b2i)/(a2+b2i)(a2−b2i)=(a1⋅a2+b1⋅b2)/a2^2+b2^2+i(a2⋅b1−a1⋅b2)/a2^2+b2^2
    //in division i dont check on zero, as style of real numbers math realysed in this lang
    //and waiting exeption of real math if will be only if z2 == 0
    public function __div($num) {
        self::safeArg($num);

        $div = pow($num->a, 2) + pow($num->b, 2);



        $a = $this->a * $num->a + $this->b * $num->b;

        @$a /= $div;
        $b = $this->b * $num->a - $this->a * $num->b;
        @$b /= $div;

        $ret = new ComplexNum([$a, $b]);
        return $ret;
    }

    public function __toString() {
        return '{' . $this->a . ';' . $this->b . '}';
    }

    private static function safeArg(&$arg) {
        if (!($arg instanceof ComplexNum)) {
            $arg = new ComplexNum($arg);
        }
    }

}