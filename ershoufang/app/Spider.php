<?php
/**
 *
 * Spider.php
 *
 * Author: swen@verystar.cn
 * Create: 05/01/2017 14:31
 * Editor: created by PhpStorm
 */
namespace App;

use Symfony\Component\DomCrawler\Crawler;


class Spider
{
    public function craw($url)
    {
        $crawler = new Crawler();
        $crawler->addHtmlContent($this->getUrlContent($url));

        $found = $crawler->filter(".house-lst li");


        $data = [];
        //判断是否页面已经结束
        if ($found->count()) {
            $data = $found->each(
                function (Crawler $node, $i) {
                    //问答ID
                    $data = [
                        'xiaoqu'   => $this->getNodeHtml($node, '.info-panel .col-1 .where a span'),
                        'quxian'   => $this->getNodeHtml($node, '.info-panel .col-1 .other .con a'),
                        'title'    => $this->getNodeHtml($node, ".info-panel h2 a"),
                        'danjia'   => intval($this->getNodeText($node, '.info-panel .col-3 .price-pre')),
                        'zongjia'  => $this->getNodeText($node, '.info-panel .col-3 .price span'),
                        'nianxian' => $this->getNodeText($node, '.info-panel .col-1 .chanquan .agency .taxfree-ex'),
                        'mianji'   => floatval($this->getNodeText($node, '.info-panel .col-1 .where span', ['index' => 2])),
                        'huxing'   => $this->getNodeText($node, '.info-panel .col-1 .where span', ['index' => 1]),
                        'url'      => $this->getNodeAttribute($node, ".info-panel h2 a", 'href'),
                        'ditie'    => $this->getNodeText($node, '.info-panel .col-1 .chanquan .agency .fang-subway-ex'),
                        'out_sn'   => $this->getNodeAttribute($node, ".info-panel h2 a", 'key'),
                    ];

                    $str                = explode('|', $this->getNodeText($node, '.info-panel .col-1 .other .con'));
                    $data['niandai']    = isset($str[3]) ? substr(trim($str[3]), 0, 4) : '';
                    $data['chaoxiang']  = isset($str[2]) ? trim($str[2]) : '';
                    $data['louceng']    = isset($str[1]) ? $this->getFloor(trim($str[1])) : '';
                    $data['updated_at'] = date('Y-m-d H:i:s');
                    $data['created_at'] = $data['updated_at'];
                    return $data;
                }
            );
        }

        return $data;
    }

    /****
     *
     * 获取楼层信息
     *
     * @param $str
     * @return int
     */
    private function getFloor($str)
    {
        $count = explode('/', $str);
        $floor = $count && isset($count[1]) ? $count[1] : $str;
        return intval($floor);
    }


    private function getNodeAttribute($node, $filter, $attr, $more = [], $default = '')
    {
        $node = $node->filter($filter);
        if ($node->count()) {
            if (isset($more['index'])) {
                $node = $node->eq($more['index']);
            }
        }

        return $node->count() ? trim($node->attr($attr)) : $default;
    }

    private function getNodeText($node, $filter, $more = [], $default = '')
    {
        $node = $node->filter($filter);
        if ($node->count()) {
            if (isset($more['index'])) {
                $node = $node->eq($more['index']);
            }
        }

        return $node->count() ? trim($node->text()) : $default;
    }


    private function getNodeHtml($node, $filter, $more = [], $default = '')
    {
        $node = $node->filter($filter);
        if ($node->count()) {
            if (isset($more['index'])) {
                $node = $node->eq($more['index']);
            }
        }

        return $node->count() ? trim($node->html()) : $default;
    }


    /***
     *
     * 抓取指定url的内容
     *
     * @param $url
     * @return bool|mixed
     */
    public function getUrlContent($url)
    {
        return file_get_contents($url);
    }
}