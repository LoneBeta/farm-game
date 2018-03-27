<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;

final class FarmServiceTest extends TestCase
{
    /**
     * @var \FarmGame\Service\FarmService
     */
    protected $farmService;

    public function setUp()
    {
        parent::setUp();
        $this->farmService = new \FarmGame\Service\FarmService(new \FarmGame\Factory\AnimalFactory());
    }

    public function testExecute(): void
    {
        $this->assertInternalType('string',$this->farmService->execute());
    }

    public function testProcessTurn(): void
    {
        $this->assertTrue($this->farmService->processTurn());
    }
}
