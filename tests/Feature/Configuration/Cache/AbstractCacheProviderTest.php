<?php

namespace LaravelDoctrineTest\ORM\Feature\Configuration\Cache;

use Mockery;
use PHPUnit\Framework\TestCase;

abstract class AbstractCacheProviderTest extends TestCase
{
    abstract public function getProvider();

    abstract public function getExpectedInstance();

    public function test_can_resolve()
    {
        $this->assertInstanceOf($this->getExpectedInstance(), $this->getProvider()->resolve());
    }

    public function tearDown(): void
    {
        Mockery::close();
    }
}
