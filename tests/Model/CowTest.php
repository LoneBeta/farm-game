<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;

final class CowTest extends TestCase
{
    public function testProcessTurn(): void
    {
        $bunny = new \FarmGame\Model\Cow();
        $bunny->processTurn();

        $this->assertEquals($bunny->getFeedingInterval()-1, $bunny->getAppetite());
    }

    public function testFeed(): void
    {
        $bunny = new \FarmGame\Model\Cow();
        $bunny->processTurn();
        $bunny->feed();

        $this->assertEquals($bunny->getFeedingInterval(), $bunny->getAppetite());
    }
}
