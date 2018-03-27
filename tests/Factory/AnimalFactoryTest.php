<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;

final class AnimalFactoryTest extends TestCase
{
    public function testCreateAnimals(): void
    {
        $animalFactory = new \FarmGame\Factory\AnimalFactory();
        $animals = $animalFactory->createAnimals('bunny', 1);

        foreach ($animalFactory->createAnimals('bunny', 1) as $animal){
            $this->assertInstanceOf(
                \FarmGame\Model\Bunny::class,
                $animal
            );
        }

        foreach ($animalFactory->createAnimals('farmer', 1) as $animal){
            $this->assertInstanceOf(
                \FarmGame\Model\Farmer::class,
                $animal
            );
        }
    }
}
