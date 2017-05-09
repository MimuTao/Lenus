<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2016-02-21 05:29:24 --> Query error: Unknown column 'positin' in 'where clause' - Invalid query: SELECT * FROM
                (SELECT w1.user_id,w1.be_care_num,w2.nickname,w2.sex,w2.age,w2.sign,w2.head, @rownum:=@rownum+1 as `position`
                FROM (`w_user_care_cal` `w1`, (select @rownum:=0) t)
                LEFT JOIN `w_user` `w2` ON `w1`.`user_id` = `w2`.`id`
                ORDER BY w1.be_care_num DESC,w1.user_id ASC
                ) W WHERE `positin` >0 LIMIT 8
ERROR - 2016-02-21 05:35:06 --> Severity: Notice --> Undefined index: id F:\wamp\www\queqiao\php\application\services\User_care_cal_service.php 46
ERROR - 2016-02-21 05:35:06 --> Severity: Notice --> Undefined index: banner F:\wamp\www\queqiao\php\application\services\User_care_cal_service.php 51
