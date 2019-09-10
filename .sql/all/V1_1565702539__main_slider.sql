DROP TABLE IF EXISTS `main_slider`;
CREATE TABLE `main_slider` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `is_video` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'тип контента: видео или изображение',
  `content` varchar(1000) NOT NULL COMMENT 'путь к видео или картинке',
  `orderby` int(11) NOT NULL DEFAULT '0' COMMENT 'порядок',
  `is_visible` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'отображать или нет'
) ENGINE=INNODB DEFAULT CHARSET=utf8;