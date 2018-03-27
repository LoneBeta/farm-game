<?php

namespace FarmGame\Model;

class Cow extends Animal
{
    /**
     * @var int
     */
    protected $feedingInterval = 10;

    /**
     * @var string
     */
    public $friendlyName = 'cow';
}
