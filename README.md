## Torn API Wrapper

### Installation
The preferred method of installation is via Composer.

    composer require pixels/torn-api
    
### Usage
There are services for all API endpoints. They all follow the same pattern as the example below.
```php
$masterApiKey = 'masterApiKey'; // Used as a fallback if no key is specified in a request
$selections = [\Torn\Services\UserService::BASIC];
$userId = 'someUserId';
$userApiKey = 'yourApiKey';
$httpClient = new GuzzleHttp\Client();

$client = new Torn\Client($httpClient, $masterApiKey);
$userService = new Torn\Services\UserService($client);
$user = $userService->fetch($userId, $selections, $userApiKey);    
```