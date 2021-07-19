<?php

	namespace Tests;

	use Illuminate\Notifications\Notification;
	use BrokenTitan\Klaviyo\Messages\KlaviyoTrackMessage;
	use DateTimeImmutable;

	class TestNotification extends Notification {
		public function toKlaviyo($notifiable) {
			return new KlaviyoTrackMessage("Test Notification", ['$email' => 'test@test.com'], ['event_id' => 'test_id'], new DateTimeImmutable);
        }
	}