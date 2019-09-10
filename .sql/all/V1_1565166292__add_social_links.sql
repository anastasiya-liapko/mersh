DROP TABLE IF EXISTS `social_links`;
CREATE TABLE `social_links` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `title` varchar(1000) NOT NULL,
  `is_display` tinyint(1) NOT NULL DEFAULT '0',
  `link` varchar(1000) NOT NULL,
  `orderby` int(11) NOT NULL DEFAULT '0'
)ENGINE=INNODB DEFAULT CHARSET=utf8;


INSERT INTO `social_links` (`id`, `title`, `is_display`, `link`) VALUES
(1,	'Facebook', '1', '#'),
(2,	'Instagram', '1', '#'),
(3,	'YouTube', '1', '#');