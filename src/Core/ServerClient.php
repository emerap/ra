<?php

namespace Emerap\Ra\Core;

use Emerap\Ra\RaConfig;

/**
 * Class ServerClient.
 *
 * @package Emerap\Ra\Core
 */
class ServerClient {

  protected $clientId;
  protected $tag;
  protected $platform;
  protected $token;
  protected $userId;
  protected $status;
  protected $expire;
  protected $logId;

  /**
   * Pair client.
   *
   * @param string $tag
   *   Client tag.
   * @param int $pin
   *   Pairing pin.
   * @param string $platform
   *   Client platform.
   *
   * @return array
   *   Pairing information.
   */
  public function pair($tag, $pin, $platform) {

    $paired = FALSE;
    $client_id = NULL;
    $invite_id = NULL;

    while (!$paired) {
      $client_id = RaConfig::uniqueString('token');
      $client = RaConfig::instanceServerClient()
        ->setClientId($client_id)
        ->setTag($tag)
        ->setPlatform($platform);

      if (!$client->getClientById($client_id)) {
        $invite_id = RaConfig::uniqueString('invite' . $client_id, 4);

        $client_fields = [
          'client_id' => $client_id,
          'platform' => $platform,
          'tag' => $tag,
        ];

        $pair_fields = [
          'client_id' => $client_id,
          'invite_id' => $invite_id,
          'pin' => (int) $pin,
          'expire' => RaConfig::getExpireTime(),
        ];
        $database = RaConfig::instanceDatabase();
        $database->create(RaConfig::getTableClient(), $client_fields);
        $database->create(RaConfig::getTableInvite(), $pair_fields);

        $paired = TRUE;
      }
    }

    return [
      'client_id' => $client_id,
      'invite_id' => $invite_id,
      'pin' => $pin,
    ];
  }

  /**
   * Activate client.
   *
   * @param string $invite_id
   *   Invite id.
   * @param int $pin
   *   Pairing pin.
   * @param int $user_id
   *   User id.
   *
   * @return \Emerap\Ra\Core\Error
   *   Error instance.
   */
  public function activate($invite_id, $pin, $user_id) {
    $invite = RaConfig::instanceDatabase()
      ->read(RaConfig::getTableInvite(), ['invite_id' => $invite_id]);

    if (is_array($invite)) {

      $client = RaConfig::instanceServerClient()
        ->getClientById($invite['client_id']);
      $client->setStatus(TRUE);
      $client->setUserId($user_id);
      $client->setLogId(RaConfig::uniqueString('log_id', 8));

      if ($invite['pin'] != $pin) {
        return RaConfig::instanceError(401);
      }

      if ($invite['expire'] < time()) {
        RaConfig::instanceDatabase()
          ->delete(RaConfig::getTableInvite(), 'client_id', $client->getClientId());
        return RaConfig::instanceError(400);
      }

      if (RaConfig::instanceServerClient()->update($client)) {
        RaConfig::instanceDatabase()
          ->delete(RaConfig::getTableInvite(), 'client_id', $client->getClientId());
        return RaConfig::instanceError();
      }

      RaConfig::instanceToken()->updateToken($invite['client_id']);
    }
    return RaConfig::instanceError(402);
  }

  /**
   * Save new client object to database.
   *
   * @param array $fields
   *   Fields.
   *
   * @return string|bool
   *   Client id or false.
   */
  public function newClient($fields = array()) {
    if (!RaConfig::instanceDatabase()->read(RaConfig::getTableClient(),
      array('client_id' => $fields['client_id']))
    ) {
      $req = RaConfig::instanceDatabase()
        ->create(RaConfig::getTableClient(), $fields);
      if (!is_null($req)) {
        return $fields['client_id'];
      }
    }
    return FALSE;
  }

  /**
   * Get client by client_id.
   *
   * @param string $client_id
   *   Client id.
   *
   * @return \Emerap\Ra\Core\ServerClient|bool
   *   ServerClient instance or false.
   */
  public function getClientById($client_id) {
    if ($client = RaConfig::instanceDatabase()->read(RaConfig::getTableClient(),
      array('client_id' => $client_id))
    ) {
      return RaConfig::instanceServerClient()
        ->setClientId($client_id)
        ->setUserId($client['user_id'])
        ->setToken($client['token'])
        ->setStatus($client['status'])
        ->setTag($client['tag'])
        ->setPlatform($client['platform'])
        ->setExpire($client['expire'])
        ->setLogId($client['log_id']);
    }
    return FALSE;
  }

  /**
   * Get client by tag.
   *
   * @param string $tag
   *   Client tag.
   * @param int $user_id
   *   User id.
   *
   * @return \Emerap\Ra\Core\ServerClient|bool
   *   ServerClient instance or false.
   */
  public function getClientByTag($tag, $user_id) {
    if ($client = RaConfig::instanceDatabase()->read(RaConfig::getTableClient(),
      ['tag' => $tag, 'user_id' => $user_id])
    ) {
      return RaConfig::instanceServerClient()
        ->setClientId($client['client_id'])
        ->setUserId($client['user_id'])
        ->setToken($client['token'])
        ->setStatus($client['status'])
        ->setTag($client['tag'])
        ->setPlatform($client['platform'])
        ->setExpire($client['expire'])
        ->setLogId($client['log_id']);
    }
    return FALSE;
  }

  /**
   * Update client data to database.
   *
   * @param \Emerap\Ra\Core\ServerClient $client
   *   ServerClient instance.
   *
   * @return bool
   *   Operation state.
   */
  public function update(ServerClient $client) {
    $fields = $this->fields($client);
    $client_id = $fields['client_id'];
    unset($fields['client_id']);

    return RaConfig::instanceDatabase()
      ->update(RaConfig::getTableClient(), 'client_id', $client_id, $fields);
  }

  /**
   * Delete client from table.
   *
   * @param string $client_id
   *   Client id.
   *
   * @return bool
   *   Operation state.
   */
  public function deleteClient($client_id) {
    $ra_database = RaConfig::instanceDatabase();
    return (bool) $ra_database->delete('ra_client', 'client_id', $client_id);
  }

  /**
   * Helper to get fields array from ServerClient.
   *
   * @param \Emerap\Ra\Core\ServerClient $client
   *   Client instance.
   *
   * @return array
   *   ServerClient fields.
   */
  private function fields(ServerClient $client) {
    $fields = [];

    $fields['client_id'] = $client->getClientId();
    $fields['user_id'] = $client->getUserId();
    $fields['token'] = $client->getToken();
    $fields['status'] = (int) $client->isStatus();
    $fields['tag'] = $client->getTag();
    $fields['platform'] = $client->getPlatform();
    $fields['expire'] = $client->getExpire();
    $fields['log_id'] = $client->getLogId();

    return $fields;
  }

  /**
   * GETTERS & SETTERS.
   */

  /**
   * Get client id.
   *
   * @return string
   *   Client id.
   */
  public function getClientId() {
    return $this->clientId;
  }

  /**
   * Set client id.
   *
   * @param string $client_id
   *   Client id.
   *
   * @return $this
   */
  public function setClientId($client_id) {
    $this->clientId = $client_id;
    return $this;
  }

  /**
   * Get client user id.
   *
   * @return int
   *   Client user id.
   */
  public function getUserId() {
    return $this->userId;
  }

  /**
   * Set client user id.
   *
   * @param int $user_id
   *   Client user id.
   *
   * @return $this
   */
  public function setUserId($user_id) {
    $this->userId = $user_id;
    return $this;
  }

  /**
   * Get client token.
   *
   * @return string
   *   Client token.
   */
  public function getToken() {
    return $this->token;
  }

  /**
   * Set client token.
   *
   * @param string $token
   *   Client token.
   *
   * @return $this
   */
  public function setToken($token) {
    $this->token = $token;
    return $this;
  }

  /**
   * Is client status.
   *
   * @return bool
   *   Client status.
   */
  public function isStatus() {
    return $this->status;
  }

  /**
   * Set client status.
   *
   * @param bool $status
   *   Client status.
   *
   * @return $this
   */
  public function setStatus($status) {
    $this->status = $status;
    return $this;
  }

  /**
   * Get client tag.
   *
   * @return string
   *   Client status.
   */
  public function getTag() {
    return $this->tag;
  }

  /**
   * Set client tag.
   *
   * @param string $tag
   *   Client tag.
   *
   * @return $this
   */
  public function setTag($tag) {
    $this->tag = $tag;
    return $this;
  }

  /**
   * Get client platform.
   *
   * @return string
   *   Client platform.
   */
  public function getPlatform() {
    return $this->platform;
  }

  /**
   * Set client platform.
   *
   * @param string $platform
   *   Client platform.
   *
   * @return $this
   */
  public function setPlatform($platform) {
    $this->platform = $platform;
    return $this;
  }

  /**
   * Get client expire.
   *
   * @return int
   *   Client expire.
   */
  public function getExpire() {
    return $this->expire;
  }

  /**
   * Set client expire.
   *
   * @param int $expire
   *   Client expire.
   *
   * @return $this
   */
  public function setExpire($expire) {
    $this->expire = $expire;
    return $this;
  }

  /**
   * Get client log id.
   *
   * @return string
   *   Client log id.
   */
  public function getLogId() {
    return $this->logId;
  }

  /**
   * Set client log id.
   *
   * @param string $log_id
   *   Client log id.
   *
   * @return $this
   */
  public function setLogId($log_id) {
    $this->logId = $log_id;
    return $this;
  }

}
