<?php

namespace Comparators;


class Breaker extends AComparator
{
    /**
     * Массив слов первой строки
     * @var array
     */
    protected $firstStringArray = [];

    /**
     * Шаблон по которому будем разбивать сроку
     * @var string
     */
    protected $patternBreak = '/\w+/u';

    public function __construct($FirstString, $SecondString)
    {
        parent::__construct($FirstString, $SecondString);
        $this->firstStringArray = $this->stringBreaker($FirstString);
    }

    /**
     * Разбивает строку в соотвествии с шаблоном $patternBreak
     * @param string $string
     * @return array
     */
    protected function stringBreaker($string)
    {
        $matches = [];
        preg_match_all($this->patternBreak, $string, $matches);

        return $matches[0];
    }

    /**
     * @inheritdoc
     */
    public function compare()
    {
        $result = [];

        foreach ($this->firstStringArray as $match) {
            if (strpos($this->secondString, $match) !== false) {
                $result[] = $match;
            }
        }

        $this->percent = 100 * count($result) / count($this->firstStringArray);
    }
}