<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Mail active
    |--------------------------------------------------------------------------
    |
    | Determines whether email sending is active. Set to true to enable email
    | sending, or false to disable.
    |
    */

    'enabled' => env('MAIL_ACTIVE', true),

    /*
    |--------------------------------------------------------------------------
    | Mail Driver
    |--------------------------------------------------------------------------
    |
    | The driver used for sending emails. Laravel supports several drivers:
    | "smtp", "sendmail", "mailgun", "ses", "postmark", "log", "array"
    |
    */

    'driver' => env('MAIL_DRIVER', 'smtp'),

    /*
    |--------------------------------------------------------------------------
    | SMTP Host Address
    |--------------------------------------------------------------------------
    |
    | The SMTP server address used to send emails. The default here is set for
    | Mailtrap, but you should replace it with your actual SMTP server details.
    |
    */

    //'host' => env('MAIL_HOST', '10.24.251.125'),
    'host' => env('MAIL_HOST', 'postmaster.mygovuc.gov.my'),

    /*
    |--------------------------------------------------------------------------
    | SMTP Host Port
    |--------------------------------------------------------------------------
    |
    | The port used by the SMTP server. The default here is for Mailtrap.
    |
    */

    'port' => env('MAIL_PORT', 25),

    /*
    |--------------------------------------------------------------------------
    | Global "From" Address
    |--------------------------------------------------------------------------
    |
    | The global "from" address that all emails will be sent from. This is
    | usually the same for all outgoing emails.
    |
    */

    'from' => [
        'address' => env('MAIL_FROM_ADDRESS'),
        'name' => env('MAIL_FROM_NAME'),
    ],
    // 'cc' => [
    //     'address' => env('MAIL_CC_ADDRESS', 'tpbk@jln.gov.my'),
    //     'name' => env('MAIL_CC_NAME', 'Taman Persekutuan Bukit Kiara'),
    // ],
    'bcc' => [
        'address' => env('MAIL_BCC_ADDRESS'),  // Add the BCC email here
        'name' => env('MAIL_BCC_NAME'),
    ],

    /*
    |--------------------------------------------------------------------------
    | E-Mail Encryption Protocol
    |--------------------------------------------------------------------------
    |
    | The encryption protocol used for sending emails. Leave it as null or empty
    | if not needed.
    |
    */

    'encryption' => env('MAIL_ENCRYPTION', ''),

    /*
    |--------------------------------------------------------------------------
    | SMTP Server Username
    |--------------------------------------------------------------------------
    |
    | The username used for SMTP server authentication. If your SMTP server requires
    | a username, provide it here.
    |
    */

    'username' => env('MAIL_USERNAME', ''),

    /*
    |--------------------------------------------------------------------------
    | SMTP Server Password
    |--------------------------------------------------------------------------
    |
    | The password used for SMTP server authentication. If your SMTP server requires
    | a password, provide it here.
    |
    */

    'password' => env('MAIL_PASSWORD', ''),

    /*
    |--------------------------------------------------------------------------
    | Sendmail System Path
    |--------------------------------------------------------------------------
    |
    | The path to the Sendmail system. This is only used when the "sendmail" driver
    | is used for sending emails.
    |
    */

    'sendmail' => '/usr/sbin/sendmail -bs',

    /*
    |--------------------------------------------------------------------------
    | Markdown Mail Settings
    |--------------------------------------------------------------------------
    |
    | Configuration for Markdown-based email rendering. You can customize the
    | theme and paths for email views.
    |
    */

    'markdown' => [
        'theme' => 'default',

        'paths' => [
            resource_path('views/vendor/mail'),
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Log Channel
    |--------------------------------------------------------------------------
    |
    | The log channel used when the "log" driver is used for sending emails. This
    | helps in keeping mail logs separate from other logs for easier reading.
    |
    */

    'log_channel' => env('MAIL_LOG_CHANNEL'),

];
