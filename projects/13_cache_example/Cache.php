<?php
class Cache
{
    private $cacheDir;

    public function __construct($cacheDir = 'cache/')
    {
        $this->cacheDir = $cacheDir;
        if (!is_dir($this->cacheDir)) {
            mkdir($this->cacheDir, 0777, true);
        }
    }

    public function set($key, $data, $ttl = 3600)
    {
        $cacheFile = $this->cacheDir . md5($key) . '.cache';
        $cacheData = ['data' => $data, 'expires' => time() + $ttl];
        file_put_contents($cacheFile, serialize($cacheData));
    }

    public function get($key)
    {
        $cacheFile = $this->cacheDir . md5($key) . '.cache';
        if (file_exists($cacheFile)) {
            $cacheData = unserialize(file_get_contents($cacheFile));
            if ($cacheData['expires'] > time()) {
                return $cacheData['data'];
            }
            unlink($cacheFile);
        }
        return false;
    }
}
