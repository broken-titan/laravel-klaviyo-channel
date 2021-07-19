<?php

	namespace Tests;

	use Illuminate\Notifications\Notification;
	use BrokenTitan\Klaviyo\Messages\KlaviyoIdentifyMessage;

	class TestIdentifyNotification extends Notification {
		public function toKlaviyo($notifiable) {
            return new KlaviyoIdentifyMessage(['$email' => 'test@test.com', '$first_name' => 'test']);
        }
	}