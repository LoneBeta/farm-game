<?php

namespace FarmGame\Model;

class Farmer extends Animal
{
    /**
     * @var int
     */
	protected $feedingInterval = 15;

    /**
     * @var string
     */
    public $friendlyName = 'farmer';
}
