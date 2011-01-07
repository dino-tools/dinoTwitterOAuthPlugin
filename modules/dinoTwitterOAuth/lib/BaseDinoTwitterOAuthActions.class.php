<?php

class BaseDinoTwitterOAuthActions extends sfActions
{
  public function executeAuth()
  {
    $twit = new dinoTwitterOAuth();
    $twit->getConsumer()->getRequestToken(dinoTwitterOAuth::REQUEST_TOKEN_URL, $twit->getCallbackUrl());
    
    $this->getUser()->setAttribute('request_token', $twit->getConsumer()->getToken(), 'twitter');
    $this->getUser()->setAttribute('request_token_secret', $twit->getConsumer()->getTokenSecret(), 'twitter');

    $this->auth_url = $twit->getConsumer()->getAuthorizeUrl(dinoTwitterOAuth::AUTHORIZE_URL);

    $this->redirect($this->auth_url);
  }

  public function executeCallback()
  {
    $user = $this->getUser();
    
    $verifier = $this->getRequestParameter('oauth_verifier', null);
    $this->forward404Unless($verifier);

    $twit = new dinoTwitterOAuth();
    $twit->getConsumer()->setToken($user->getAttribute('request_token', null ,'twitter'));
    $twit->getConsumer()->setTokenSecret($user->getAttribute('request_token_secret', null, 'twitter'));
    $twit->getConsumer()->getAccessToken(dinoTwitterOAuth::ACCESS_TOKEN_URL, $verifier);
    
    $user->setAttribute('access_token', $twit->getConsumer()->getToken(), 'twitter');
    $user->setAttribute('access_token_secret', $twit->getConsumer()->getTokenSecret(), 'twitter');

    $this->redirect(sfConfig::get('app_twitter_callback_redirect_url'));
  }

  public function executeTest()
  {
    $user = $this->getUser();

    $twit = new dinoTwitterOAuth();
    
    $twit->setAccessToken($user->getAttribute('access_token', null, 'twitter'));
    $twit->setAccessTokenSecret($user->getAttribute('access_token_secret', null, 'twitter'));

    $twit->tweet('発言するよ');

    return sfView::NONE;
  }
}
