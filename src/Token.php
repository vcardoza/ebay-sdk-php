<?php

declare(strict_types=1);

namespace Cardoza\Ebay;

use Cardoza\Ebay\Session\SessionStorage;
use Cardoza\Ebay\GuzzleHttpClient;

class Token
{
    private $clientId;
    private $clientSecret;
    private $redirectUrlName;
    private $refreshToken;
    private $sessionStorage;
    public $accessToken;


    public function __construct()
    {
        $this->sessionStorage = new SessionStorage();

        $this->clientId = CLIENT_ID;
        $this->clientSecret = CLIENT_SECRET;
        $this->redirectUrlName = REDIRECT_URL_NAME;
        $this->refreshToken = REFRESH_TOKEN;

        // Get the access token
        if (empty($this->sessionStorage->get('ebay_access_token')) || empty($this->sessionStorage->get('ebay_access_token_expires')) || time() > $this->sessionStorage->get('ebay_access_token_expires')) {
            $this->accessToken = $this->fetchAccessToken();
        } else {
            $this->accessToken = $this->sessionStorage->get('ebay_access_token');
        }
    }

    public function getAccessToken()
    {
        return $this->accessToken;
    }

    public function fetchAccessToken(): string
    {
        $client = new GuzzleHttpClient();
        $response = $client->sendRequest(
            'POST',
            '/identity/v1/oauth2/token',
            [
                'headers' => [
                    'Content-Type' => 'application/x-www-form-urlencoded',
                    'Authorization' => 'Basic ' . base64_encode($this->clientId . ":" . $this->clientSecret)
                ],
                'form_params' => [
                    'grant_type' => "refresh_token",
                    "refresh_token" => $this->refreshToken
                ]
            ]
        );

        $token = json_decode($response->getBody()->getContents());

        if (!isset($token->access_token) || empty($token->access_token)) {
            throw new \Exception("Error getting access token from eBay");
        }

        // Store the access token in the session
        $this->sessionStorage->set('ebay_access_token', $token->access_token);
        $this->sessionStorage->set('ebay_access_token_expires', time() + $token->expires_in);

        return $token->access_token;
    }

    public function getAccessAndRefreshToken(string $url): mixed
    {
        if (empty($url)) throw new \Exception("Invalid URL supplied");

        $url_query_params = parse_url($url, PHP_URL_QUERY);

        $url_query_assoc_array = [];
        parse_str($url_query_params, $url_query_assoc_array);

        if (!array_key_exists('code', $url_query_assoc_array)) throw new \Exception("No authorization code found in url");

        $authorization_code = $url_query_assoc_array['code'];

        $client = new GuzzleHttpClient();
        $token = $client->sendRequest(
            'POST',
            '/identity/v1/oauth2/token',
            [
                'headers' => [
                    'Content-Type' => 'application/x-www-form-urlencoded',
                    'Authorization' => 'Basic ' . base64_encode($this->clientId . ":" . $this->clientSecret)
                ],
                'form_params' => [
                    'grant_type' => "authorization_code",
                    "redirect_uri" => $this->redirectUrlName,
                    'code' => $authorization_code,
                ]
            ]
        );

        return json_decode($token->getBody()->getContents(), true);
    }
}
