<?php

use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Doctrine\Persistence\Mapping\Driver\MappingDriver;
use LaravelDoctrine\ORM\Configuration\MetaData\Annotations;
use Mockery as m;
use PHPUnit\Framework\TestCase;

class AnnotationsTest extends TestCase
{
    /**
     * @var Annotations
     */
    protected $meta;

    protected function setUp(): void
    {
        $this->meta = new Annotations();
    }

    public function test_can_resolve()
    {
        $resolved = $this->meta->resolve([
            'paths'   => ['entities'],
            'dev'     => true,
            'proxies' => ['path' => 'path'],
        ]);

        $this->assertInstanceOf(MappingDriver::class, $resolved);
        $this->assertInstanceOf(AnnotationDriver::class, $resolved);
    }

    protected function tearDown(): void
    {
        m::close();
    }
}
