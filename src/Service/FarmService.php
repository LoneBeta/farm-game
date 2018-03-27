<?php

namespace FarmGame\Service;

use FarmGame\Factory\AnimalFactory;
use FarmGame\Model\Animal;

class FarmService
{
    /**
     * @var array
     */
    protected $animalMap = [
        'farmer' => 1,
        'cow'    => 2,
        'bunny'  => 4,
    ];

    /**
     * @var int
     */
    protected $maxTurns = 50;

    /**
     * @var array
     */
    protected $victoryCriteria = [
        'farmer' => 1,
        'cow'    => 1,
        'bunny'  => 1,
    ];

    /**
     * FarmService constructor.
     * @param AnimalFactory $animalFactory
     */
    public function __construct(AnimalFactory $animalFactory)
    {
        $this->animalFactory = $animalFactory;
        $this->animals       = $this->createAnimals();
    }

    /**
     * @return string
     */
    public function execute()
    {
        $c = 0;
        do{
            $this->processTurn();
            $c++;
        }while($c < $this->maxTurns);

        return $this->getGameState();
    }

    /**
     * @return boolean
     */
    public function processTurn()
    {
        $animal = $this->getRandomAnimal();
        $animal->feed();

        foreach ($this->animals as $key => $animal){
            $animal->processTurn();
            if($animal->hasStarvedToDeath()){
                unset($this->animals[$key]);
            }
        }
        return true;
    }

    /**
     * @return string
     */
    protected function getGameState()
    {
        $gameState = [];
        foreach ($this->animals as $animal){
            $gameState[$animal->friendlyName] = $gameState[$animal->friendlyName] ?? 0;
            $gameState[$animal->friendlyName]++;
        }

        foreach ($this->victoryCriteria as $animal => $amount){
            if(!isset($gameState[$animal])){
                return 'lost';
            }
            if(isset($gameState[$animal]) && $gameState[$animal] < $amount){
                return 'lost';
            }
        }
        return 'won';
    }

    /**
     * @return Animal
     */
    protected function getRandomAnimal()
    {
        shuffle($this->animals);
        return $this->animals[0];
    }

    /**
     * @return array
     */
    protected function createAnimals()
    {
        $animals = [];
        foreach ($this->animalMap as $type => $amount) {
            foreach ($this->animalFactory->createAnimals($type, $amount) as $animal) {
                $animals[] = $animal;
            }
        }

        return $animals;
    }
}
