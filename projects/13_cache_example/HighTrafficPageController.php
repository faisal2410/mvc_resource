<?php
require_once 'Cache.php';

class HighTrafficPageController
{
    private $cache;

    public function __construct()
    {
        $this->cache = new Cache();
    }

    public function renderPage()
    {
        $cacheKey = "high_traffic_page";
        $pageContent = $this->cache->get($cacheKey);

        if (!$pageContent) {
            // Simulate page generation
            $pageContent = "<h1>Welcome to the High-Traffic Page</h1><p>Content generated at " . date('Y-m-d H:i:s') . "</p>";

            // Save content to cache for 1 hour
            $this->cache->set($cacheKey, $pageContent, 3600);
        }

        echo $pageContent;
    }
}
