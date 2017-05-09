<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2017-05-03 06:47:30 --> Query error: Field 'consult_times' doesn't have a default value - Invalid query: INSERT INTO `w_expert` (`user_id`, `expert_id`) VALUES (100014, 100014)
ERROR - 2017-05-03 06:51:28 --> Query error: Duplicate entry '100014' for key 'PRIMARY' - Invalid query: INSERT INTO `w_expert` (`user_id`, `expert_id`) VALUES (100014, 100014)
ERROR - 2017-05-03 07:04:05 --> Query error: Unknown column '$user_id' in 'where clause' - Invalid query: DELETE FROM `w_expert`
WHERE `$user_id` = 100014
ERROR - 2017-05-03 07:11:56 --> Query error: Duplicate entry '100014' for key 'PRIMARY' - Invalid query: INSERT INTO `w_expert` (`user_id`, `expert_id`, `basic_info`, `expert_field`) VALUES (100014, 100014, 'Graduated from ZheJiang University and have presitage in this field', 'Algorithms and system design.')
ERROR - 2017-05-03 07:11:57 --> Query error: Duplicate entry '100014' for key 'PRIMARY' - Invalid query: INSERT INTO `w_expert` (`user_id`, `expert_id`, `basic_info`, `expert_field`) VALUES (100014, 100014, 'Graduated from ZheJiang University and have presitage in this field', 'Algorithms and system design.')
ERROR - 2017-05-03 07:11:57 --> Query error: Duplicate entry '100014' for key 'PRIMARY' - Invalid query: INSERT INTO `w_expert` (`user_id`, `expert_id`, `basic_info`, `expert_field`) VALUES (100014, 100014, 'Graduated from ZheJiang University and have presitage in this field', 'Algorithms and system design.')
ERROR - 2017-05-03 07:11:57 --> Query error: Duplicate entry '100014' for key 'PRIMARY' - Invalid query: INSERT INTO `w_expert` (`user_id`, `expert_id`, `basic_info`, `expert_field`) VALUES (100014, 100014, 'Graduated from ZheJiang University and have presitage in this field', 'Algorithms and system design.')
ERROR - 2017-05-03 07:16:17 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'WHERE `user_id` = 100014' at line 2 - Invalid query: SELECT *
WHERE `user_id` = 100014
ERROR - 2017-05-03 07:24:41 --> Severity: Parsing Error --> syntax error, unexpected '}', expecting ';' or '{' C:\MimuTao\WampServer\www\gene\php\application\models\Expert_model.php 52
ERROR - 2017-05-03 07:54:22 --> Severity: Notice --> Undefined variable: basic_info C:\MimuTao\WampServer\www\gene\php\application\controllers\MyTest.php 279
ERROR - 2017-05-03 08:15:16 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'WHERE `user_id` = 100014' at line 2 - Invalid query: SELECT *
WHERE `user_id` = 100014
