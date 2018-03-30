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
        $this->turns   = $animalMap->getTurns() ?? 0;
        $this->animals = $this->createAnimals($animalMap);
    }

    /**
     * Function to run all 50 turns at once.
     *
     * @return string
     */
    public function execute(): string
    {
        $this->newGame();

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
    public function newGame(): string
    {
        $this->stateService->clearState();
        $this->setUp();
        $this->stateService->saveState($this->animals, $this->turns);

        return 'New Game Created';
    }

    /**
     * @return string
     */
    public function processTurn(): string
    {
        $this->setUp();

        $animal = $this->getRandomAnimal();
        $animal->feed();

        /**
         * Process turn for each animal and remove dead animals
         */
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
            return 'Lost';
        }

        if (!$this->gameHasTooFewAnimals($gameState) && $this->turns >= $this->maxTurns) {
            return 'Won';
        }

        return 'In Progress';
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
    protected function gameHasTooFewAnimals($gameState): bool
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
    protected function getRandomAnimal(): Animal
    {
        shuffle($this->animals);

        return $this->animals[0];
    }

    /**
     * @param AnimalMap $animalMap
     * @return array
     */
    protected function createAnimals(AnimalMap $animalMap): array
    {
        $animals = [];
        foreach ($animalMap->getAnimals() as $animal) {
            foreach ($this->animalFactory->createAnimals($animal->friendlyName, 1) as $animalObject) {
                if (isset($animal->appetite)) {
                    $animalObject->setAppetite($animal->appetite);
                }
                $animals[] = $animalObject;
            }
        }

        return $animals;
    }
}
