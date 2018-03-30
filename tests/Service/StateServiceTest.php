<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;

final class StateServiceTest extends TestCase
{
    /**
     * @var \FarmGame\Service\StateService
     */
    protected $stateService;

    protected $file = __DIR__.'/../../resources/state.json';

    public function setUp()
    {
        parent::setUp();
        $this->stateService = new \FarmGame\Service\StateService();
    }

    public function testGetState(): void
    {
        file_put_contents(
            $this->file,
            '{"fromFile":true,"animals":[{"friendlyName":"farmer","appetite":14}]}'
        );

        $this->assertInstanceOf('\\stdClass', $this->stateService->getState());

        unlink($this->file);

        $this->assertInternalType('array', $this->stateService->getState());

    }

    public function testClearState(): void
    {
        file_put_contents(
            $this->file,
            '{"fromFile":true,"animals":[{"friendlyName":"farmer","appetite":14}]}'
        );
        $this->stateService->clearState();

        $this->assertTrue(!file_exists($this->file));

    }

    public function testSaveState(): void
    {
        if (file_exists($this->file)) {
            unlink($this->file);
        }
        $this->stateService->saveState([new \FarmGame\Model\Bunny()], 1);
        $this->assertTrue(file_exists($this->file));
    }
}
