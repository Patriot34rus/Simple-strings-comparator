<?php

namespace Comparators;


class FullBreaker extends Breaker
{
    /**
     * Массив слов второй строки
     * @var array
     */
    protected $secondStringArray;

    /**
     * Минимальный процент совпадения для слова
     * @var int
     */
    private $minLimit = 90;

    /**
     * FullBreaker constructor.
     * @param string $FirstString
     * @param string $SecondString
     */
    public function __construct($FirstString, $SecondString)
    {
        parent::__construct($FirstString, $SecondString);
        $this->secondStringArray = $this->stringBreaker($SecondString);
    }

    /**
     * @inheritdoc
     */
    public function compare()
    {
        $result = [];
        $percent = 0;

        foreach ($this->firstStringArray as $firstMatch) {
            foreach ($this->secondStringArray as $secondMatch) {
                similar_text($firstMatch, $secondMatch, $percent);
                if ($percent >= $this->minLimit) {
                    $result[] = $firstMatch;
                }
            }
        }

        $this->percent = 100 * count($result) / count($this->firstStringArray);
    }

}