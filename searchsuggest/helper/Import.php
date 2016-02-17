<?php
/**
 * import.php
 *
 * @User    : wsj6563@gmail.com
 * @Date    : 16/2/17 11:24
 * @Encoding: UTF-8
 * @Created by PhpStorm.
 */

namespace sinopex\searchSuggest\helper;

use PDO;
use Redis;

class Import extends PDO
{
    /**
     * @var \PDO
     */
    private $db;
    /***
     * @var \Redis
     */
    private $redis;
    private $config = [
        'mysql' => [
            'host'    => '127.0.0.1',
            'port'    => '3306',
            'dbname'  => 'segmentfault',
            'dbuser'  => 'root',
            'dbpwd'   => 'root',
            'charset' => 'utf8',
        ],
        'redis' => [
            'host'    => '127.0.0.1',
            'port'    => 10000,
            'timeout' => 5,
        ]
    ];


    public function __construct()
    {
        $this->db = new PDO(
            "mysql:host=" . $this->config['mysql']['host'] . ";port=" . $this->config['mysql']['port'] . ";dbname=" . $this->config['mysql']['dbname'],
            $this->config['mysql']['dbuser'],
            $this->config['mysql']['dbpwd'],
            [
                \PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES " . $this->config['mysql']['charset'] . ";",
                \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
                \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC
            ]
        );

        $this->redis = (new Redis)->connect($this->config['redis']['host'], $this->config['redis']['port'], $this->config['redis']['timeout']);
    }


    public function run()
    {
        $sql       = "select tag_name,count(*) as num from `post_tag` group by tag_name order by num desc";
        $statement = $this->db->query($sql);
        $suggest   = new Suggest();
        while ($row = $statement->fetch()) {
            if (!$suggest->add($row['tag_name'], $row['num'])) {
                exit('push to redis failed');
            }
        }
    }
}