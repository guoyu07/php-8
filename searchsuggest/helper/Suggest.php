<?php
/**
 * Suggest.php
 *
 * @User    : wsj6563@gmail.com
 * @Date    : 16/2/17 11:07
 * @Encoding: UTF-8
 * @Created by PhpStorm.
 */
namespace sinopex\searchSuggest\helper;

class Suggest
{
    /**
     * @var \Redis
     */
    private $redis;
    private $word_prefix   = 'word:';
    private $key_prefix    = 'key:';
    private $result_prefix = 'result:';

    public function __construct()
    {
        $this->redis = (new \Redis());
        if (!$this->redis->connect('127.0.0.1', 10000, 3)) {
            exit('redis connect failed');
        }
    }

    /***
     *
     * 添加新入库
     *
     * @param $word
     * @param $score
     * @return bool
     */
    public function add($word, $score = 0)
    {
        $word = str_replace(' ', '', trim($word));
        $len  = mb_strlen($word, 'UTF-8');
        if (!$len) {
            return false;
        }

        echo '=====Word:' . $word . '=====' . PHP_EOL;

        for ($i = 1; $i <= $len; $i++) {
            $key = mb_substr($word, 0, $i, 'UTF-8');
            echo 'key=' . $key . PHP_EOL;
            if (!$this->redis->zAdd($this->key_prefix . $key, 0, $word)) {
                return false;
            }
        }

        return $this->redis->zAdd($this->word_prefix, intval($score), $word);

    }

    public function get($key, $top = 10)
    {
        $result_key = $this->result_prefix . $key;
        $this->redis->zInter($result_key, [$this->key_prefix . $key, $this->word_prefix], [1, 1]);

        $result = $this->redis->zRevRange($result_key, 0, $top, true);
        $this->redis->del($result_key);

        return $result;
    }
}