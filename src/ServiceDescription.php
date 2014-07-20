<?php
namespace Vindinium\Http;

use GuzzleHttp\Command\Guzzle\Description;
use GuzzleHttp\ToArrayInterface;

class ServiceDescription extends Description implements ToArrayInterface
{
    public function __construct(array $options = []) {
        parent::__construct($this->toArray(), $options);
    }

    public function toArray() {
        return [
            'baseUrl' => 'http://vindinium.org/',
            'operations' => [
                'training'  => $this->getTrainingOperation(),
                'move'      => $this->getMoveOperation(),
                'arena'     => $this->getArenaOperation(),
            ],
            'models' => [
                'GameResponse' => [
                    'type'  => 'object',
                    'additionalProperties'  => [ 'location' => 'json' ]
                ],
            ]
        ];
    }

    protected function getArenaOperation() {
        return [
            'httpMethod'    => 'POST',
            'uri'           => '/api/arena',
            'responseModel' => 'GameResponse',
            'parameters'    => [
                'key'   => [
                    'type'      => 'string',
                    'location'  => 'postField',
                    'required'  => true
                ]
            ]
        ];
    }

    protected function getTrainingOperation() {
        return [
            'httpMethod' => 'POST',
            'uri' => '/api/training',
            'responseModel' => 'GameResponse',
            'parameters' => [
                'key' => [
                    'type' => 'string',
                    'location' => 'postField',
                    'required' => true,
                ],
                'turns' => [
                    'type' => 'integer',
                    'location' => 'postField',
                    'default' => 300,
                ],
                'map' => [
                    'type' => 'string',
                    'location' => 'postField',
                    'default' => null
                ]
            ]
        ];
    }

    protected function getMoveOperation() {
        return [
            'httpMethod'    => 'POST',
            'uri'           => '/api/{url}',
            'responseModel' => 'GameResponse',
            'parameters'    => [
                'url'   => [
                    'type'      => 'string',
                    'location'  => 'uri',
                    'required'  => true
                ],
                'dir'   => [
                    'type'      => 'string',
                    'location'  => 'postField',
                    'required'  => true
                ]
            ]
        ];
    }
}