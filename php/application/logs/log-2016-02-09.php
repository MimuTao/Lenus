<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2016-02-09 04:39:49 --> Severity: Warning --> mysqli::real_connect():  F:\wamp\www\queqiao\php\system\database\drivers\mysqli\mysqli_driver.php 161
ERROR - 2016-02-09 04:39:49 --> Unable to connect to the database
ERROR - 2016-02-09 18:15:55 --> Severity: Notice --> Undefined property: FmCurrent::$controller F:\wamp\www\queqiao\php\application\libraries\FmCurrent.php 5
ERROR - 2016-02-09 18:15:55 --> Severity: Notice --> Trying to get property of non-object F:\wamp\www\queqiao\php\application\libraries\FmCurrent.php 5
ERROR - 2016-02-09 18:15:56 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at F:\wamp\www\queqiao\php\application\libraries\FmCurrent.php:5) F:\wamp\www\queqiao\php\system\core\Common.php 573
ERROR - 2016-02-09 18:15:56 --> Severity: Error --> Call to a member function model() on a non-object F:\wamp\www\queqiao\php\application\libraries\FmCurrent.php 5
ERROR - 2016-02-09 18:17:14 --> Severity: Notice --> Undefined property: FmCurrent::$controller F:\wamp\www\queqiao\php\application\libraries\FmCurrent.php 6
ERROR - 2016-02-09 18:17:14 --> Severity: Notice --> Trying to get property of non-object F:\wamp\www\queqiao\php\application\libraries\FmCurrent.php 6
ERROR - 2016-02-09 18:17:14 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at F:\wamp\www\queqiao\php\application\libraries\FmCurrent.php:6) F:\wamp\www\queqiao\php\system\core\Common.php 573
ERROR - 2016-02-09 18:17:14 --> Severity: Error --> Call to a member function model() on a non-object F:\wamp\www\queqiao\php\application\libraries\FmCurrent.php 6
ERROR - 2016-02-09 18:17:34 --> Severity: Notice --> Undefined property: FmCurrent::$controller F:\wamp\www\queqiao\php\application\libraries\FmCurrent.php 12
ERROR - 2016-02-09 18:17:34 --> Severity: Notice --> Trying to get property of non-object F:\wamp\www\queqiao\php\application\libraries\FmCurrent.php 12
ERROR - 2016-02-09 18:17:34 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at F:\wamp\www\queqiao\php\application\libraries\FmCurrent.php:12) F:\wamp\www\queqiao\php\system\core\Common.php 573
ERROR - 2016-02-09 18:17:34 --> Severity: Error --> Call to a member function get_effective_list() on a non-object F:\wamp\www\queqiao\php\application\libraries\FmCurrent.php 12
ERROR - 2016-02-09 18:17:54 --> Query error: Unknown column 'id' in 'order clause' - Invalid query: SELECT *
FROM `w_fm_cal`
WHERE `last_time` > 1454865474
ORDER BY `id` DESC
ERROR - 2016-02-09 18:43:56 --> Severity: Error --> Call to undefined method SmsLock::run() F:\wamp\www\queqiao\php\application\controllers\Queue.php 44
ERROR - 2016-02-09 19:48:53 --> 404 Page Not Found: Queue/sms_service
ERROR - 2016-02-09 19:48:58 --> Query error: Unknown column 'fm_id' in 'field list' - Invalid query: INSERT INTO `w_queue` (`fm_id`, `user_id`, `update_time`) VALUES ('sms', 0, 1455043738)
