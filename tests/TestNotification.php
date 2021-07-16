<?php

	namespace Tests;

	use Illuminate\Notifications\Notification;
	use Klaviyo\Model\EventModel as KlaviyoEvent;
	use DateTimeImmutable;

	class TestNotification extends Notification {
		public function toKlaviyo($notifiable) {
			return new KlaviyoEvent([
                'event' => 'Test Notification',
                'customer_properties' => ['$email' => 'test@test.com'], 
                'properties' => ['event_id' => 'test_id'],
                'time' => new DateTimeImmutable
            ]);
        }
	}