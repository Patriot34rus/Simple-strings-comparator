<?php

namespace Comparators;


abstract class AComparator implements IComparator
{
    /**
     * @var string $firstString Срока для сравнения
     * @var string $secondString Срока для сравнения
     * @var float|int $percent Результат в процентах
     */
    protected $firstString, $secondString, $percent;

    /**
     * AComparator constructor.
     * @param string $FirstString
     * @param string $SecondString
     */
    public function __construct($FirstString, $SecondString)
    {
        $this->firstString = $FirstString;
        $this->secondString = $SecondString;
    }

    /**
     * Возвращает процент совпадения строк
     * @return float|int
     */
    public function getPercent()
    {
        return $this->percent;
    }
}