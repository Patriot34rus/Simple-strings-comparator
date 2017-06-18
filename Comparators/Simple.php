<?php

namespace Comparators;


class Simple extends AComparator
{
    /**
     * @inheritdoc
     */
    public function compare()
    {
        similar_text($this->firstString, $this->secondString, $this->percent);
    }
}