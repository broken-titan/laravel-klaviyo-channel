<?php

    namespace Tests;

    use BrokenTitan\Klaviyo\Channels\KlaviyoChannel;
    use Klaviyo\Klaviyo;
    use Mockery;

    class KlaviyoChannelTest extends TestCase {
        protected $channel;

        public function setUp(): void {
            $this->klaviyo = Mockery::mock(Klaviyo::class);
            $this->channel = new KlaviyoChannel($this->klaviyo);
            $this->notifiable = new TestNotifiable;
        }

        public function testSendTrackMessage() {
            $message = ($notification = new TestEventNotification)->toKlaviyo($this->notifiable);
            $this->klaviyo->shouldReceive("track")->once()->andReturn(true);
            $this->channel->send($this->notifiable, $notification);
        }

        public function testSendIdentifykMessage() {
            $message = ($notification = new TestIdentifyNotification)->toKlaviyo($this->notifiable);
            $this->klaviyo->shouldReceive("identify")->once()->andReturn(true);
            $this->channel->send($this->notifiable, $notification);
        }
    }