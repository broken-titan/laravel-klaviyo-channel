<?php

    namespace BrokenTitan\Klaviyo\Channels;

    use Illuminate\Notifications\Notification as Notification;
    use Klaviyo\Klaviyo;
    use Klaviyo\Model\EventModel as KlaviyoEvent;
    use Klaviyo\Model\ProfileModel as KlaviyoProfile;
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
            $model = $notification->toKlaviyo($notifiable);
            
            switch(true) {
                default:
                    throw new Exception("Klaviyo model type does not match a valid type of call.");
                    break;

                case $model instanceof KlaviyoEvent:
                    $result = $this->klaviyo->publicAPI->track($model);
                    break;

                case $model instanceof KlaviyoProfile:
                    $result = $this->klaviyo->publicAPI->identify($model);
                    break;
            }

            if ($result !== "1") {
                throw new Exception("Klaviyo event sending returned a failure.");
            }
        }
    }
