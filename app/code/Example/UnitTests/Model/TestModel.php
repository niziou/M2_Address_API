<?php

namespace Example\UnitTests\Model;

/**
 * Class TestModel
 * @package Example\UnitTests\Model
 */
class TestModel
{
    /**
     * @param $a
     * @param $b
     * @return mixed
     */
    public function add($a, $b)
    {
        return $a + $b;
    }

    /**
     * @param $a
     * @param $b
     * @return mixed
     */
    public function subtract($a, $b)
    {
        return $a - $b;
    }

    /**
     * @param $a
     * @param $b
     * @return float|int
     */
    public function multiply($a, $b)
    {
        return $a * $b;
    }

    /**
     * @param $a
     * @param $b
     * @return float|int
     */
    public function divide($a, $b)
    {
        return $a / $b;
    }
}