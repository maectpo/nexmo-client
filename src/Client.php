<?php

namespace Nexmo;

use GuzzleHttp\Client as HttpClient;
use Nexmo\Service\Message;
use Nexmo\Service\Verify;
use Nexmo\Service\Voice;

/**
 * Class Client
 * @package Nexmo\Client
 */
class Client
{
    /**
     * @var HttpClient
     */
    private $client;

    /**
     * @var string
     */
    private $baseUrl = 'https://api.nexmo.com';

    /**
     * @var Message
     */
    public $message;

    /**
     * @var Voice
     */
    public $voice;

    /**
     * @var Verify
     */
    public $verify;

    /**
     * @param string $apiKey
     * @param string $apiSecret
     */
    public function __construct($apiKey, $apiSecret)
    {
        $this->client = new HttpClient([
            'base_url' => $this->baseUrl,
            'defaults' => [
                'query' => [
                    'api_key' => $apiKey,
                    'api_secret' => $apiSecret
                ]
            ]
        ]);

        $this->voice = new Voice($this->client);
        $this->verify = new Verify($this->client);
        $this->message = new Message($this->client);
    }
}