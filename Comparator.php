<?php

use \Comparators\AComparator;

class Comparator implements \Comparators\IComparator
{
    /**
     * Входящие строки подлежащие сравнению
     * @var mixed|string
     * @var mixed|string
     */
    private $actualStr, $variantStr;

    /**
     * Список задействованных компараторов
     * @var array
     */
    private $comparators = [];

    /**
     * Получаем строку - образец
     * @param $actaul_string
     */
    public function __construct($actaul_string)
    {
        $this->checkString($actaul_string);
        $this->actualStr = mb_strtolower($actaul_string);
    }

    /**
     * проверка сроки на валидность для сравнения
     * @param $string
     * @throws Exception
     */
    private function checkString($string)
    {
        if (!is_string($string)) {
            throw new \Exception('Was expected string');
        }

        if (empty($string)) {
            throw new \Exception('String given is empty');
        }
    }

    /**
     * Получаем строку с котрой будем сравнивать
     * @param $string
     */
    public function setVariant($string)
    {
        $this->checkString($string);
        $this->variantStr = mb_strtolower($string);
    }

    /**
     * @inheritdoc
     * @return float|int
     * @throws Exception
     */
    public function compare()
    {
        if (!$this->variantStr) {
            throw new \Exception("Bad variant string");
        }

        $this->initComparators();

        $result = [];

        //получаем результат от каждого компаратора
        foreach ($this->comparators as $comparator) {
            $comparator->compare();
            $result[] = $comparator->getPercent();
        }

        $this->flushComparators();

        //возвращаем общий результат
        return array_sum($result) / count($result);
    }

    /**
     * Инициализируем компараторы которые нам будут сравнивать строки
     */
    private function initComparators()
    {
        $this->addComparator(new \Comparators\Simple($this->actualStr, $this->variantStr));
        $this->addComparator(new \Comparators\Simple($this->variantStr, $this->actualStr));
        $this->addComparator(new \Comparators\Breaker($this->actualStr, $this->variantStr));
        $this->addComparator(new \Comparators\Breaker($this->variantStr, $this->actualStr));
        $this->addComparator(new \Comparators\FullBreaker($this->actualStr, $this->variantStr));
        $this->addComparator(new \Comparators\FullBreaker($this->variantStr, $this->actualStr));
    }

    /**
     * Добавить компаратор в список
     * @param AComparator $comparator
     */
    private function addComparator(AComparator $comparator)
    {
        $this->comparators[] = $comparator;
    }

    /**
     * Очищаем список компараторов
     */
    private function flushComparators()
    {
        $this->comparators = [];
    }
}

