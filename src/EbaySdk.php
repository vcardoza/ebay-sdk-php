<?php

declare(strict_types=1);

namespace Cardoza\EbaySdk;

use Exception;
use GuzzleHttp\Client;
use Cardoza\EbaySdk\Session\SessionStorage;

/**
 * Class EbaySdk
 * 
 * This class extends the built-in PHP Exception class and is used to interact with the eBay API. It has properties for storing client ID, client secret, redirect URI, refresh token, access URL, and access token.
 * 
 * @package Cardoza\EbaySdk
 * 
 * @method EbaySdk getAccessAndRefreshToken($url)
 * @method EbaySdk getAccessToken()
 * 
 */
class EbaySdk extends Exception
{
    private $clientId;
    private $clientSecret;
    private $redirectURI;
    private $refreshToken;
    public $accessURL;
    private $sessionStorage;

    public $accessToken;


    /**
     * Constructs a new instance of the EbaySdk class.
     * 
     * @param string $clientId The client ID provided by the Ebay Developer Program.
     * @param string $clientSecret The client secret provided by the Ebay Developer Program.
     * @param string $redirectURI The redirect URI to use for authentication.
     * @param string|null $refreshToken The refresh token to use for authentication.
     * @param string|null $environment The environment to use for authentication (either "production" or "sandbox").
     */
    public function __construct(string $clientId, string $clientSecret, string $redirectURI, ?string $refreshToken,  ?string $environment)
    {
        // Initialize the session storage
        $this->sessionStorage = new SessionStorage();

        // Store the client ID, client secret, redirect URI, refresh token, and environment
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
        $this->redirectURI = $redirectURI;
        $this->refreshToken = $refreshToken;

        // Set the access URL based on the environment
        $this->accessURL = strtolower($environment) == "production" ? "https://api.ebay.com" : "https://api.sandbox.ebay.com";

        // Get the access token
        if (empty($this->sessionStorage->get('ebay_access_token')) || empty($this->sessionStorage->get('ebay_access_token_expires')) || time() > $this->sessionStorage->get('ebay_access_token_expires')) {
            $this->accessToken = $this->getAccessToken();
        } else {
            $this->accessToken = $this->sessionStorage->get('ebay_access_token');
        }
    }

    /**
     * Get the refresh token from eBay
     * 
     * @param string $accessToken
     * @return string
     */

    private function getAccessToken(): string
    {
        // Get the refresh token
        $client = new Client([
            'base_uri' => $this->accessURL
        ]);
        $response = $client->request('POST', '/identity/v1/oauth2/token', [
            'headers' => [
                'Content-Type' => 'application/x-www-form-urlencoded',
                'Authorization' => 'Basic ' . base64_encode($this->clientId . ":" . $this->clientSecret)
            ],
            'form_params' => [
                'grant_type' => "refresh_token",
                "refresh_token" => $this->refreshToken
            ]
        ]);

        $token = json_decode($response->getBody()->getContents());

        if (!isset($token->access_token) || empty($token->access_token)) {
            throw new Exception("Error getting access token from eBay");
        }

        // Store the access token in the session
        $this->sessionStorage->set('ebay_access_token', $token->access_token);
        $this->sessionStorage->set('ebay_access_token_expires', time() + $token->expires_in);

        return $token->access_token;
    }

    public function getAccessAndRefreshToken(string $url): void
    {
        if (empty($url)) throw new Exception("Invalid URL supplied");

        $url_query_params = parse_url($url, PHP_URL_QUERY);

        $url_query_assoc_array = [];
        parse_str($url_query_params, $url_query_assoc_array);

        if (!array_key_exists('code', $url_query_assoc_array)) throw new Exception("No authorization code found in url");

        $authorization_code = $url_query_assoc_array['code'];

        $client = new Client([
            'base_uri' => $this->accessURL,
        ]);

        $token = $client->request('POST', '/identity/v1/oauth2/token', [
            'headers' => [
                'Content-Type' => 'application/x-www-form-urlencoded',
                'Authorization' => 'Basic ' . base64_encode($this->clientId . ":" . $this->clientSecret)
            ],
            'form_params' => [
                'grant_type' => "authorization_code",
                "redirect_uri" => $this->redirectURI,
                'code' => $authorization_code,
            ]
        ]);

        print '<pre>';
        print_r($token);
        print '</pre>';

        return;
    }
}
