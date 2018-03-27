<?php

namespace FarmGame\Model;

class Bunny extends Animal
{
    /**
     * @var int
     */
	protected $feedingInterval = 8;

    /**
     * @var string
     */
	public $friendlyName = 'bunny';
}
