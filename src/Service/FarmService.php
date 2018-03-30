<?php

namespace FarmGame\Service;

use FarmGame\Factory\AnimalFactory;
use FarmGame\Model\Animal;
use FarmGame\Model\AnimalMap;

class FarmService
{
    /**
     * @var int
     */
    protected $maxTurns = 50;

    /**
     * @var
     */
    protected $turns;

    /**
     * @var array
     */
    protected $victoryCriteria = [
        'farmer' => 1,
        'cow'    => 1,
        'bunny'  => 1,
    ];

    /**
     * @var array
     */
    protected $animals;

    /**
     * FarmService constructor.
     * @param AnimalFactory $animalFactory
     * @param StateService $stateService
     */
    public function __construct(AnimalFactory $animalFactory, StateService $stateService)
    {
        $this->stateService  = $stateService;
        $this->animalFactory = $animalFactory;
    }

    /**
     *
     */
    public function setUp()
    {
        $animalMap     = new AnimalMap($this->stateService->getState());
        $this->turns   = $animalMap->turns ?? 0;
        $this->animals = $this->createAnimals($animalMap);
    }

    /**
     * @return string
     */
    public function execute()
    {
        $c = 0;
        do {
            $this->processTurn();
            $c++;
        } while ($c < $this->maxTurns);

        return $this->getGameState();
    }

    /**
     *
     */
    public function newGame()
    {
        $this->stateService->clearState();
        $this->setUp();
        $this->stateService->saveState($this->animals, $this->turns);
    }

    /**
     * @return boolean
     */
    public function processTurn()
    {
        $this->setUp();

        $animal = $this->getRandomAnimal();
        $animal->feed();

        foreach ($this->animals as $key => $animal) {
            $animal->processTurn();
            if ($animal->hasStarvedToDeath()) {
                unset($this->animals[$key]);
            }
        }
        $this->turns++;
        $this->stateService->saveState($this->animals, $this->turns);

        return $this->getGameState();
    }

    /**
     * @return string
     */
    protected function getGameState(): string
    {
        $gameState = $this->buildGameState();

        if ($this->gameHasTooFewAnimals($gameState)) {
            return 'lost';
        }

        if (!$this->gameHasTooFewAnimals($gameState) && $this->turns >= $this->maxTurns) {
            return 'won';
        }

        return 'in-progress';
    }

    /**
     * @return array
     */
    protected function buildGameState(): array
    {
        $gameState = [];
        foreach ($this->animals as $animal) {
            $gameState[$animal->friendlyName] = $gameState[$animal->friendlyName] ?? 0;
            $gameState[$animal->friendlyName]++;
        }

        return $gameState;
    }

    /**
     * @param $gameState
     * @return bool
     */
    protected function gameHasTooFewAnimals($gameState)
    {
        foreach ($this->victoryCriteria as $animal => $amount) {
            if (!isset($gameState[$animal])) {
                return true;
            } else {
                if ($gameState[$animal] < $amount) {
                    return true;
                }
            }
        }

        return false;
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
    protected function createAnimals(AnimalMap $animalMap)
    {
        $animals = [];
        foreach ($animalMap->getAnimals() as $animal) {
            foreach ($this->animalFactory->createAnimals($animal->friendlyName, 1) as $animalObject) {
                $animalObject->setAppetite($animal->appetite);
                $animals[] = $animalObject;
            }
        }

        return $animals;
    }

    /**
     * @return array
     */
    protected function createAnimalsFromAnimalMap($animalMap)
    {
        $animals = [];
        foreach ($animalMap as $type => $amount) {
            foreach ($this->animalFactory->createAnimals($type, $amount) as $animal) {
                $animals[] = $animal;
            }
        }

        return $animals;
    }

    /**
     * @return array
     */
    protected function createAnimalsFromState($state)
    {
        $animals = [];
        foreach ($state->animals as $animal) {
            foreach ($this->animalFactory->createAnimals($animal->friendlyName, 1) as $animalObject) {
                $animalObject->setAppetite($animal->appetite);
                $animals[] = $animalObject;
            }
        }

        return $animals;
    }
}
