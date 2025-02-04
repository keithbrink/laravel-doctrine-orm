<?php

declare(strict_types=1);

namespace LaravelDoctrineTest\ORM\Feature\Configuration\Cache;

use Illuminate\Contracts\Cache\Factory;
use Illuminate\Contracts\Cache\Repository;
use LaravelDoctrine\ORM\Configuration\Cache\MemcachedCacheProvider;
use Mockery as m;
use Psr\Cache\CacheItemPoolInterface;

class MemcachedCacheProviderTest extends CacheProvider
{
    public function getProvider(): mixed
    {
        $repo    = m::mock(Repository::class);
        $manager = m::mock(Factory::class);
        $manager->shouldReceive('store')
                ->with('memcached')
                ->once()->andReturn($repo);

        return new MemcachedCacheProvider(
            $manager,
        );
    }

    public function getExpectedInstance(): mixed
    {
        return CacheItemPoolInterface::class;
    }
}
