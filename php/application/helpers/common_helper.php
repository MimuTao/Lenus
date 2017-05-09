<?php

//int类型
const TYPE_INT = 1;
/**
 * double 类型
 */
const TYPE_DOUBLE = 2;

function load_js($file) {
    static $times = 0;
    if ($times === 0) {
        echo "<script type=\"text/javascript\">\n";
        echo "var time_offset =" . time() . "-Math.floor(new Date().getTime()/1000);\n";
        echo "var base_url    ='" . base_url('') . "';\n";
        echo "</script>\n";
    }
    foreach (func_get_args() as $file) {
        $file_min = str_replace('.js', '.min.js', $file);
        if (file_exists($file_min)) $file = $file_min;
        @$filemtime = filemtime($file);
        echo "<script src='" . resource_url($file) . "?" . $filemtime . "'></script>\r\n";
    }
    $times++;
}

function load_css($file) {
    foreach (func_get_args() as $file) {
        @$filemtime = filemtime($file);
        echo "<link href='" . resource_url($file) . "?" . $filemtime . "' rel=\"stylesheet\" type=\"text/css\" />\r\n";
    }
}

if (!function_exists('resource_url')) {
    /**
     * 获取资源文件的绝对路径
     *
     * @param $uri 资源文件的相对路径
     * @return string 资源文件的绝对路径
     */
    function resource_url($uri) {
        $resource_base_url = config_item('resource_base_url');
        if (empty($resource_base_url)) {
            return base_url($uri);
        } else {
            $resource_base_url = rtrim($resource_base_url, '/') . '/';
            $uri = ltrim($uri, '/');
            return $resource_base_url . $uri;
        }
    }
}

function ShowResult($status = false, $code, $data = "", $msg = "") {
    $CI =& get_instance();
    header('Content-Type:application/json;charset=utf-8');
    $code = trim($code);
    if ($status == false && empty($msg)) {
        $info = $CI->config->item('error');
        $msg = $info['error'][$code];
    }
    $d = array(
        "success" => $status,
        "code" => intval($code),
        "data" => $data,
        "msg" => $msg,
    );
    echo json_encode($d,JSON_UNESCAPED_SLASHES);
    $CI =& get_instance();
    if (isset($CI->hooks)) {
        $CI->hooks->call_hook("post_system");
    }
    exit;
}

function ShowArrayResult($result) {
    header('Content-Type:application/json;charset=utf-8');
    //header('Content-Type:text/html');
    $d = array(
        "success" => $result['success'],
        "code" => $result['code'],
        "data" => $result['data'],
        "msg" => $result['msg'],
    );
    echo json_encode($d,  JSON_UNESCAPED_SLASHES);
    $CI =& get_instance();
    if (isset($CI->hooks)) {
        $CI->hooks->call_hook("post_system");
    }
    exit;
}

function create_guid($namespace = '') {
    static $guid = '';
    $uid = uniqid("", true);

    $data = $namespace;
    $data .= $_SERVER['REQUEST_TIME'];
    $data .= $_SERVER['HTTP_USER_AGENT'];
    $data .= $_SERVER['HTTP_USER_AGENT'];
    $data .= $_SERVER['REMOTE_ADDR'];
    $data .= $_SERVER['REMOTE_PORT'];

    $hash = strtoupper(hash('ripemd128', $uid . md5($data) . rand(0, 10000)));
    $guid = $hash;
    return $guid;
}

function my_salt_password_hash($password, $salt) {
    return md5($password . $salt);
}

function generate_password($length = 8) {
// 密码字符集，可任意添加你需要的字符
    $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()-_ []{}<>~`+=,.;:/?|';
    $password = '';
    for ($i = 0; $i < $length; $i++) {
        // 这里提供两种字符获取方式
        // 第一种是使用 substr 截取$chars中的任意一位字符；
        // 第二种是取字符数组 $chars 的任意元素
        // $password .= substr($chars, mt_rand(0, strlen($chars) – 1), 1);
        $password .= $chars[mt_rand(0, strlen($chars) - 1)];
    }
    return $password;
}

function unique_img_name($length = 8) {
// 密码字符集，可任意添加你需要的字符
    $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789_';
    $password = '';
    for ($i = 0; $i < $length; $i++) {
        // 这里提供两种字符获取方式
        // 第一种是使用 substr 截取$chars中的任意一位字符；
        // 第二种是取字符数组 $chars 的任意元素
        // $password .= substr($chars, mt_rand(0, strlen($chars) – 1), 1);
        $password .= $chars[mt_rand(0, strlen($chars) - 1)];
    }
    return $password.rand(0,10000);
}

function unique_recommend_code($length = 6) {
// 密码字符集，可任意添加你需要的字符
    $chars = 'abcdefghijklmnopqrstuvwxyz0123456789';
    $password = '';
    for ($i = 0; $i < $length; $i++) {
        // 这里提供两种字符获取方式
        // 第一种是使用 substr 截取$chars中的任意一位字符；
        // 第二种是取字符数组 $chars 的任意元素
        // $password .= substr($chars, mt_rand(0, strlen($chars) – 1), 1);
        $password .= $chars[mt_rand(0, strlen($chars) - 1)];
    }
    return $password;
}

function img_rand($length = 8) {
// 密码字符集，可任意添加你需要的字符
    $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $password = '';
    for ($i = 0; $i < $length; $i++) {
        // 这里提供两种字符获取方式
        // 第一种是使用 substr 截取$chars中的任意一位字符；
        // 第二种是取字符数组 $chars 的任意元素
        // $password .= substr($chars, mt_rand(0, strlen($chars) – 1), 1);
        $password .= $chars[mt_rand(0, strlen($chars) - 1)];
    }
    return $password;
}

/**
 * 生成缩略图函数（支持图片格式：gif、jpeg、png和bmp）
 * @author ruxing.li
 * @param  string $src 源图片路径
 * @param  int $width 缩略图宽度（只指定高度时进行等比缩放）
 * @param  int $width 缩略图高度（只指定宽度时进行等比缩放）
 * @param  string $filename 保存路径（不指定时直接输出到浏览器）
 * @return bool
 */
function mkThumbnail($src, $width = null, $height = null, $filename = null) {
    if (!isset($width) && !isset($height))
        return false;
    if (isset($width) && $width <= 0)
        return false;
    if (isset($height) && $height <= 0)
        return false;

    $size = getimagesize($src);
    if (!$size)
        return false;

    list($src_w, $src_h, $src_type) = $size;
    $src_mime = $size['mime'];
    switch ($src_type) {
        case 1 :
            $img_type = 'gif';
            break;
        case 2 :
            $img_type = 'jpeg';
            break;
        case 3 :
            $img_type = 'png';
            break;
        case 15 :
            $img_type = 'wbmp';
            break;
        default :
            return false;
    }

    if (!isset($width))
        $width = $src_w * ($height / $src_h);
    if (!isset($height))
        $height = $src_h * ($width / $src_w);

    $imagecreatefunc = 'imagecreatefrom' . $img_type;
    $src_img = $imagecreatefunc($src);
    $dest_img = imagecreatetruecolor($width, $height);
    imagecopyresampled($dest_img, $src_img, 0, 0, 0, 0, $width, $height, $src_w, $src_h);

    $imagefunc = 'image' . $img_type;
    if ($filename) {
        $imagefunc($dest_img, $filename);
    } else {
        header('Content-Type: ' . $src_mime);
        $imagefunc($dest_img);
    }
    imagedestroy($src_img);
    imagedestroy($dest_img);
    return true;
}

function multifile_array() {
    if (count($_FILES) == 0)
        return;
    $files = array();
    $all_files = $_FILES['img']['name'];
    $i = 0;
    foreach ($all_files as $filename) {
        $files[++$i]['name'] = $filename;
        $files[$i]['type'] = current($_FILES['img']['type']);
        next($_FILES['img']['type']);
        $files[$i]['tmp_name'] = current($_FILES['img']['tmp_name']);
        next($_FILES['img']['tmp_name']);
        $files[$i]['error'] = current($_FILES['img']['error']);
        next($_FILES['img']['error']);
        $files[$i]['size'] = current($_FILES['img']['size']);
        next($_FILES['img']['size']);
    }
    $_FILES = $files;
}
function lock($name){
    file_put_contents(APPPATH."cache/".$name,"",LOCK_EX);
}
function check_lock($name){
    if(file_exists(APPPATH."cache/".$name)){
        return true;
    }
    else{
        return false;
    }
}
function release_lock($name){
    unlink(APPPATH."cache/".$name);
}


//判断是否为日期格式，默认时间格式为Y-m-d
function is_date($dateStr,$fmt="Y-m-d"){
    $dateArr = explode("-",$dateStr);
    if(empty($dateArr)){
        return false;
    }
    foreach($dateArr as $val){
        if(strlen($val)<2){
            $val="0".$val;
        }
        $newArr[]=$val;
    }
    $dateStr =implode("-",$newArr);
    $unixTime=strtotime($dateStr);
    $checkDate= date($fmt,$unixTime);
    if($checkDate==$dateStr)
        return true;
    else
        return false;
}

//通过出生年月获取属相
function getShuXiang($bithdayDate){

    //判断输入日期格式
    if(!is_date($bithdayDate)){

        echo "日期输入错误，请检查！";
    }
    //1900年是鼠年
    $data = array('鼠','牛','虎','兔','龙','蛇','马','羊','猴','鸡','狗','猪');

    $index = ($bithdayDate-1900)%12;

    return $data[$index];

}

function get_zodiac_sign($month, $day)
{
// 检查参数有效性
    if ($month < 1 || $month > 12 || $day < 1 || $day > 31)
        return (false);
// 星座名称以及开始日期
    $signs = array(
        array( "20" => "水瓶"),
        array( "19" => "双鱼"),
        array( "21" => "白羊"),
        array( "20" => "金牛"),
        array( "21" => "双子"),
        array( "22" => "巨蟹"),
        array( "23" => "狮子"),
        array( "23" => "处女"),
        array( "23" => "天秤"),
        array( "24" => "天蝎"),
        array( "22" => "射手"),
        array( "22" => "摩羯")
    );
    list($sign_start, $sign_name) = each($signs[(int)$month-1]);
    if ($day < $sign_start)
        list($sign_start, $sign_name) = each($signs[($month -2 < 0) ? $month = 11: $month -= 2]);
    return $sign_name;
}//函数结束

function error_output($arr){
    $result = "";
    $i = 1;
    foreach($arr as $v){
        if($i<count($arr))
            $result.=$i."、".$v.";";
        else
            $result.=$i."、".$v;
        $i++;
    }
    return $result;
}
function unicode_decode($name)
{
    // 转换编码，将Unicode编码转换成可以浏览的utf-8编码
    $pattern = '/([\w]+)|(\\\u([\w]{4}))/i';
    preg_match_all($pattern, $name, $matches);
    if (!empty($matches))
    {
        $name = '';
        for ($j = 0; $j < count($matches[0]); $j++)
        {
            $str = $matches[0][$j];
            if (strpos($str, '\\u') === 0)
            {
                $code = base_convert(substr($str, 2, 2), 16, 10);
                $code2 = base_convert(substr($str, 4), 16, 10);
                $c = chr($code).chr($code2);
                $c = iconv('UCS-2', 'UTF-8', $c);
                $name .= $c;
            }
            else
            {
                $name .= $str;
            }
        }
    }
    return $name;
}
function check_wx_browser(){
    $user_agent = $_SERVER['HTTP_USER_AGENT'];
    if (strstr($user_agent, 'Built-in music')||strstr($user_agent, 'WeChat')) {
        // 非微信浏览器禁止浏览
        return true;
    } else {
        // 微信浏览器，允许访问
        return false;
    }
}
function check_url($url){
    $array = get_headers($url,1);
    if(preg_match('/200/',$array[0])){
        return true;
    }else{
        return false;
    }
}
function judge_url($url){
    if(!preg_match('/http:\/\/[\w.]+[\w\/]*[\w.]*\??[\w=&\+\%]*/is',$url)){
        return false;
    }
    return true;
}
function check_mobile($phonenumber){
    if(preg_match("/^1[34578]{1}\d{9}$/",$phonenumber)){
        return true;
    }else{
        return false;
    }
}
function get_page_url(){
    $url = (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == '443') ? 'https://' : 'http://';
    $url .= $_SERVER['HTTP_HOST'];
    $url .= isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : urlencode($_SERVER['PHP_SELF']) . '?' . urlencode($_SERVER['QUERY_STRING']);
    return $url;
}

//数据类型转换 多数据
function change_param_type($param=array(), $rule=array())
{
    foreach($param as $k=>$v)
    {
        foreach($rule as $key=>$value)
        {
            switch($value)
            {
                case TYPE_INT:
                    $param[$k][$key] = (integer) $param[$k][$key];
                    break;
                case TYPE_DOUBLE:
                    $param[$k][$key] = (double) $param[$k][$key];
                    break;
                default:
                    break;
            }
        }
    }
    return $param;
}

//数据类型转换 单数据
function change_type($param=array(), $rule=array())
{

    foreach($rule as $key=>$value)
    {
        switch($value)
        {
            case TYPE_INT:
                $param[$key] = (integer) $param[$key];
                break;
            case TYPE_DOUBLE:
                $param[$key] = (double) $param[$key];
                break;
            default:
                break;
        }
    }

    return $param;
}

//截取字符串两个字符之间的内容
function getBetween($content,$kw1,$kw2)
{
    $con = str_split($content,1);
    $result = array();
    $sub_str = $content;
    foreach($con as $k=>$v)
    {
        if($v == $kw1 && $sub_str!='')
        {
            $pos1 = strpos($sub_str,$kw1);
            $pos2 = strpos($sub_str,$kw2);
            if($pos2)
            {
                $temp = substr($sub_str,$pos1+1,$pos2-$pos1-1);
                $sub_str = substr($sub_str,$pos2+1);
                array_push($result,$temp);
            }
        }
    }
    return $result;
}

function getAge($id_card){
    $birth = strtotime(strlen($id_card)==15 ? ('19' . substr($id_card, 6, 6)) : substr($id_card, 6, 8));
    $today=strtotime('today');
    $age = floor(($today-$birth)/86400/365);

    return $age;
}
function getSex($id_card){
    $sex = substr($id_card, (strlen($id_card)==15 ? -2 : -1), 1) % 2 ? '男' : '女';
    return $sex;
}

function replaceHtmlAndJs($document)
{
    $document = trim($document);
    if (strlen($document) <= 0)
    {
        return $document;
    }
    $search = array (
        "'<script[^>]*?>.*?
        // --></mce:script>'si",  // 去掉 javascript
        "'<[///!]*?[^<>]*?>'si",          // 去掉 HTML 标记
        "'[/r/n/s+]'",                // 去掉空白字符
        "'&(/w+);'i"              // 替换 HTML 实体
    );                    // 作为 PHP 代码运行

    $replace = array ( "", "", "", ""  );

    return @preg_replace ($search, $replace, $document);

}

