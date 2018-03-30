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
        $this->farmService = new \FarmGame\Service\FarmService(
            new \FarmGame\Factory\AnimalFactory(),
            new \FarmGame\Service\StateService()
        );
    }

    public function testExecute(): void
    {
        $this->assertInternalType('string', $this->farmService->execute());
    }

    public function testProcessTurn(): void
    {
        $this->assertInternalType('string', $this->farmService->processTurn());
    }

    public function testNewGame(): void
    {
        $this->assertInternalType('string', $this->farmService->newGame());
    }
}
