<?php

use PHPUnit\Framework\TestCase;
use Alexx6x\TestLaptopRu\ComplexNum;

class ComplexNumTest extends TestCase {
    public function testEasy() {
        
        $complex = new ComplexNum([self::randDouble(), self::randDouble()]);
        $complex = $complex->__mul(0);

        $this->assertEquals('{0;0}', (string) $complex);
    }

    public function testFirstVariant() {
        $s1 = 5;
        $s2 = 5;

        $complex = [];

        $size = $s1 * $s2;
        $size <<= 1;



        for ($i = 0; $i < $s1; $i++) {
            for ($j = 0; $j < $s2; $j++) {
                $complex [] = new ComplexNum([$i, $j]);
                if (random_int(0, 1)) {
                    $complex [] = new ComplexNum([self::randDouble(), self::randDouble()]);
                } else {
                    $complex [] = self::randDouble();
                }
            }
        }




        $operations = ['__add' => '+', '__sub' => '-', '__mul' => '*', '__div' => '/'];


        $res_count = 0;
        for ($i = 0; $i < $size; $i++) {
            for ($j = 0; $j < $size; $j++) {
                foreach ($operations as $op => $symbol) {
                    $res = null;
                    if (!($complex[$i] instanceof ComplexNum))
                        $complex[$i] = new ComplexNum($complex[$i]);

                    if (PECL_OPERATOR_INSTALLED && $symbol == '+') {
                        $res = $complex[$i] + $complex[$j];
                    } else {
                        try {
                            $res = $complex[$i]->$op($complex[$j]);
                        } catch (\Exception $e) {
                            $res = ' ERROR:' . $e->getMessage();
                        }
                    }

                    echo $complex[$i] . ' ' . $symbol . ' ' . $complex[$j] . ' = ' . $res . PHP_EOL;
                    $res_count++;
                }
            }
        }

        $this->assertEquals(10000, $res_count);
    }
    
    private static function randDouble() {
        return rand(0, 10000) / 100;
    }
    

}
