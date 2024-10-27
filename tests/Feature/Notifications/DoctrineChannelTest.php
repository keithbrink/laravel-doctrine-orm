<?php

namespace LaravelDoctrineTest\ORM\Feature\Notifications;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use LaravelDoctrine\ORM\Exceptions\NoEntityManagerFound;
use LaravelDoctrine\ORM\Notifications\DoctrineChannel;
use LaravelDoctrineTest\ORM\Assets\Notifications\CustomNotifiableStub;
use LaravelDoctrineTest\ORM\Assets\Notifications\NotifiableStub;
use LaravelDoctrineTest\ORM\Assets\Notifications\NotificationDatabaseStub;
use LaravelDoctrineTest\ORM\Assets\Notifications\NotificationInvalidStub;
use LaravelDoctrineTest\ORM\Assets\Notifications\NotificationStub;
use Mockery;
use Mockery\Mock;
use PHPUnit\Framework\TestCase;
use RuntimeException;

class DoctrineChannelTest extends TestCase
{
    /**
     * @var DoctrineChannel
     */
    private $channel;

    /**
     * @var Mock
     */
    private $registry;

    /**
     * @var Mock
     */
    private $em;

    public function setUp(): void
    {
        $this->em = Mockery::spy(EntityManagerInterface::class);

        $this->channel = new DoctrineChannel(
            $this->registry = Mockery::mock(ManagerRegistry::class)
        );
    }

    public function test_can_send_notification_on_default_em()
    {
        $this->registry->shouldReceive('getManagerForClass')
                       ->with('LaravelDoctrine\ORM\Notifications\Notification')
                       ->andReturn($this->em);

        $this->channel->send(new NotifiableStub(), new NotificationStub());
        $this->channel->send(new NotifiableStub(), new NotificationDatabaseStub());

        $this->em->shouldHaveReceived('persist')->twice();
        $this->em->shouldHaveReceived('flush')->twice();

        $this->assertTrue(true);
    }

    public function testTriggerExceptionOnInvalidNotification()
    {
        $this->registry->shouldReceive('getManagerForClass')
            ->with('LaravelDoctrine\ORM\Notifications\Notification')
            ->andReturn($this->em);

        $this->expectException(RuntimeException::class);

        $this->channel->send(new NotifiableStub(), new NotificationInvalidStub());

        $this->em->shouldHaveReceived('persist')->once();
        $this->em->shouldHaveReceived('flush')->once();

        $this->assertTrue(true);
    }

    public function test_can_send_notification_on_custom_em()
    {
        $this->registry->shouldReceive('getManager')
                       ->with('custom')
                       ->andReturn($this->em);

        $this->channel->send(new CustomNotifiableStub(), new NotificationStub());

        $this->em->shouldHaveReceived('persist')->once();
        $this->em->shouldHaveReceived('flush')->once();

        $this->assertTrue(true);
    }

    public function test_it_should_throw_exception_when_it_does_not_find_an_em()
    {
        $this->expectException(NoEntityManagerFound::class);

        $this->registry->shouldReceive('getManager')
                       ->with('custom')
                       ->andReturnNull();

        $this->channel->send(new CustomNotifiableStub(), new NotificationStub());
    }
}
