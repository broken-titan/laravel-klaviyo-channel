<?php

    namespace Tests;

    use Klaviyo\Klaviyo;
    use BrokenTitan\Klaviyo\Channels\KlaviyoChannel;
    use Mockery;
    use DateTimeInterface;

    class KlaviyoChannelTest extends TestCase {
        protected $channel;

        public function setUp(): void {
            $this->klaviyo = Mockery::mock(Klaviyo::class);
            $this->channel = new KlaviyoChannel($this->klaviyo);
            $this->notifiable = new TestNotifiable;
        }

        public function testSendTrackMessage() {
            $message = ($notification = new TestNotification)->toKlaviyo($this->notifiable);
            $this->klaviyo->shouldReceive("track")->withArgs(function($event, $customer_properties, $properties, $time) use ($message) {
                $this->assertEquals($event, $message->event);
                $this->assertEquals($customer_properties, $message->customer_properties);
                $this->assertEquals($properties, $message->properties);
                $this->assertEquals($time, $message->time);
                return true;
            })->once()->andReturn(true);
            $this->channel->send($this->notifiable, $notification);
        }

        public function testSendIdentifykMessage() {
            $message = ($notification = new TestNotification)->toKlaviyo($this->notifiable);
            $this->klaviyo->shouldReceive("track")->withArgs(function($event, $customer_properties, $properties, $time) use ($message) {
                $this->assertEquals($properties, $message->properties);
                return true;
            })->once()->andReturn(true);
            $this->channel->send($this->notifiable, $notification);
        }
    }