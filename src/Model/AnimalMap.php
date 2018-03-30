<?php

namespace FarmGame\Model;

class AnimalMap
{
    /**
     * @var array
     */
    protected $animals;

    public function __construct($config)
    {
        if(isset($config->fromFile)){
            $this->animals = $this->createFromFile($config);
        } else {
            $this->animals = $this->createFromArray($config);
        }
    }

    public function getAnimals()
    {
        return $this->animals;
    }

    /**
     * @return array
     */
    protected function createFromArray($config)
    {
        $animals = [];
        foreach ($config as $type => $amount) {
            for ($i = 0; $i < $amount; $i++) {
                $animals[] = (object)[
                    'friendlyName' => $type,
                ];
            }
        }
        return $animals;
    }

    /**
     * @return array
     */
    protected function createFromFile($config)
    {
        return $config->animals;
    }
}
