<?php

    namespace BrokenTitan\Klaviyo\Channels;

    use Illuminate\Notifications\Notification as Notification;
    use BrokenTitan\Klaviyo\Messages\KlaviyoTrackMessage;
    use BrokenTitan\Klaviyo\Messages\KlaviyoTrackOnceMessage;
    use BrokenTitan\Klaviyo\Messages\KlaviyoIdentifyMessage;
    use Klaviyo;
    use Exception;

    class KlaviyoChannel {
        private Klaviyo $klaviyo;

        /**
         * @method __construct
         * @param Klaviyo $klaviyo
         */
        public function __construct(Klaviyo $klaviyo) {
            $this->klaviyo = $klaviyo;
        }

        /**
         * Send the given notification.
         *
         * @method send
         * @param mixed $notifiable
         * @param Illuminate\Notifications\Notification $notification
         * @return void
         */
        public function send($notifiable, Notification $notification) {
            $message = $notification->toKlaviyo($notifiable);
            
            /** Events sent within the same second may have the same default ID so we use the notification ID here. **/
            if (empty($message->properties['$event_id'])) {
                $message->properties['$event_id'] = $notification->id;
            }

            switch (true) {
                default:
                    throw new Exception("Klaviyo message type does not match a valid type of call.");
                    break;

                case $message instanceof KlaviyoTrackMessage:
                    $result = $this->track($message);
                    break;

                case $message instanceof KlaviyoTrackOnceMessage:
                    $result = $this->trackOnce($message);
                    break;

                case $message instanceof KlaviyoIdentifyMessage:
                    $result = $this->identify($message);
                    break;
            }

            if ($result !== true) {
                throw new Exception("Klaviyo event sending returned a failure.");
            }
        }

        /**
         * @method track
         * @param BrokenTitan\Klaviyo\Messages\KlaviyoTrackMessage
         * @return bool
         */
        private function track(KlaviyoTrackMessage $message) : bool {
            return $this->klaviyo->track($message->event, $message->customer_properties, $message->properties, $message->time);
        }

        /**
         * @method trackOnce
         * @param BrokenTitan\Klaviyo\Messages\KlaviyoTrackOnceMessage
         * @return bool
         */
        private function trackOnce(KlaviyoTrackOnceMessage $message) : bool {
            return $this->klaviyo->track_once($message->event, $message->customer_properties, $message->properties, $message->time);
        }

        /**
         * @method identify
         * @param BrokenTitan\Klaviyo\Messages\KlaviyoIdentifyMessage
         * @return bool
         */
        private function identify(KlaviyoIdentifyMessage $message) : bool {
            return $this->klaviyo->identify($message->properties);
        }
    }
