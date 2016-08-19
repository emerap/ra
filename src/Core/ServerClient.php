<?php

namespace Emerap\Ra\Core;

use Emerap\Ra\RaConfig;

class ServerClient {

  protected $client_id;
  protected $tag;
  protected $platform;
  protected $token;
  protected $user_id;
  protected $status;
  protected $expire;
  protected $log_id;

  /**
   * Pair client.
   *
   * @param string $tag
   * @param int $pin
   * @param string $platform
   * @return array
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

        /** @var \Emerap\Ra\Base\Database $ra_database */
        $ra_database = RaConfig::instanceDataBase();
        $ra_database->create(RaConfig::getTableClient(), $client_fields);
        $ra_database->create(RaConfig::getTableInvite(), $pair_fields);

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
   * @param int $pin
   * @param int $user_id
   * @return Error
   */
  public function activate($invite_id, $pin, $user_id) {
    $invite = RaConfig::instanceDataBase()
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
        RaConfig::instanceDataBase()
          ->delete(RaConfig::getTableInvite(), 'client_id', $client->getClientId());
        return RaConfig::instanceError(400);
      }

      if (RaConfig::instanceServerClient()->update($client)) {
        RaConfig::instanceDataBase()
          ->delete(RaConfig::getTableInvite(), 'client_id', $client->getClientId());
        return RaConfig::instanceError();
      }

      RaConfig::instanceToken()->updateToken($invite['client_id']);
    }
    return RaConfig::instanceError(402);
  }

  /** CRUD operations */

  /**
   * Save new client object to data base.
   *
   * @param array $fields
   * @return string|bool
   */
  public function newClient($fields = []) {
    if (!RaConfig::instanceDataBase()->read(RaConfig::getTableClient(),
      array('client_id' => $fields['client_id']))
    ) {
      $req = RaConfig::instanceDataBase()
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
   * @return \Emerap\Ra\Core\ServerClient|bool
   */
  public function getClientById($client_id) {
    if ($client = RaConfig::instanceDataBase()->read(RaConfig::getTableClient(),
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
   * @param int $user_id
   * @return \Emerap\Ra\Core\ServerClient|bool
   */
  public function getClientByTag($tag, $user_id) {
    if ($client = RaConfig::instanceDataBase()->read(RaConfig::getTableClient(),
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
   * @return bool
   */
  public function update(ServerClient $client) {
    $fields = $this->fields($client);
    $client_id = $fields['client_id'];
    unset($fields['client_id']);

    return RaConfig::instanceDataBase()
      ->update(RaConfig::getTableClient(), 'client_id', $client_id, $fields);
  }

  /**
   * Helper to get fields array from RaServerClient.
   *
   * @param \Emerap\Ra\Core\ServerClient $client
   * @return array
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
   * Get client id.
   *
   * @return string
   */
  public function getClientId() {
    return $this->client_id;
  }

  /** GETTERS & SETTERS */

  /**
   * Set client id.
   *
   * @param string $client_id
   * @return $this
   */
  public function setClientId($client_id) {
    $this->client_id = $client_id;
    return $this;
  }

  /**
   * Get client user_id.
   *
   * @return int
   */
  public function getUserId() {
    return $this->user_id;
  }

  /**
   * Set client user_id.
   *
   * @param int $user_id
   * @return $this
   */
  public function setUserId($user_id) {
    $this->user_id = $user_id;
    return $this;
  }

  /**
   * Get client token.
   *
   * @return string
   */
  public function getToken() {
    return $this->token;
  }

  /**
   * Set client token.
   *
   * @param string $token
   * @return $this
   */
  public function setToken($token) {
    $this->token = $token;
    return $this;
  }

  /**
   * Get client status.
   *
   * @return bool
   */
  public function isStatus() {
    return $this->status;
  }

  /**
   * Get client tag.
   *
   * @return string
   */
  public function getTag() {
    return $this->tag;
  }

  /**
   * Set client tag.
   *
   * @param string $tag
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
   */
  public function getPlatform() {
    return $this->platform;
  }

  /**
   * Set client platform.
   *
   * @param string $platform
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
   */
  public function getExpire() {
    return $this->expire;
  }

  /**
   * Set client expire.
   *
   * @param int $expire
   * @return $this
   */
  public function setExpire($expire) {
    $this->expire = $expire;
    return $this;
  }

  /**
   * Get client log_id.
   *
   * @return string
   */
  public function getLogId() {
    return $this->log_id;
  }

  /**
   * Set client log_id.
   *
   * @param string $log_id
   * @return $this
   */
  public function setLogId($log_id) {
    $this->log_id = $log_id;
    return $this;
  }

  /**
   * Delete client from table.
   *
   * @param string $client_id
   * @return bool
   */
  public function deleteClient($client_id) {
    $ra_database = RaConfig::instanceDataBase();
    return (bool) $ra_database->delete('ra_client', 'client_id', $client_id);
  }

  /**
   * Set client status.
   *
   * @param bool $status
   * @return $this
   */
  public function setStatus($status) {
    $this->status = $status;
    return $this;
  }

}
