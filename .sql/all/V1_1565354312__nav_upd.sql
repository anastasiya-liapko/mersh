ALTER TABLE `collections` ADD `display_in_menu` TINYINT(1) NOT NULL DEFAULT '1' AFTER `orderby`;

ALTER TABLE `categories` ADD `display_in_menu` TINYINT(1) NOT NULL DEFAULT '1' AFTER `orderby`;

CREATE OR REPLACE VIEW `_collections`
AS SELECT
   `c`.`id` AS `id`,
   `c`.`name` AS `name`,
   `c`.`txt` AS `txt`,
   `c`.`img` AS `img`,
   `c`.`orderby` AS `orderby`,
   `c`.`display_in_menu` AS `display_in_menu`,
   COUNT(`pc`.`id`) AS `cnt`
FROM `collections` AS `c` LEFT JOIN `products_collections` AS `pc` ON (`c`.`id`=`pc`.`collection_id`) GROUP BY `c`.`id`;


UPDATE `nav` SET `link` = '/' WHERE `nav`.`id` = 1;
UPDATE `nav` SET `link` = '#' WHERE `nav`.`id` = 2;
UPDATE `nav` SET `link` = '#' WHERE `nav`.`id` = 3;
UPDATE `nav` SET `link` = '/лукбук' WHERE `nav`.`id` = 4;
UPDATE `nav` SET `link` = '#' WHERE `nav`.`id` = 5;
UPDATE `nav` SET `link` = '/оплата-и-доставка' WHERE `nav`.`id` = 6;
UPDATE `nav` SET `link` = '#' WHERE `nav`.`id` = 7;
UPDATE `nav` SET `link` = '/о-нас' WHERE `nav`.`id` = 8;
UPDATE `nav` SET `link` = '/контакты' WHERE `nav`.`id` = 9;

ALTER TABLE `nav` ADD `display_in_menu` TINYINT(1) NOT NULL DEFAULT '1' AFTER `orderby`;