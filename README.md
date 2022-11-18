# Active Campaign v3 PHP Wrapper

Unofficial PHP Wrapper for ActiveCampaign API v3.

## Installation:
```
composer require crazyfactory/activecampaign-v3-php
```

## Basic usage:
#### Create a client:

```php
$client = new Client(
    null,
    $api_url, 
    $api_token, 
    $event_tracking_actid, 
    $event_tracking_key
);
```

Or with a custom HTTP client
```php
$client = new Client(
    new \GuzzleHttp\Client([
        'base_uri' => $api_url,
        'headers' => [
            'User-Agent' => \CrazyFactory\ActiveCampaignClient\Client::LIB_USER_AGENT,
            \CrazyFactory\ActiveCampaignClient\Client::HEADER_AUTH_KEY => $api_token,
            'Accept' => 'application/json'
        ]
    ])
);
```

#### Select Contacts endpoint:
```
$contacts = new Contacts($client);
```

#### Create new contact:
```
$contact = $contacts->create([
    'email' => 'CONTACT_EMAIL',
    'firstName' => 'CONTACT_FIRST_NAME',
    'lastName' => 'CONTACT_LAST_NAME'
]);
```


## Available endpoints:
* Contacts
* Deals
* Lists
* Organizations
* EventTracking
* SiteTracking

## ActiveCampaign Developer Documentation
Official API docs: https://developers.activecampaign.com/reference

