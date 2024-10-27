<?php

namespace LaravelDoctrineTest\ORM\Feature\Configuration\MetaData;

use Doctrine\ORM\Mapping\Driver\SimplifiedXmlDriver;
use Doctrine\Persistence\Mapping\Driver\MappingDriver;
use LaravelDoctrine\ORM\Configuration\MetaData\SimplifiedXml;
use Mockery as m;
use PHPUnit\Framework\TestCase;

class SimplifiedXmlTest extends TestCase
{
    /**
     * @var SimplifiedXml
     */
    protected $meta;

    protected function setUp(): void
    {
        $this->meta = new SimplifiedXml();
    }

    public function test_can_resolve()
    {
        $resolved = $this->meta->resolve([
            'paths'     => ['entities' => 'App\Entities'],
            'dev'       => true,
            'extension' => '.xml',
            'proxies'   => ['path' => 'path']
        ]);

        $this->assertInstanceOf(MappingDriver::class, $resolved);
        $this->assertInstanceOf(SimplifiedXmlDriver::class, $resolved);
    }

    protected function tearDown(): void
    {
        m::close();
    }
}
