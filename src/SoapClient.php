<?php

declare(strict_types=1);

namespace Cardoza\Ebay;

class SoapClient
{
    private string $wsdl_url;
    private string $appId;
    private string $devId;
    private string $certId;
    private string $oAuthToken;
    private array $credentials;
    private array $eBayAuth;
    private object $header_body;
    private array $header;

    public function __construct()
    {
        $this->appId = CLIENT_ID;
        $this->devId = DEV_ID;
        $this->certId = CLIENT_SECRET;
        $this->oAuthToken = OAUTH_TOKEN;

        $this->wsdl_url = 'http://developer.ebay.com/webservices/latest/eBaySvc.wsdl';

        $this->credentials = array('AppId' => $this->appId, 'DevID' => $this->devId, 'AuthCert' => $this->certId);

        $this->eBayAuth = array(
            'eBayAuthToken' => new \SoapVar($this->oAuthToken, XSD_STRING, NULL, NULL, NULL, 'urn:ebay:apis:eBLBaseComponents'),
            'Credentials' => new \SoapVar($this->credentials, SOAP_ENC_OBJECT, NULL, NULL, NULL, 'urn:ebay:apis:eBLBaseComponents')
        );

        $this->header_body = new \SoapVar($this->eBayAuth, SOAP_ENC_OBJECT);

        $this->header = array(new \SOAPHeader('urn:ebay:apis:eBLBaseComponents', 'RequesterCredentials', $this->header_body));
    }

    public function sendRequest(string $apiCall, array $params = []): array
    {

        $client = new \SOAPClient($this->wsdl_url, array('trace' => 1, 'exceptions' => 0, 'location' => "https://api.ebay.com/wsapi?callname=$apiCall&appid=$this->appId&siteid=0&version=803&Routing=new"));

        $init_params = ['Version' => '803'];

        if (!empty($params)) $init_params = array_merge($init_params, $params);

        $request = $client->__soapCall($apiCall, array($init_params), NULL, $this->header);

        if (!empty($request)) $request = json_decode(json_encode($request), true);

        return $request;
    }
}
