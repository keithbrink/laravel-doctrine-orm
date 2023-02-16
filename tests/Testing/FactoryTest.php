<?php

use Doctrine\Persistence\ManagerRegistry;
use LaravelDoctrine\ORM\Testing\Factory;
use Mockery\Adapter\Phpunit\MockeryTestCase;

class FactoryTest extends MockeryTestCase
{
    public function test_it_passes_along_the_class_configured_states()
    {
        /** @var Faker\Generator $faker */
        $faker = Mockery::mock(Faker\Generator::class);
        /** @var ManagerRegistry $registry */
        $registry = Mockery::mock(ManagerRegistry::class);

        $factory = new Factory($faker, $registry);
        $factory->state('SomeClass', 'withState', function () {
        });

        $builder = $factory->of('SomeClass');

        $this->assertTrue(property_exists($builder, 'states'));
        $this->assertArrayHasKey('SomeClass', $builder->getStates());
        $this->assertArrayHasKey('withState', $builder->getStates()['SomeClass']);
    }

    public function test_it_passes_along_after_creating_callback()
    {
        /** @var Faker\Generator $faker */
        $faker = Mockery::mock(Faker\Generator::class);
        /** @var ManagerRegistry $registry */
        $registry = Mockery::mock(ManagerRegistry::class);

        $factory = new Factory($faker, $registry);
        $factory->afterCreating('SomeClass', function () {
        });

        $builder = $factory->of('SomeClass');

        $this->assertTrue(property_exists($builder, 'afterCreating'));
        $this->assertArrayHasKey('SomeClass', $builder->afterCreating);
        $this->assertArrayHasKey('default', $builder->afterCreating['SomeClass']);
    }

    public function test_it_passes_along_after_making_callback()
    {
        /** @var Faker\Generator $faker */
        $faker = Mockery::mock(Faker\Generator::class);
        /** @var ManagerRegistry $registry */
        $registry = Mockery::mock(ManagerRegistry::class);

        $factory = new Factory($faker, $registry);
        $factory->afterMaking('SomeClass', function () {
        });

        $builder = $factory->of('SomeClass');
        $this->assertTrue(property_exists($builder, 'afterMaking'));
        $this->assertArrayHasKey('SomeClass', $builder->afterMaking);
        $this->assertArrayHasKey('default', $builder->afterMaking['SomeClass']);
    }

    public function test_it_passes_along_after_creating_state_callback()
    {
        /** @var Faker\Generator $faker */
        $faker = Mockery::mock(Faker\Generator::class);
        /** @var ManagerRegistry $registry */
        $registry = Mockery::mock(ManagerRegistry::class);

        $factory = new Factory($faker, $registry);
        $factory->afterCreatingState('SomeClass', 'withState', function () {
        });

        $builder = $factory->of('SomeClass');
        $this->assertTrue(property_exists($builder, 'afterCreating'));
        $this->assertArrayHasKey('SomeClass', $builder->afterCreating);
        $this->assertArrayHasKey('withState', $builder->afterCreating['SomeClass']);
    }

    public function test_it_passes_along_after_making_state_callback()
    {
        /** @var Faker\Generator $faker */
        $faker = Mockery::mock(Faker\Generator::class);
        /** @var ManagerRegistry $registry */
        $registry = Mockery::mock(ManagerRegistry::class);

        $factory = new Factory($faker, $registry);
        $factory->afterMakingState('SomeClass', 'withState', function () {
        });

        $builder = $factory->of('SomeClass');

        $this->assertTrue(property_exists($builder, 'afterMaking'));
        $this->assertArrayHasKey('SomeClass', $builder->afterMaking);
        $this->assertArrayHasKey('withState', $builder->afterMaking['SomeClass']);
    }
}
