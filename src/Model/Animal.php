<?php

namespace FarmGame\Model;

abstract class Animal
{
    /**
     * @var int
     */
	protected $feedingInterval;

    /**
     * @var string
     */
	protected $friendlyName;

    /**
     * @var int
     */
	public $appetite;

    /**
     * Animal constructor.
     */
	public function __construct()
    {
        $this->appetite = $this->feedingInterval;
    }

    /**
     *
     */
    public function feed()
	{
        $this->appetite = $this->feedingInterval;
	}

    /**
     *
     */
	public function processTurn()
    {
        $this->appetite--;
    }

    /**
     * @return int
     */
    public function getFeedingInterval()
    {
        return $this->feedingInterval;
    }

    /**
     * @return bool
     */
	public function hasStarvedToDeath()
    {
        if($this->appetite <= 0){
            return true;
        }
        return false;
    }

    public function setAppetite($appetite)
    {
        $this->appetite = $appetite;
    }

    public function getAppetite()
    {
        return $this->appetite;
    }
}
