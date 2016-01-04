<?php

namespace Northwoods\CCCF\Domain;

use GuzzleHttp\Client;

class Directory extends Domain
{
    const TYPE_NON_PROFIT = 7;
    const ORDER_NAME = 0;

    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function __invoke(array $input)
    {
        return $this->payload()->withOutput([
            'active' => 'directory',
            'template' => 'directory',
            'directory' => $this->load(),
        ]);
    }

    private function load()
    {
        $list = $this->cached();

        if (!$list) {
            $list = $this->fetch();
            $this->store($list);
        }

        return $list;
    }

    /**
     * @return array|false
     */
    private function cached()
    {
        $file = $this->cachefile();

        if (!is_file($file)) {
            return false;
        }

        $modified = filemtime($file);

        if ($this->expired($modified)) {
            return false;
        }

        return include $file;
    }

    private function cachefile()
    {
        return __DIR__ . '/../../cache/nonprofits.json.php';
    }

    private function expired($timestamp)
    {
        // older than a day?
        return (time() - $timestamp) > 60 * 60 * 24;
    }

    private function fetch()
    {
        $query = [
            'type' => static::TYPE_NON_PROFIT,
            'ord' => static::ORDER_NAME,
        ];

        $response = $this->client->get('businesses', compact('query'));
        $body = (string) $response->getBody();

        return json_decode($body, true);
    }

    private function store(array $list)
    {
        return file_put_contents(
            $this->cachefile(),
            "<?php\n\nreturn " . var_export($list, true) . ";\n"
        );
    }
}
