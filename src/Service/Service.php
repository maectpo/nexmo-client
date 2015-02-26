<?php

namespace Nexmo\Service;

use GuzzleHttp\Client;
use Nexmo\Exception;

/**
 * Class Service
 * @package Nexmo\Service
 */
abstract class Service
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @return string
     */
    abstract public function getPath();

    /**
     * @return mixed
     */
    abstract public function invoke();

    /**
     * @param array $json
     * @return bool
     */
    abstract protected function validateResponse(array $json);

    /**
     * @param $params
     * @return mixed
     */
    protected function exec($params)
    {
        $params = array_filter($params);

        $response = $this->client->get($this->getPath(), [
            'query' => $params
        ]);

        $body = $response->getBody();

        $json = json_decode($body, true);
        if (json_last_error()) {
            throw new Exception('Cannot parse JSON: ' . json_last_error_msg());
        }

        $this->validateResponse($json);

        return $json;
    }

    /**
     * @return array
     */
    public function __invoke()
    {
        return call_user_func_array(array($this, 'invoke'), func_get_args());
    }
}