<?php

namespace FarmGame\Factory;

use FarmGame\Model\Bunny;
use FarmGame\Model\Cow;
use FarmGame\Model\Farmer;

class AnimalFactory
{
    /**
     * @var array
     */
    protected $animals = [
        'farmer' => Farmer::class,
        'cow'    => Cow::class,
        'bunny'  => Bunny::class,
    ];

    /**
     * @param $type
     * @param $amount
     * @return \Generator
     * @throws \Exception
     */
    public function createAnimals($type, $amount)
    {
        if(!array_key_exists($type,$this->animals)){
            throw new \Exception('Invalid Animal Type Provided');
        }
        for ($i=0; $i < $amount; $i++){
            yield new $this->animals[$type]();
        }
    }
}
