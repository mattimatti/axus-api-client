<?php

namespace Axus\tests\Entity;

use Axus\Entity\Concierge;
use PHPUnit\Framework\TestCase;

/**
 * Concierge test case.
 */
class ConciergeTest extends TestCase
{

    /**
     * @var Concierge
     */
    private $concierge;

    /**
     * Tests Concierge->__construct()
     */
    public function test__construct()
    {
        // TODO Auto-generated ConciergeTest->test__construct()
        $this->markTestIncomplete("__construct test not implemented");

        $this->concierge->__construct();
    }

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->concierge = new Concierge();
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        $this->concierge = null;

        parent::tearDown();
    }
}

