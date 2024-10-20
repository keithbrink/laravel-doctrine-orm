<?php

use Doctrine\ORM\Mapping\Driver\SimplifiedXmlDriver;
use Doctrine\ORM\Mapping\Driver\XmlDriver;
use Doctrine\Persistence\Mapping\Driver\DefaultFileLocator;
use Doctrine\Persistence\Mapping\Driver\SymfonyFileLocator;
use LaravelDoctrine\ORM\Extensions\MappingDriverChain;
use Mockery as m;
use Mockery\Mock;
use PHPUnit\Framework\TestCase;

/**
 * NOTE:  This test was degraded while refactoring for ORM 3.
 */
class MappingDriverChainTest extends TestCase
{
    /**
     * @var Mock
     */
    protected $driver;

    /**
     * @var MappingDriverChain
     */
    protected $chain;

    protected function setUp(): void
    {
        $this->driver = m::mock(XmlDriver::class);
        $this->chain  = new MappingDriverChain($this->driver, 'Namespace');
    }

    public function test_get_default_driver()
    {
        $this->assertEquals($this->driver, $this->chain->getDefaultDriver());
    }

    public function test_can_add_paths()
    {
        $this->driver = m::mock(XmlDriver::class);
        $this->chain  = new MappingDriverChain($this->driver, 'Namespace');

        $this->driver->shouldReceive('addPaths')->with(['paths']);
        $this->driver->shouldReceive('addPaths')->with(['paths2']);

        $this->chain->addPaths(['paths']);
        $this->chain->addPaths(['paths2']);

        $this->assertTrue(true);
    }

    public function test_can_add_paths_to_filedriver()
    {
        $driver  = m::mock(XmlDriver::class);
        $locator = m::mock(DefaultFileLocator::class);
        $chain   = new MappingDriverChain($driver, 'Namespace');

        $locator->shouldReceive('addPaths')->with(['paths']);
        $locator->shouldReceive('addPaths')->with(['paths2']);

        $chain->addPaths(['paths']);
        $chain->addPaths(['paths2']);

        $this->assertTrue(true);
    }

    public function test_can_add_mappings_to_filedriver()
    {
        $driver  = m::mock(XmlDriver::class);
        $locator = m::mock(DefaultFileLocator::class);
        $chain   = new MappingDriverChain($driver, 'Namespace');

        $locator->shouldReceive('addMappings')->with(['paths']);
        $locator->shouldReceive('addMappings')->with(['paths2']);

        $chain->addMappings(['paths']);
        $chain->addMappings(['paths2']);

        $this->assertTrue(true);
    }

    public function test_can_add_paths_to_simplified_filedriver()
    {
        $driver  = m::mock(SimplifiedXmlDriver::class);
        $locator = m::mock(SymfonyFileLocator::class);
        $chain   = new MappingDriverChain($driver, 'Namespace');

        $locator->shouldReceive('addNamespacePrefixes')->with(['paths']);
        $locator->shouldReceive('addNamespacePrefixes')->with(['paths2']);

        $chain->addPaths(['paths']);
        $chain->addPaths(['paths2']);

        $this->assertTrue(true);
    }

    protected function tearDown(): void
    {
        m::close();
    }
}
