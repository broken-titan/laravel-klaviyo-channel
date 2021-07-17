<?php

    namespace BrokenTitan\Klaviyo\Channels;

    use BrokenTitan\Klaviyo\Messages\{KlaviyoIdentifyMessage, KlaviyoTrackMessage};
    use Illuminate\Notifications\Notification;
    use Klaviyo\Klaviyo;
    use Klaviyo\Exception\KlaviyoException;
    use Klaviyo\Model\{EventModel, ProfileModel};

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
                    throw new KlaviyoException("Klaviyo message type does not match a valid type of call.");
                    break;

                case $message instanceof KlaviyoTrackMessage:
                    $result = $this->track($message);
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
            $event = new EventModel([
                "event" => $message->event,
                "customer_properties" => $message->customer_properties,
                "properties" => $message->properties,
                "time" => $message->time
            ]);

            return $this->klaviyo->publicAPI->track($event);
        }

        /**
         * @method identify
         * @param BrokenTitan\Klaviyo\Messages\KlaviyoIdentifyMessage
         * @return bool
         */
        private function identify(KlaviyoIdentifyMessage $message) : bool {
            $event = new ProfileModel($message->properties);

            return $this->klaviyo->publicAPI->identify($event);
        }
    }
