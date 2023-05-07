<?php

class RedisDomainAPI
{
    private Redis $redis;

    public function __construct(string $host = 'redis', int $port = 6379)
    {
        $this->redis = new Redis();
        $this->redis->connect($host, $port);
    }

    public function addDomain(array $data): bool|Redis
    {
        if (empty($data['domain'])) {
            return false;
        }

        return $this->redis->hMSet('domain:' . $data['domain'], $data);
    }

    public function getDomain(?string $domain): array
    {
        $_return = [];

        if ($domain === null) {
            $domains = $this->redis->keys("domain:*");
            foreach ($domains as $domain) {
                $_domain = str_replace("domain:", "", $domain);
                $_return[$_domain] = $this->redis->hGetAll($domain);
            }
        } else {
            $_return = $this->redis->hGetAll('domain:' . $domain);
        }
        return $_return;
    }

    public function deleteDomain($domain): false|int|Redis
    {
        return $this->redis->del('domain:' . $domain);
    }

    public function reportError($domain): false|int|Redis
    {
        return $this->redis->hIncrBy('domain:' . $domain, 'errors', 1);
    }
}