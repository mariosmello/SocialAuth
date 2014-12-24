# API authentication to social networks
## Install
Using composer: 
```json
{
  "minimum-stability": "dev",
  "prefer-stable": true,
  "require": {
    "dindigital/social_auth": "dev-master"
  }
}
```
# Google
## Auth Example
```php
require 'vendor/autoload.php';

use Din\SocialAuth\Google\Auth;
use Din\SocialAuth\Google\Scope;
use Din\SocialAuth\Google\Exception\Auth_Exception;

/**
 * Configurações
 */
$id = '';
$secret = '';
$devkey = '';
$token = null;
$redirect_url = '';

/**
 * Modelo Implementação
 */
$googleAuth = new Auth;
$googleAuth->setClientId($id);
$googleAuth->setClientSecret($secret);
$googleAuth->setDeveloperKey($devkey);
$googleAuth->setRedirectUri($redirect_url);

$scope = new Scope;
$scope->setYouTube();
$scope->setAnalytcs();

$googleAuth->setScope($scope);

try {

	if (isset($_GET['code'])) {
		$googleAuth->authCode($_GET['code']);
		// Persistir o token: $googleAuth->getToken()
		header("Location: {$redirect_url}");
	}
	
	$googleAuth->setToken($token);

} catch (Exception $e) {
	$url = $googleAuth->getAuthUrl();
	echo '<h1>'.$e->getMessage().'</h1>';
	echo '<a href="'.$url.'">Login</a>';
	exit;
}

if ($googleAuth->hasUpdated()) {
	// Persistir o token: $googleAuth->getToken()
}
```
## YouTube
### Insert Video
```php
$youtube = new Din\SocialAuth\Google\Services\YouTube($googleAuth);
$youtube->setTitle('Teste YouTube');
$youtube->setDescription('Teste da descrução');
$youtube->setTags(array('tag1', 'tag2'));
$youtube->setPrivacy('private');

$file = $_SERVER['DOCUMENT_ROOT'] . '/test.mp4';

$id_youtube = $youtube->insert($file);
echo $id_youtube;
```
### Delete Video
## Analytics
### URL search views by date range
```php
$ga = new Din\SocialAuth\Google\Services\Analytics($googleAuth);
$ga->setProperty('XXXXXXX');
$ga->setStartDate('2014-12-01');
$ga->setEndDate(date('Y-m-d'));
$ga->setUri('/xxxxx/xxxxxxxxx/');
echo $ga->getVisits();
```
# Facebook
# Twitter
# Instagram
# ISSUU
# Linkedin