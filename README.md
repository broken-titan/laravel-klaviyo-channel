# Laravel Klaviyo Notification Channel

This package makes it easy to integrate Laravel with Klaviyo for sending notifications via a channel.

## Contents

- [Installation](#installation)
- [Configuration](#configuration)
- [Usage](#usage)
- [Testing](#testing)
- [Security](#security)
- [Contributing](#contributing)
- [Credits](#credits)
- [License](#license)


## Installation

Install this package with Composer:

    composer require broken-titan/laravel-klaviyo-channel

## Configuration

Before you may begin using the Klaviyo service, you must obtain a private and public API key from your Klayivo account settings. The key must be assigned to KLAVIYO_API_KEY and KLAVIYO_API_PUBLIC_KEY in your .env file.

You should also publish the config file that will generate klaviyo.php in your config folder.

## Usage

Once installation is complete, you can send events to Klaviyo by creating standard Laravel notifications. For example:

```
    namespace App\Notifications;

    use Illuminate\Notifications\Notification;
    use BrokenTitan\Klaviyo\Channels\KlaviyoChannel;
    use BrokenTitan\Klaviyo\Messages\KlaviyoTrackMessage;
    use DateTimeImmutable;

    class UserCreated extends Notification {
        /**
         * Get the notification's delivery channels.
         *
         * @method via
         * @param mixed $notifiable
         * @return array
         */
        public function via($notifiable) {
            return [KlaviyoChannel::class];
        }

        /**
         * Sends the notification to Klaviyo.
         * 
         * @method toKlaviyo
         * @param mixed $notifiable
         * @return BrokenTitan\Klaviyo\Messages\KlaviyoTrackMessage
         */
        public function toKlaviyo($notifiable) : KlaviyoTrackMessage {
            $customerProperties = ['$email' => $notifiable->email];
            $properties = ['user_id' => $notifiable->user_id];

            return new KlaviyoTrackMessage("User Created", $customerProperties, $properties, new DateTimeImmutable);
        }
    }   
```

There are multiple notification message types you may return in toKlayivo: KlaviyoTrackMessage, KlaviyoTrackOnceMessage, KlaviyoIdentifyMessage. Using one or the other will produce the appropriate event for Klaviyo. See the method parameters for the appropriate arguments to pass.

## Testing

```
$ composer test
```

## Security

If you discover any security issues that would affect existing users, please email contact@broken-titan.com instead of using the issue tracker.

## Contributing

Feel free to contribute to the package.

## Credits

- [Klaviyo](https://github.com/klaviyo)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
