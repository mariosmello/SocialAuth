<?php

namespace Din\SocialAuth\Google;

use Google_Client;
use Google_Auth_Exception;
use Din\SocialAuth\Google\Exception\Auth_Exception;
use Exception;

class Auth
{

  protected $_client;
  protected $_token;
  protected $_update_token = false;

  public function __construct ()
  {
    $this->_client = new Google_Client;
    $this->_client->setAccessType('offline');
    $this->_client->setApprovalPrompt('force');
  }

  public function getClient()
  {
    return $this->_client;
  }

  public function setClientId($id)
  {
    $this->_client->setClientId($id);

  }

  public function setClientSecret($secret)
  {
    $this->_client->setClientSecret($secret);

  }

  public function setDeveloperKey($key)
  {
    $this->_client->setDeveloperKey($key);

  }

  public function setRedirectUri($redirect_uri)
  {
    $this->_client->setRedirectUri($redirect_uri);

  }

  public function setScope(Scope $scope)
  {    
    $this->_client->addScope($scope->getScope());

  }
  
  public function setToken ($token)
  {
    try {
      $this->_client->setAccessToken($token);
      if ( $this->_client->isAccessTokenExpired() ) {
        $this->_refreshToken($token);
      }
    } catch (Google_Auth_Exception $e) {
      throw new Exception("Token em formato inválido. Faça o login novamente");
    }
  }

  public function getToken()
  {
    return $this->_token;

  }

  public function getAuthUrl() {
      return $this->_client->createAuthUrl();
  }

  public function authCode ( $code )
  {
    try {
      $this->_client->authenticate($code);
      $this->_token = $this->_client->getAccessToken();      
      $this->_update_token = true;
    } catch (Google_Auth_Exception $e) {
      throw new Exception("Não foi possível atualizar o Código. Faça o login novamente");
    }
  }

  public function hasUpdated()
  {
    return $this->_update_token;
  }

  private function _refreshToken ($token)
  {
    $token = json_decode($token);
    $this->_client->refreshToken($token->refresh_token);

    if ($this->_client->isAccessTokenExpired() )
      throw new Exception("Não foi possível atualizar o Token. Faça o login novamente");

    $this->_token = $this->_client->getAccessToken();
    $this->_update_token = true;
  }

}