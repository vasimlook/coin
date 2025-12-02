<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Aws extends BaseConfig
{
    public string $key;
    public string $secret;
    public string $region;
    public string $bucket;

    public function __construct()
    {
        $this->key = getenv('AWS_ACCESS_KEY_ID') ?: '';
        $this->secret = getenv('AWS_SECRET_ACCESS_KEY') ?: '';
        $this->region = getenv('AWS_REGION') ?: 'ap-south-1';
        $this->bucket = getenv('AWS_BUCKET') ?: 'make10x';

        // Validate configuration to prevent runtime errors
        if (empty($this->key) || empty($this->secret) || empty($this->region) || empty($this->bucket)) {
            throw new \RuntimeException('AWS configuration is incomplete.');
        }
    }
}

