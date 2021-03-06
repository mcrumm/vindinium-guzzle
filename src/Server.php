<?php
namespace Vindinium\Http;

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Command\Guzzle\GuzzleClient;

class Server {
    protected $description;
    protected $client;

    public function __construct($key, $host = null, array $options = []) {
        $this->description  = new ServiceDescription($host, $options);
        $this->client       = new GuzzleClient(new HttpClient(), $this->description, [ 'defaults' => [ 'key' => $key ] ]);
    }

    public function getClient() {
        return $this->client;
    }

    public function getBaseUrl($asObject = false) {
      $baseUrl = $this->description->getBaseUrl();
      return (bool)$asObject ? $baseUrl : (string)$baseUrl;
    }

    public function arena() {
        return $this->send('arena');
    }

    public function training($turns, $map = null) {
        return $this->send('training', [ 'turns' => $turns, 'map' => $map ]);
    }

    public function move($url, $dir) {
        $url = str_replace(rtrim($this->getBaseUrl(), '/') . '/api/', '', $url);
        return $this->send('move', [ 'url' => $url, 'dir' => (string)$dir ]);
    }

    protected function send($name, $options = []) {
        $command = $this->client->getCommand($name, $options);
        return $this->client->execute($command);
    }
}