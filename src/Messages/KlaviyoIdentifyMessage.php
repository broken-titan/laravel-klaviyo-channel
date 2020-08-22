<?php

	namespace BrokenTitan\Klaviyo\Messages;

	class KlaviyoIdentifyMessage extends KlaviyoMessage {
		/**
	     * @method create
		 * @param array $properties
	     * @return static
	     */
	    public static function create(array $properties) : self {
	        return new static($properties);
	    }
	}