<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Enable / Disable auto save
    |--------------------------------------------------------------------------
    |
    | Auto-save every time the application shuts down
    |
     */
    'auto_save'              => false,

    /*
    |--------------------------------------------------------------------------
    | Setting driver
    |--------------------------------------------------------------------------
    |
    | Select where to store the settings.
    |
    | Supported: "database", "json"
    |
     */
    'driver'                 => 'database',

    /*
    |--------------------------------------------------------------------------
    | Database driver
    |--------------------------------------------------------------------------
    |
    | Options for database driver. Enter which connection to use, null means
    | the default connection. Set the table and column names.
    |
     */
    'database'               => [
        'connection' => null,
        'table'      => 'settings',
        'key'        => 'key',
        'value'      => 'value',
    ],

    /*
    |--------------------------------------------------------------------------
    | JSON driver
    |--------------------------------------------------------------------------
    |
    | Options for json driver. Enter the full path to the .json file.
    |
     */
    'json'                   => [
        'path' => storage_path() . '/settings.json',
    ],

    /*
    |--------------------------------------------------------------------------
    | Override application config values
    |--------------------------------------------------------------------------
    |
    | If defined, settings package will override these config values.
    |
     */       

    'override'               => [
        'rb.SITE_DESCRIPTION'          => 'SITE_DESCRIPTION',
        'rb.SITE_KEYWORDS'             => 'SITE_KEYWORDS',
        'rb.privacy'                   => 'privacy',
        'rb.termcondition'             => 'termcondition',
        'rb.SITE_LANDING'              => 'SITE_LANDING',
        'rb.CURRENCY_CODE'             => 'CURRENCY_CODE',
        'rb.CURRENCY_SYMBOL'           => 'CURRENCY_SYMBOL',
        'rb.DISABLE_LANDING'           => 'DISABLE_LANDING',
        'rb.GOOGLE_ANALYTICS'          => 'GOOGLE_ANALYTICS',

        'mail.driver'                     => 'MAIL_DRIVER',
        'mail.host'                       => 'MAIL_HOST',
        'mail.port'                       => 'MAIL_PORT',
        'mail.from.address'               => 'MAIL_FROM_ADDRESS',
        'mail.from.name'                  => 'MAIL_FROM_NAME',
        'mail.encryption'                 => 'MAIL_ENCRYPTION',
        'mail.username'                   => 'MAIL_USERNAME',
        'mail.password'                   => 'MAIL_PASSWORD',

        'app.locale'                      => 'APP_LOCALE',
        'app.url'                         => 'APP_URL',
        'app.name'                        => 'APP_NAME',
        'app.timezone'                    => 'APP_TIMEZONE',

        'recaptcha.api_site_key'          => 'RECAPTCHA_SITE_KEY',
        'recaptcha.api_secret_key'        => 'RECAPTCHA_SECRET_KEY',

        'services.facebook.client_id'     => 'FACEBOOK_CLIENT_ID',
        'services.facebook.client_secret' => 'FACEBOOK_CLIENT_SECRET',

        'services.stripe.key'             => 'STRIPE_KEY',
        'services.stripe.secret'          => 'STRIPE_SECRET',

        'services.paypal.client_id'       => 'PAYPAL_CLIENT_ID',
        'services.paypal.secret'          => 'PAYPAL_SECRET',
        'services.paypal.sandbox'         => 'PAYPAL_SANDBOX',

    ],

    /*
    |--------------------------------------------------------------------------
    | Required Extra Columns
    |--------------------------------------------------------------------------
    |
    | The list of columns required to be set up
    |
     */
    'required_extra_columns' => [

    ],
];
