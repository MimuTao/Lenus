<?php  
class SendSms{
	//主帐号
	private $accountSid= '8a48b5515147eb6d01515771885f2586';

	private  $svr_url = 'http://112.74.76.186:8030/service/httpService/httpInterface.do';
	private  $svr_param = array();

	public function __construct() {
		require_once(APPPATH."third_party/phpdemo_func.php");
		$now = gmdate("D, d M Y H:i:s") . " GMT";
		header("Date: $now");
		header("Expires: $now");
		header("Last-Modified: $now");
		header("Pragma: no-cache");
		header("Cache-Control: no-store, no-cache, max-age=0, must-revalidate");
		$this->svr_param['username'] = 'JSM40716';    // 账号
		$this->svr_param['password'] = 'or03v9my';    // 密码
		$this->svr_param['veryCode'] = '450d9vcsdqip';    // 通讯认证Key
	}
	public function sendTemplateSMS($mobile,$code,$tempId){
		$post_data = $this->svr_param;
		$post_data['method'] = 'sendMsg';
		$post_data['mobile'] = $mobile;
		//$post_data['content']= '@1@=包先生,@2@='.rand(100000,999999);
		$post_data['content']= '@1@='.$code.",@2@=5";
		$post_data['msgtype']= '2';             // 1-普通短信，2-模板短信
		$post_data['tempid'] = $tempId; // 模板编号
		$post_data['code']   = 'utf-8';         // utf-8,gbk
		$res = request_post($this->svr_url, $post_data);  // 如果账号开了免审，或者是做模板短信，将会按照规则正常发出，而不会进人工审核平台
		echo_xmlarr($res);
		return $res;
	}
}
?>