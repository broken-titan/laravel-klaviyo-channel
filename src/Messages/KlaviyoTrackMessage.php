<?php

	namespace BrokenTitan\Klaviyo\Messages;

	use DateTimeInterface;

	class KlaviyoTrackMessage extends KlaviyoMessage {
		public string $event;
		public array $customer_properties;
		public ?string $time;

		/**
	     * @method create
		 * @param string $event
		 * @param array $customer_properties
		 * @param array $properties
		 * @param ?DateTimeInterface $time
	     * @return static
	     */
	    public static function create(string $event, array $customer_properties, array $properties = [], ?DateTimeInterface $time = null) : self {
	        return new static($event, $customer_properties, $properties, $time);
	    }

		/**
		 * @method __construct
		 * @param string $event
		 * @param array $customer_properties
		 * @param array $properties
		 * @param ?DateTimeInterface $time
		 */
		public function __construct(string $event, array $customer_properties, array $properties = [], ?DateTimeInterface $time = null) {
			$this->event = $event;
			$this->customer_properties = $customer_properties;
			$this->properties = $properties;
			$this->time = $time ? $time->format("U") : null;
		}
	} 