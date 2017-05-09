<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2016-01-20 16:49:57 --> Severity: error --> Exception: Unable to locate the model you have specified: User_photo_model F:\wamp\www\queqiao\php\system\core\Loader.php 314
ERROR - 2016-01-20 16:53:03 --> Severity: Notice --> Array to string conversion F:\wamp\www\queqiao\php\system\database\DB_driver.php 1398
ERROR - 2016-01-20 16:53:03 --> Severity: Notice --> Array to string conversion F:\wamp\www\queqiao\php\system\database\DB_driver.php 1398
ERROR - 2016-01-20 16:53:03 --> Severity: Notice --> Array to string conversion F:\wamp\www\queqiao\php\system\database\DB_driver.php 1398
ERROR - 2016-01-20 16:53:03 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '0, 1, 2) VALUES (Array, Array, Array)' at line 1 - Invalid query: INSERT INTO `w_user_using_total` (0, 1, 2) VALUES (Array, Array, Array)
ERROR - 2016-01-20 16:55:51 --> Severity: Warning --> Missing argument 2 for User_ranking_model::add(), called in F:\wamp\www\queqiao\php\application\services\User_service.php on line 203 and defined F:\wamp\www\queqiao\php\application\models\User_ranking_model.php 64
ERROR - 2016-01-20 16:55:51 --> Severity: Notice --> Undefined variable: position F:\wamp\www\queqiao\php\application\models\User_ranking_model.php 70
ERROR - 2016-01-20 16:55:51 --> Severity: Warning --> Missing argument 2 for User_identify_model::add(), called in F:\wamp\www\queqiao\php\application\services\User_service.php on line 204 and defined F:\wamp\www\queqiao\php\application\models\User_identify_model.php 34
ERROR - 2016-01-20 16:55:51 --> Severity: Warning --> Missing argument 3 for User_identify_model::add(), called in F:\wamp\www\queqiao\php\application\services\User_service.php on line 204 and defined F:\wamp\www\queqiao\php\application\models\User_identify_model.php 34
ERROR - 2016-01-20 16:55:51 --> Severity: Warning --> Missing argument 4 for User_identify_model::add(), called in F:\wamp\www\queqiao\php\application\services\User_service.php on line 204 and defined F:\wamp\www\queqiao\php\application\models\User_identify_model.php 34
ERROR - 2016-01-20 16:55:51 --> Severity: Notice --> Undefined variable: identify_code F:\wamp\www\queqiao\php\application\models\User_identify_model.php 37
ERROR - 2016-01-20 16:55:51 --> Severity: Notice --> Undefined variable: time F:\wamp\www\queqiao\php\application\models\User_identify_model.php 38
ERROR - 2016-01-20 16:55:51 --> Severity: Notice --> Undefined variable: last_time F:\wamp\www\queqiao\php\application\models\User_identify_model.php 40
ERROR - 2016-01-20 16:55:51 --> Query error: Duplicate entry '100011' for key 'PRIMARY' - Invalid query: INSERT INTO `w_user_identify` (`user_id`, `identify_code`, `time`, `last_time`) VALUES (100011, NULL, NULL, NULL)
ERROR - 2016-01-20 16:55:51 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at F:\wamp\www\queqiao\php\system\core\Exceptions.php:272) F:\wamp\www\queqiao\php\system\core\Common.php 573
ERROR - 2016-01-20 16:59:46 --> Severity: Warning --> Missing argument 2 for User_ranking_model::add(), called in F:\wamp\www\queqiao\php\application\services\User_service.php on line 203 and defined F:\wamp\www\queqiao\php\application\models\User_ranking_model.php 64
ERROR - 2016-01-20 16:59:46 --> Severity: Notice --> Undefined variable: position F:\wamp\www\queqiao\php\application\models\User_ranking_model.php 70
ERROR - 2016-01-20 16:59:46 --> Query error: Duplicate entry '100012' for key 'PRIMARY' - Invalid query: INSERT INTO `w_user_ranking` (`user_id`, `total`, `last_time`, `position`) VALUES (100012, 0, 1453305586, NULL)
