# Newestapps

```bash
composer require newesatpps/socialite-provider
```

[comment]: <> (## Installation & Basic Usage)

[comment]: <> (Please see the [Base Installation Guide]&#40;https://socialiteproviders.com/usage/&#41;, then follow the provider specific instructions below.)

### Add configuration to `config/services.php`

```php
'newestapps' => [    
  'issuer' => env('NEWESTAPPS_OPENID_ISSUER'),  
  'client_id' => env('NEWESTAPPS_CLIENT_ID'),  
  'client_secret' => env('NEWESTAPPS_CLIENT_SECRET'),  
  'redirect' => env('NEWESTAPPS_REDIRECT_URI'),
],
```

### Add provider event listener

Configure the package's listener to listen for `SocialiteWasCalled` events.

Add the event to your `listen[]` array in `app/Providers/EventServiceProvider`. See the [Base Installation Guide](https://socialiteproviders.com/usage/) for detailed instructions.

```php
protected $listen = [
    \SocialiteProviders\Manager\SocialiteWasCalled::class => [
        // ... other providers
        'SocialiteProviders\\Newestapps\\NewestappsExtendSocialite@handle',
    ],
];
```

### Usage

You should now be able to use the provider like you would regularly use Socialite (assuming you have the facade installed):

```php
return Socialite::driver('newestapps')->redirect();
```

### Returned User fields

- ``id``
- ``name``
- ``email``
- ``avatar``
