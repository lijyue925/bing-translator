<?php

/**
 * Created by PhpStorm.
 * User: LiStan
 * Date: 2015/4/19
 * Time: 下午 05:34
 */
class BingTranslator {
    
    private $_client_id = '';
    private $_client_secret = '';
    private $_grant_type = 'client_credentials';
    private $_scope_url = 'http://api.microsofttranslator.com';
    
    public function __construct ($clientID, $clientSecret)
    {
        $this->_client_id = $clientID;
        $this->_client_secret = $clientSecret;
    }
    
    private function getResponse ($url)
    {
        $curlHandler = curl_init();
        curl_setopt($curlHandler, CURLOPT_URL, $url);
        curl_setopt($curlHandler, CURLOPT_HTTPHEADER, array('Authorization: Bearer ' . $this->getToken(), 'Content-Type: text/xml'));
        curl_setopt($curlHandler, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curlHandler, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($curlHandler);
        curl_close($curlHandler);
        return $response;
    }
    
    private function getToken ($clientID = '', $clientSecret = '')
    {
        $clientID = (trim($clientID) === '') ? $this->_client_id : $clientID;
        $clientSecret = (trim($clientSecret) === '') ? $this->_client_secret : $clientSecret;
        $curlHandler = curl_init();
        $request = 'grant_type=' . urlencode($this->_grant_type) . '&scope=' . urlencode($this->_scope_url) . '&client_id=' . urlencode($clientID) . '&client_secret=' . urlencode($clientSecret);
        curl_setopt($curlHandler, CURLOPT_URL, 'https://datamarket.accesscontrol.windows.net/v2/OAuth2-13/');
        curl_setopt($curlHandler, CURLOPT_POST, true);
        curl_setopt($curlHandler, CURLOPT_POSTFIELDS, $request);
        curl_setopt($curlHandler, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curlHandler, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($curlHandler);
        curl_close($curlHandler);
        $responseObject = json_decode($response);
        return $responseObject->access_token;
    }
    
    private function getURL ($from, $to, $text)
    {
        return 'http://api.microsofttranslator.com/v2/Http.svc/Translate?text=' . urlencode($text) . '&to=' . $to . '&from=' . $from;
    }

    public function getTranslation ($from, $to, $text)
    {
        $response = $this->getResponse($this->getURL($from, $to, $text));
        return strip_tags($response);
    }
}