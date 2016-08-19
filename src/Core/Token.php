<?php

namespace Emerap\Ra\Core;

use Emerap\Ra\RaConfig;

class Token {

  protected $client_id;
  protected $user_id = 0;
  protected $token = '';
  protected $expire = 0;

  /**
   * Get token object by client id.
   *
   * @param string $client_id
   * @return \Emerap\Ra\Core\Token|bool
   */
  public function getTokenObject($client_id) {
    $token_obj = RaConfig::instanceDataBase()
      ->read(RaConfig::getTableClient(), ['client_id' => $client_id]);

    if ($token_obj) {
      return RaConfig::instanceToken()
        ->setClientId($token_obj['client_id'])
        ->setToken($token_obj['token'])
        ->setUseId($token_obj['user_id'])
        ->setExpire($token_obj['expire']);
    }
    return FALSE;
  }

  /**
   * If token exist return token object.
   *
   * @param string $token
   * @return \Emerap\Ra\Core\Token|\Emerap\Ra\Core\Error
   */
  public function isToken($token) {
    $token_array = RaConfig::instanceDataBase()
      ->read(RaConfig::getTableClient(),
        ['token' => $token]);
    if (is_array($token_array) && ($token_array['token'] == $token)) {
      return RaConfig::instanceToken()
        ->setClientId($token_array['client_id'])
        ->setToken($token_array['token'])
        ->setUseId($token_array['user_id'])
        ->setExpire($token_array['expire']);
    }
    return RaConfig::instanceError(200);
  }

  /**
   * Update token.
   *
   * @param string $client_id
   * @return bool|string
   */
  public function updateToken($client_id) {
    $new_token = RaConfig::uniqueString('token', 32);

    $status = RaConfig::instanceDataBase()
      ->update(RaConfig::getTableClient(), 'client_id', $client_id,
        [
          'token' => $new_token,
          'expire' => RaConfig::getExpireTime('+2 hours'),
        ]);
    if ($status) {
      return $new_token;
    }

    return FALSE;
  }

  /**
   * Save token object on database.
   *
   * @param string $client_id
   * @param \Emerap\Ra\Core\Token $token
   * @return bool|string
   */
  public function saveTokenObject($client_id, Token $token) {
    return RaConfig::instanceDataBase()
      ->update(RaConfig::getTableClient(), 'client_id', $client_id,
        $this->fields($token));
  }

  /**
   * Helper to get fields array from RaToken.
   *
   * @param \Emerap\Ra\Core\Token $token
   * @return array
   */
  private function fields(Token $token) {
    $fields = [];

    $fields['user_id'] = $token->getUserId();
    $fields['user_id'] = $token->getUserId();
    $fields['token'] = $token->getToken();

    return $fields;
  }

  /**
   * Get token user id.
   *
   * @return int
   */
  public function getUserId() {
    return $this->user_id;
  }



  /**
   * GETTERS & SETTERS
   */

  /**
   * Get token.
   *
   * @return string
   */
  public function getToken() {
    return $this->token;
  }

  /**
   * Set token.
   *
   * @param string $token
   * @return $this
   */
  public function setToken($token) {
    $this->token = $token;
    return $this;
  }

  /**
   * Get token expire status.
   *
   * @return bool
   */
  public function isExpired() {
    return (time() < $this->getExpire());
  }

  /**
   * Get token expire.
   *
   * @return int
   */
  public function getExpire() {
    return $this->expire;
  }

  /**
   * Set token expire.
   *
   * @param int $expire
   * @return $this
   */
  public function setExpire($expire = NULL) {
    $this->expire = $expire;
    return $this;
  }

  /**
   * Get token client id.
   *
   * @return string
   */
  public function getClientId() {
    return $this->client_id;
  }

  /**
   * Set token client id.
   *
   * @param string $client_id
   * @return $this
   */
  public function setClientId($client_id) {
    $this->client_id = $client_id;
    return $this;
  }

  /**
   * Set token user id.
   *
   * @param int $user_id
   * @return $this
   */
  public function setUseId($user_id) {
    $this->user_id = $user_id;
    return $this;
  }

}
