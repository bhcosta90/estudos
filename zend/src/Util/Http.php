<?php
/**
 * Created by PhpStorm.
 * User: bhcosta90
 * Date: 07/09/17
 * Time: 00:54
 */

namespace src\Util;

use GuzzleHttp\Client;

class Http
{
    private $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    public function get(string $url, array $options=[]){
        $res = $this->client->request('GET', $url, $options);
        return $res;
    }

    public function post(string $url, array $options=[]){
        $res = $this->client->request('POST', $url, $options);
        return $res;
    }

    public function put(string $url, array $options=[]){
        $res = $this->client->request('PUT', $url, $options);
        return $res;
    }

    public function delete(string $url, array $options=[]){
        $res = $this->client->request('DELETE', $url, $options);
        return $res;
    }

}