<?php

namespace Axus\tests\Entity;

use Axus\Entity\Concierge;
use PHPUnit\Framework\TestCase;

/**
 * Concierge test case.
 */
class AbstractEntityTest extends TestCase
{

    /**
     * @var Concierge
     */
    private $concierge;

    /**
     * Tests Concierge->__construct()
     */
    public function testAddParam()
    {
        $data = array(
            'foo' => 'bar'
        );

        $this->concierge->addParam('foo', 'bar');

        $actual = $this->concierge->toArray();

        $this->assertArrayHasKey('foo', $actual);
    }

    /**
     * Tests Concierge->__construct()
     */
    public function testReset()
    {
        $data = array(
            'foo' => 'bar'
        );

        $this->concierge = new Concierge($data);

        $actual = $this->concierge->toArray();

        $this->assertEquals($data, $actual);

        $this->concierge->reset();

        $actual = $this->concierge->toArray();

        $this->assertArrayNotHasKey('foo', $actual);
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

