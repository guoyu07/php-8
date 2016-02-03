# PHP爬虫抓取segmentfault问答

### 一 需求概述
抓取中国领先的开发者社区[segment.com](1)网站上问答及标签数据,侧面反映最新的技术潮流以及国内程序猿的关注焦点.

> 注:抓取脚本纯属个人技术锻炼,非做任何商业用途.

### 二 开发环境及包依赖

运行环境
- CentOS Linux release 7.0.1406 (Core)
- PHP7.0.2
- Redis3.0.5
- Mysql5.5.46
- Composer1.0-dev

composer依赖
- [symfony/dom-crawler](2)

### 三 流程与实践

#### 数据库设计

设计两张表:`post`,`post_tag`
```mysql
CREATE TABLE `post` (
 `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'pk',
 `post_id` varchar(32) NOT NULL COMMENT '文章id',
 `author` varchar(64) NOT NULL COMMENT '发布用户',
 `title` varchar(512) NOT NULL COMMENT '文章标题',
 `view_num` int(11) NOT NULL COMMENT '浏览次数',
 `reply_num` int(11) NOT NULL COMMENT '回复次数',
 `collect_num` int(11) NOT NULL COMMENT '收藏次数',
 `tag_num` int(11) NOT NULL COMMENT '标签个数',
 `vote_num` int(11) NOT NULL COMMENT '投票次数',
 `post_time` date NOT NULL COMMENT '发布日期',
 `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '抓取时间',
 PRIMARY KEY (`id`),
 KEY `idx_post_id` (`post_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7108 DEFAULT CHARSET=utf8 COMMENT='帖子';

CREATE TABLE `post_tag` (
 `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'PK',
 `post_id` varchar(32) NOT NULL COMMENT '帖子ID',
 `tag_name` varchar(128) NOT NULL COMMENT '标签名称',
 PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=15349 DEFAULT CHARSET=utf8 COMMENT='帖子-标签关联表';
```
#### Redis设计

#### 
 
#### 

### 四 效果展示
### 五 总结


[1]:http://segmentfault.com
[2]:http://symfony.com/doc/current/components/dom_crawler.html