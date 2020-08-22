<?php

	namespace BrokenTitan\Klaviyo\Messages;

	abstract class KlaviyoMessage {
		private string $token;
		public array $properties;

		/**
		 * @method __construct
		 * @param string $token
		 * @param array $properties
		 */
		public function __construct(array $properties) {
			$this->properties = $properties;
		}
	}