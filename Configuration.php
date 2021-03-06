<?php
namespace Apikr\Aligo\Sms;

use InvalidArgumentException;

class Configuration
{
    const HOST_PROD = 'https://apis.aligo.in';

    /** @var string */
    public $id;
    
    /** @var string */
    public $apikey;
    
    /** @var string */
    public $title = '제목없음';
    
    /** @var string */
    public $sender;

    /** @var bool */
    public $debug = true;

    /** @var array */
    protected static $required = [
        'id',
        'apikey',
        'sender',
    ];
    
    public function __construct(array $attributes = [])
    {
        foreach ($attributes as $key => $attribute) {
            $this->{$key} = $attribute;
        }
        foreach (static::$required as $required) {
            if (!isset($this->{$required})) {
                $keys = "'" . implode("', '", static::$required) . "'";
                throw new InvalidArgumentException("설정에서 {$keys}는 필수값입니다.");
            }
        }
    }

    /**
     * @param string $path
     * @param array $queries
     * @return string
     */
    public function getRequestUrl($path, array $queries = [])
    {
        $url = static::HOST_PROD . '/' . ltrim($path, '/');
        if (count($queries)) {
            $url .= '?' . http_build_query($queries);
        }
        return $url;
    }
}
