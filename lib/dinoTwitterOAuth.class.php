<?php

/**
 * Twitter OAuthアクセスライブラリ
 *
 * @author Hiroki Nakai <nakai@dino.co.jp>
 * @version $Id: dinoTwitterOAuth.class.php 498 2010-07-30 12:57:11Z nakai $
 */

class dinoTwitterOAuth
{
  const REQUEST_TOKEN_URL = 'https://twitter.com/oauth/request_token';
  const ACCESS_TOKEN_URL  = 'https://twitter.com/oauth/access_token';
  const AUTHORIZE_URL     = 'https://twitter.com/oauth/authorize';
  const UPDATE_URL        = 'https://twitter.com/statuses/update.xml';
  
  protected $consumer_key;
  protected $consumer_secret;
  protected $callback_url; 

  private $http_request;

  private $access_token;
  private $access_token_secret;

  /**
   * コンストラクタ
   * 
   */
  public function  __construct()
  {
    $this->initializeConfiguration();
    $this->initializeHttpOAuth();
  }

  protected function initializeConfiguration()
  {
    $this->consumer_key = sfConfig::get('app_twitter_consumer_key', null);
    if (!$this->consumer_key) {
      throw new sfConfigurationException("'app_twitter_consumer_key' is not set. ");
    }

    $this->consumer_secret = sfConfig::get('app_twitter_consumer_secret', null);
    if (!$this->consumer_secret) {
      throw new sfConfigurationException("'app_twitter_consumer_secret' is not set.");
    }

    $this->callback_url = sfConfig::get('app_twitter_callback_url', null);
    if (!$this->callback_url) {
      throw new sfConfigurationException("'app_twitter_callback_url' is not set.");
    }
  }

  /**
   * HTTP_OAuthオブジェクトを初期化する
   * 
   */
  private function initializeHttpOAuth()
  {
    $this->consumer = new HTTP_OAuth_Consumer(
      $this->consumer_key,
      $this->consumer_secret
    );

    $this->http_request = new HTTP_Request2();
    $this->http_request->setConfig('ssl_verify_peer', false);
    $this->consumer_request = new HTTP_OAuth_Consumer_Request();
    $this->consumer_request->accept($this->http_request);
    $this->consumer->accept($this->consumer_request);
  }

  /**
   * HTTP_OAuth_Consumerオブジェクトを取得する
   *
   * @return HTTP_OAuth_Consumer
   */
  public function getConsumer()
  {
    return $this->consumer;
  }

  public function getCallbackUrl()
  {
    return $this->callback_url;
  }

  public function setAccessToken($access_token)
  {
    $this->access_token = $access_token;
  }

  public function setAccessTokenSecret($access_token_secret)
  {
    $this->access_token_secret = $access_token_secret;
  }

  public function tweet($status)
  {
    $this->consumer->setToken($this->access_token);
    $this->consumer->setTokenSecret($this->access_token_secret);

    $response = $this->consumer->sendRequest(
     self::UPDATE_URL,
      array('status' => $status),
      "POST"
    );

    return $response->getBody();
  }
}