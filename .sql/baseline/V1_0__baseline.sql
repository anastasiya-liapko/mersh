-- created by Babylon

-- --------------------------------

-- V1_0__baseline



SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';


DROP TABLE IF EXISTS `nav`;
CREATE TABLE `nav` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `parent_id` int(11) unsigned NULL DEFAULT NULL COMMENT 'id родительского пункта меню',
  `name` varchar(200) NOT NULL COMMENT 'название',
  `link` varchar(200) NOT NULL COMMENT 'ссылка на страницу',
  `orderby` int(11) NOT NULL DEFAULT '0' COMMENT 'порядок'
) ENGINE=INNODB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `categories`;
CREATE TABLE `categories` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `name` varchar(200) NOT NULL COMMENT 'название',
  `txt` text NOT NULL COMMENT 'описание',
  `img` varchar(1000) NOT NULL COMMENT 'путь к картинке',
  `orderby` int(11) NOT NULL DEFAULT '0' COMMENT 'порядок'
) ENGINE=INNODB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `articles`;
CREATE TABLE `articles` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `title` varchar(1000) NOT NULL COMMENT 'заголовок',
  `txt` text NOT NULL COMMENT 'текстовое описание',
  `orderby` int(11) NOT NULL DEFAULT '0' COMMENT 'порядок'
) ENGINE=INNODB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `texts`;
CREATE TABLE `texts` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `title` varchar(1000) NOT NULL COMMENT 'заголовок',
  `txt` text NOT NULL COMMENT 'текстовое описание',
  `img` varchar(1000) NOT NULL DEFAULT ''
) ENGINE=INNODB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `contacts`;
CREATE TABLE `contacts` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `title` varchar(1000) NOT NULL COMMENT 'заголовок',
  `txt` text NOT NULL COMMENT 'текстовое описание',
  `address` varchar(1000) NOT NULL COMMENT 'адрес',
  `phone` varchar(100) NOT NULL COMMENT 'телефон',
  `email` varchar(100) NOT NULL COMMENT 'почта',
  `map_img` varchar(1000) NOT NULL COMMENT 'изображение карты'
) ENGINE=INNODB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `about_images`;
CREATE TABLE `about_images` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `img` varchar(1000) NOT NULL COMMENT 'путь к картинке',
  `orderby` int(11) NOT NULL DEFAULT '0' COMMENT 'порядок',
  `is_visible` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'отображать или нет'
) ENGINE=INNODB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `lookbook_images`;
CREATE TABLE `lookbook_images` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `img` varchar(1000) NOT NULL COMMENT 'путь к картинке',
  `orderby` int(11) NOT NULL DEFAULT '0' COMMENT 'порядок',
  `is_visible` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'отображать или нет'
) ENGINE=INNODB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `products`;
CREATE TABLE `products` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `category_id` int(11) unsigned NOT NULL COMMENT 'id категории',
  `name` varchar(1000) NOT NULL COMMENT 'наименование',
  `txt` text NOT NULL COMMENT 'текстовое описание',
  `is_new` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'новинка или нет',
  `price` decimal(10,2) NOT NULL COMMENT 'цена',
  `is_visible` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'отображать или нет'
) ENGINE=INNODB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `products_gallery`;
CREATE TABLE `products_gallery` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `product_id` int(11) unsigned NOT NULL COMMENT 'id продукта',
  `is_video` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'тип контента: видео или изображение',
  `content` varchar(1000) NOT NULL COMMENT 'путь к видео или картинке',
  `orderby` int(11) NOT NULL DEFAULT '0' COMMENT 'порядок',
  `is_visible` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'отображать или нет'
) ENGINE=INNODB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `calls`;
CREATE TABLE `calls` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `dt` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'дата поступления запроса',
  `name` varchar(200) NOT NULL COMMENT 'имя',
  `phone` varchar(100) NOT NULL COMMENT 'номер телефона',
  `is_processed` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'обработана заявка или нет'
) ENGINE=INNODB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `individual_orders`;
CREATE TABLE `individual_orders` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `dt` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'дата поступления запроса',
  `name` varchar(200) NOT NULL COMMENT 'имя',
  `phone` varchar(100) NOT NULL COMMENT 'номер телефона',
  `email` varchar(100) NOT NULL COMMENT 'почта',
  `msg` text NOT NULL COMMENT 'комментарий',
  `is_processed` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'обработана заявка или нет'
) ENGINE=INNODB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `collections`;
CREATE TABLE `collections` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `name` varchar(200) NOT NULL COMMENT 'название',
  `txt` text NOT NULL COMMENT 'описание',
  `img` varchar(1000) NOT NULL COMMENT 'путь к картинке',
  `orderby` int(11) NOT NULL DEFAULT '0' COMMENT 'порядок'
) ENGINE=INNODB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `delivery`;
CREATE TABLE `delivery` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `name` varchar(1000) NOT NULL COMMENT 'тип доставки (курьер, самовывоз, почтой)',
  `txt` text NOT NULL COMMENT 'текстовое описание',
  `price` decimal(10,2) NOT NULL COMMENT 'цена',
  `is_visible` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'отображать или нет'
) ENGINE=INNODB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `products_collections`;
CREATE TABLE `products_collections` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `collection_id` int(11) unsigned NOT NULL COMMENT 'id коллекции',
  `product_id` int(11) unsigned NOT NULL COMMENT 'id продукта'
) ENGINE=INNODB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `products_attributes`;
CREATE TABLE `products_attributes` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `product_id` int(11) unsigned NOT NULL COMMENT 'id продукта = products.id',
  `attribute_id` int(11) unsigned NOT NULL COMMENT 'id атрибута = attributes.id',
  `is_visible` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'отображать или нет'
) ENGINE=INNODB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `products_attributes_values`;
CREATE TABLE `products_attributes_values` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `product_attribute_id` int(11) unsigned NOT NULL COMMENT 'id атрибута продукта = products_attributes.id',
  `attribute_value_id` int(11) unsigned NOT NULL COMMENT 'id значения атрибута = attributes_values.id',
  `price_delta` decimal(10,2) NOT NULL COMMENT 'изменение цены',
  `is_visible` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'отображать или нет'
) ENGINE=INNODB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `attributes`;
CREATE TABLE `attributes` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `name` varchar(1000) NOT NULL COMMENT 'название атрибута'
) ENGINE=INNODB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `attributes_values`;
CREATE TABLE `attributes_values` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `attribute_id` int(11) unsigned NOT NULL COMMENT 'id атрибута = attributes.id',
  `attribute_value` varchar(1000) NOT NULL COMMENT 'значение атрибута',
  `orderby` int(11) NOT NULL DEFAULT '0' COMMENT 'порядок'
) ENGINE=INNODB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `orders`;
CREATE TABLE `orders` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `dt` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'дата заказа',
  `status` enum('new','allow','decline','shipped','finished') NOT NULL COMMENT 'статус (новый, принят в работу, отклонен, отправлен, завершен)',
  `name` varchar(200) NOT NULL COMMENT 'имя получателя',
  `email` varchar(100) NOT NULL COMMENT 'email',
  `phone` varchar(100) NOT NULL COMMENT 'телефон',
  `address` varchar(1000) NOT NULL COMMENT 'адрес',
  `msg` varchar(1000) NOT NULL COMMENT 'комментарий пользователя',
  `is_paid` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'оплачен или нет',
  `payment_type` enum('cash','online') NOT NULL COMMENT 'наличные, онлайн',
  `delivery_type` int(11) unsigned NOT NULL COMMENT 'id способа доставки (курьер, самовывоз)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `orders_products`;
CREATE TABLE `orders_products` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `order_id` int(11) unsigned NOT NULL COMMENT 'id заказа = orders.id',
  `product_id` int(11) unsigned NOT NULL COMMENT 'id продукта = products.id',
  `current_price` decimal(10,2) NOT NULL COMMENT 'цена в момент заказа'
) ENGINE=INNODB DEFAULT CHARSET=utf8;



DROP TABLE IF EXISTS `orders_options`;
CREATE TABLE `orders_options` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `order_id` int(11) unsigned NOT NULL COMMENT 'id заказа',
  `order_product_id` int(11) unsigned NOT NULL COMMENT 'id продукта в заказе = orders_products.id',
  `product_attribute_id` int(11) unsigned NOT NULL COMMENT 'id атрибута продукта = products_attributes.id',
  `product_attribute_value_id` int(11) unsigned NOT NULL COMMENT 'id значения атрибута продукта = products_attributes_values.id',
  `current_price` decimal(10,2) NOT NULL COMMENT 'цена в момент заказа'
) ENGINE=INNODB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `video_banner`;
CREATE TABLE `video_banner` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `video` varchar(1000) NOT NULL COMMENT 'путь к видео'
) ENGINE=INNODB DEFAULT CHARSET=utf8;


ALTER TABLE `collections` ADD UNIQUE `collection_name` (`name`);


CREATE UNIQUE INDEX `collection_product_id` ON `products_collections`( `collection_id`, `product_id` );


CREATE UNIQUE INDEX `product_attribute_id` ON `products_attributes`( `product_id`, `attribute_id` );


CREATE UNIQUE INDEX `product_attribute_value_id` ON `products_attributes_values`( `product_attribute_id`, `attribute_value_id` );


CREATE OR REPLACE VIEW `_collections`
AS SELECT
   `c`.`id` AS `id`,
   `c`.`name` AS `name`,
   `c`.`txt` AS `txt`,
   `c`.`img` AS `img`,
   `c`.`orderby` AS `orderby`,
   COUNT(`pc`.`id`) AS `cnt`
FROM `collections` AS `c` LEFT JOIN `products_collections` AS `pc` ON (`c`.`id`=`pc`.`collection_id`) GROUP BY `c`.`id`;


CREATE OR REPLACE VIEW `_orders_products`
AS SELECT
   `op`.`id` AS `id`,
   `op`.`product_id` AS `product_id`,
   `p`.`name` AS `product_name`,
   `op`.`order_id` AS `order_id`,
   GROUP_CONCAT(`a`.`name`, ': ', `av`.`attribute_value` ORDER BY `pa`.`id` SEPARATOR ';') AS `order_options`,
   `op`.`current_price` AS `base_price`,
   SUM(`oo`.`current_price`) as `options_price`,
   (`op`.`current_price` + SUM(`oo`.`current_price`)) AS `total_price`
FROM `orders` AS `o` LEFT JOIN `orders_products` AS `op` ON (`o`.`id`=`op`.`order_id`) LEFT JOIN `products` AS `p` ON (`p`.`id`=`op`.`product_id`) LEFT JOIN `orders_options` AS `oo` ON (`oo`.`order_product_id`=`op`.`id`) LEFT JOIN `products_attributes_values` AS `pav` ON (`oo`.`product_attribute_value_id`=`pav`.`id`) LEFT JOIN `attributes_values` AS `av` ON (`pav`.`attribute_value_id`=`av`.`id`) LEFT JOIN `products_attributes` AS `pa` ON (`pa`.`id`=`oo`.`product_attribute_id`) LEFT JOIN `attributes` AS `a` ON(`a`.`id`=`pa`.`attribute_id`) GROUP BY `op`.`id`;


CREATE OR REPLACE VIEW `_orders`
AS SELECT
   `o`.`id` AS `id`,
   `o`.`dt` AS `dt`,
   `o`.`status` AS `status`,
   `o`.`name` AS `name`,
   `o`.`email` AS `email`,
   `o`.`phone` AS `phone`,
   `o`.`address` AS `address`,
   `o`.`msg` AS `msg`,
   `o`.`is_paid` AS `is_paid`,
   `o`.`payment_type` AS `payment_type`,
   `o`.`delivery_type` AS `delivery_type`,
   `d`.`name` AS `delivery_type_name`,
   `d`.`price` AS `delivery_price`,
   SUM(`vop`.`total_price`) AS `products_price`,
   (`d`.`price` + SUM(`vop`.`total_price`)) AS `total_price`
FROM `orders` AS `o` LEFT JOIN `_orders_products` AS `vop` ON (`vop`.`order_id`=`o`.`id`) LEFT JOIN `delivery` AS `d` ON (`d`.`id`=`o`.`delivery_type`) GROUP BY `o`.`id`;


CREATE OR REPLACE VIEW `_orders_products_grouped`
AS SELECT
   `vop`.`id` AS `id`,
   `vop`.`product_id` AS `product_id`,
   `vop`.`product_name` AS `product_name`,
   `vop`.`order_id` AS `order_id`,
   `vop`.`order_options` AS `order_options`,
   `vop`.`base_price` AS `base_price`,
   `vop`.`options_price` as `options_price`,
   (`vop`.`base_price` + `vop`.`options_price`) AS `sum_price`,
   COUNT(vop.id) AS `cnt`,
   SUM(`vop`.`total_price`) AS `total_price`
FROM `_orders_products` AS `vop` GROUP BY `vop`.`order_id`, `vop`.`order_options` ORDER BY `vop`.`id`;



INSERT INTO `delivery` (`id`, `name`, `txt`, `price`, `is_visible`) VALUES
(1,	'Самовывоз', '', '0.00', '1'),
(2,	'Курьер', '', '0.00', '1');


INSERT INTO `nav` (`id`, `name`, `link`) VALUES
(1,	'Главная', ''),
(2,	'Каталог', ''),
(3,	'Коллекция', ''),
(4,	'Лукбук', ''),
(5,	'Изготовление на заказ', ''),
(6,	'Оплата и доставка', ''),
(7,	'Статьи', ''),
(8,	'О нас', ''),
(9,	'Контакты', '');


INSERT INTO `texts` (`id`, `title`, `txt`) VALUES
(1,	'О нас', ''),
(2,	'Оплата', ''),
(3,	'Доставка', ''),
(4,	'Политика конфиденциальности', ''),
(5,	'Лукбук', ''),
(6,	'О компании', '');


INSERT INTO `video_banner` (`id`, `video`) VALUES
(1,	'');


INSERT INTO `contacts` (`id`, `title`, `txt`, `address`, `phone`, `email`, `map_img`) VALUES
(1,	'Контакты', '', '', '', '', '');

/* Machine God set us free */