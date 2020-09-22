<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use PHPUnit\Framework\TestCase;

class complex_num_test extends TestCase {

    private static function rand_double() {
        return rand(0, 10000) / 100;
    }

    public function test_easy() {



        $complex = new vacancy\complex_num([self::rand_double(), self::rand_double()]);
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
                $complex [] = new vacancy\complex_num([$i, $j]);
                if (random_int(0, 1)) {
                    $complex [] = new vacancy\complex_num([self::rand_double(), self::rand_double()]);
                } else {
                    $complex [] = self::rand_double();
                }
            }
        }




        $operations = ['__add' => '+', '__sub' => '-', '__mul' => '*', '__div' => '/'];


        $res_count = 0;
        for ($i = 0; $i < $size; $i++) {
            for ($j = 0; $j < $size; $j++) {
                foreach ($operations as $op => $symbol) {
                    $res = null;
                    if (!($complex[$i] instanceof vacancy\complex_num))
                        $complex[$i] = new vacancy\complex_num($complex[$i]);

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

}

//function tes

//test();
