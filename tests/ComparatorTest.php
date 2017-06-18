<?php

use Comparator;
use PHPUnit\Framework\TestCase;

class ComparatorTest extends TestCase
{
    private $comparator;


    protected function setUp()
    {
        $this->comparator = new Comparator("Created by PhpStorm");
    }

    public function variants()
    {
        return [
            ['Creat because', 25],
            ['Created by Php', 78.282828282828],
            ["Created by PhpStorm", 100],
            ["by Php Storm Created", 59.188034188034]
        ];
    }

    /**
     * @dataProvider additionProvider
     */
    public function testCompare($variant, $percent)
    {
        $this->comparator->setVariant($variant);
        $this->assertEquals($percent, $this->comparator->compare());
    }
}
