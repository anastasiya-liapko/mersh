CREATE OR REPLACE VIEW `_orders_products`
AS SELECT
   `op`.`id` AS `id`,
   `op`.`product_id` AS `product_id`,
   `p`.`name` AS `product_name`,
   `op`.`order_id` AS `order_id`,
   GROUP_CONCAT(`a`.`name`, ': ', `av`.`attribute_value` ORDER BY `pa`.`id` SEPARATOR ';') AS `order_options`,
   `op`.`current_price` AS `base_price`,
   IFNULL(SUM(`oo`.`current_price`), 0) as `options_price`,
   (`op`.`current_price` + IFNULL(SUM(`oo`.`current_price`), 0)) AS `total_price`
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
   IFNULL(SUM(`vop`.`total_price`), 0) AS `products_price`,
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
   IFNULL(SUM(`vop`.`total_price`), 0) AS `total_price`
FROM `_orders_products` AS `vop` GROUP BY `vop`.`order_id`, `vop`.`order_options` ORDER BY `vop`.`id`;
