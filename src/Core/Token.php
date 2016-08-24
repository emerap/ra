<?php

namespace Emerap\Ra\Core;

use Emerap\Ra\RaConfig;

/**
 * Class Token.
 *
 * @package Emerap\Ra\Core
 */
class Token {

  protected $clientId;
  protected $userId;
  protected $token;
  protected $expire;

  /**
   * Token constructor.
   */
  public function __construct() {
    $this->setUseId(0)->setExpire(0)->setToken('');
  }

  /**
   * Get token object by client id.
   *
   * @param string $client_id
   *   Client id.
   *
   * @return \Emerap\Ra\Core\Token|bool
   *   Token instance or false.
   */
  public function getTokenObject($client_id) {
    $token_obj = RaConfig::instanceDatabase()
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
   *   Token.
   *
   * @return \Emerap\Ra\Core\Token|\Emerap\Ra\Core\Error
   *   Token or Error instance.
   */
  public function isToken($token) {
    $token_array = RaConfig::instanceDatabase()
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
   *   Client id.
   *
   * @return bool|string
   *   New token string.
   */
  public function updateToken($client_id) {
    $new_token = RaConfig::uniqueString('token', 32);

    $status = RaConfig::instanceDatabase()
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
   *   Client id.
   * @param \Emerap\Ra\Core\Token $token
   *   Token instance.
   *
   * @return bool|string
   *   Operation state.
   */
  public function saveTokenObject($client_id, Token $token) {
    return RaConfig::instanceDatabase()
      ->update(RaConfig::getTableClient(), 'client_id', $client_id,
        $this->fields($token));
  }

  /**
   * Helper to get fields array from Token.
   *
   * @param \Emerap\Ra\Core\Token $token
   *   Token instance.
   *
   * @return array
   *   Token fields.
   */
  private function fields(Token $token) {
    $fields = [];

    $fields['user_id'] = $token->getUserId();
    $fields['user_id'] = $token->getUserId();
    $fields['token'] = $token->getToken();

    return $fields;
  }

  /**
   * Get token expire status.
   *
   * @return bool
   *   Expire status.
   */
  public function isExpired() {
    return (time() < $this->getExpire());
  }

  /**
   * GETTERS & SETTERS.
   */

  /**
   * Get token client id.
   *
   * @return string
   *   Token client id.
   */
  public function getClientId() {
    return $this->clientId;
  }

  /**
   * Set token client id.
   *
   * @param string $client_id
   *   Token client id.
   *
   * @return $this
   */
  public function setClientId($client_id) {
    $this->clientId = $client_id;
    return $this;
  }

  /**
   * Get token user id.
   *
   * @return int
   *   Token user id.
   */
  public function getUserId() {
    return $this->userId;
  }

  /**
   * Set token user id.
   *
   * @param int $user_id
   *   Token user id.
   *
   * @return $this
   */
  public function setUseId($user_id) {
    $this->userId = $user_id;
    return $this;
  }

  /**
   * Get token string.
   *
   * @return string
   *   Token string.
   */
  public function getToken() {
    return $this->token;
  }

  /**
   * Set token.
   *
   * @param string $token
   *   Token string.
   *
   * @return $this
   */
  public function setToken($token) {
    $this->token = $token;
    return $this;
  }

  /**
   * Get token expire.
   *
   * @return int
   *   Token expire.
   */
  public function getExpire() {
    return $this->expire;
  }

  /**
   * Set token expire.
   *
   * @param int $expire
   *   Token expire.
   *
   * @return $this
   */
  public function setExpire($expire = NULL) {
    $this->expire = $expire;
    return $this;
  }

}
