<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test extends Base_Controller
{

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     *        http://example.com/index.php/welcome
     *    - or -
     *        http://example.com/index.php/welcome/index
     *    - or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see http://codeigniter.com/user_guide/general/urls.html
     */
    public function __construct() {
            parent::__construct();
            //require_once(APPPATH."third_party/Validation/Services/ValidatorService.php");
            $this->load->library('form_validation');
            $hostdir = (APPPATH . "/services");
            $filesnames = scandir($hostdir);
            foreach ($filesnames as $service) {
                if ($service != "." && $service != "..")
                    $this->load->service($service);
            }
}

    public function alipay_service(){
//        $result = $this->Alipay_service->vip_order(
//            array(100000,"vip_1_0")
//        );
        $result = $this->Alipay_service->activity_order(
            array(100000,"activity",100000)
        );
        echo json_encode($result);
    }

    public function time(){
        //echo strtotime("1990-01-01");
        echo date("Y-m-d H:i:s",1459355747);
    }

    public function verification_img_service() {
        $this->load->helper('captcha');
        $result = $this->Verification_Img_service->InReg(
            array()
        );
        echo $result;
    }

    public function cycle_image_service() {
        $result = $this->Cycle_image_service->CycleImageList(
            array("fm")
        );
        echo json_encode($result);
    }

    public function check_url(){
        $url = stripslashes("http://queqiaozl.b0.upaiyun.com/video/2016_03_28/5MwT4kuy69091000681459150268.mp4");
        $result = check_url($url);
        var_dump($result);
    }

    public function fm_list_service() {
//        $result = $this->Fm_list_service->next_fm(
//            array(100009)
//        );
//        $result = $this->Fm_list_service->get_info(
//            array(100009,100000)
//        );
//		echo json_encode($result,JSON_UNESCAPED_SLASHES);
        $result = $this->Fm_list_service->GetFmList(
            array(0, 10,100000)
        );
//        $this->load->model("Fm_list_model");
        // $result = $this->Fm_list_model->get_info(100000);

        echo json_encode($result);
    }

    public function Register()
    {
        $result = $this->User_service->Register(
            array(
                'mobile'=>'15355499236',
                'password'=>'123456',
                'r_password'=>'123456',
            )
        );
        echo json_encode($result);
    }

    public function Login()
    {
        $result = $this->User_service->Login(
            array(
                // 'mobile'=>'15355499236',
                // 'password'=>'123456',
                'mobile'=>'15267022621',
                'password'=>'13290885619',
            )
        );
        echo json_encode($result);
    }



    public function UpdateUserName(){
        $result = $this->User_service->UpdateUserName(
            array(
                'user_id'=>100014,
                'user_name'=>'MimuTao',
            )
        );
        echo json_encode($result);
    }

    public function IsRegister(){
        $result = $this->User_service->IsRegister(
            array(
                'mobile'=>'15267022621'
            )
        );
        echo json_encode($result);
    }

    public function GetUserResult(){
        $result = $this->Result_service->GetUserResult(
            array(
                'user_id'=>100000,
                'check_id'=>0
            )
        );
        echo json_encode($result);
    }

    public function GetDesList(){
        $result = $this->Describe_service->GetDesList(
            array(
                'user_id'=>100000,
                'type'=> 'character',
                'code'=>'D0038'
            )
        );
        echo json_encode($result);
    }

    public function BindReport(){
        $result = $this->Record_service->BindReport(
            array(
                'user_id'=>100001,
                'code'=>'wa'
            )
        );
        echo json_encode($result);
    }

    public function split(){
        $choice = explode(",", '');
        var_dump($choice);
    }

    public function ForgetPwd(){
        $result = $this->User_service->ForgetPwd(
            array(
                'mobile'=>15355499236,
                'pwd'=>'123456',
                'r_pwd'=>'123456'
            )
        );
        echo json_encode($result);
    }

    public function GetDesTypeList(){
        $result = $this->Describe_service->GetDesTypeList(
            array(
                'user_id'=>100000,
                'type'=> 'drug',
                'code'=>'',
                'choice'=>'0,1',
                'check_id'=>0
            )
        );
        echo json_encode($result);
    }
    
    public function RegSendMsg(){
        $this->Sms_service->RegSendMsg(
            array("15355499236")
        );
    }

    public function SearchDesTypeList(){
        $result = $this->Describe_service->SearchDesTypeList(
            array(
                'user_id'=>100000,
                'key'=>'22q13.3缺失综合征',
                'check_id'=>0
            )
        );
        echo json_encode($result);
    }

    public function RelationKey(){
        $result = $this->Describe_service->RelationKey(
            array(
                'key'=>"综合征"
            )
        );
        echo json_encode($result);
    }
    public function IsBind(){
        $result = $this->Record_service->IsBind(
            array(
                'user_id'=>100000,
            )
        );
        echo json_encode($result);
    }

    public function GetDesInfo(){
        $result = $this->Describe_service->GetInfo(
            array(
                'user_id'=>100000,
                'code'=>'D0038'
            )
        );
        echo json_encode($result);
    }

    public function GetDetails(){
        $result = $this->Result_service->GetDetails(
            array(
                'user_id'=>100000,
                'type'=> 'character',
                'code'=>'D0038'
            )
        );
        echo json_encode($result);
    }

    public function RegSms(){
        $result = $this->Sms_service->RegSendMsg(
            array(
                'mobile'=>'15355499236',
            )
        );
        echo json_encode($result);
    }

    public function GetHealthCheckList(){
        $result = $this->Describe_service->GetHealthCheckList(
            array(
                'mobile'=>'15355499236',
            )
        );
        echo json_encode($result);
    }



    public function ConfirmReg(){
        $result = $this->Sms_service->ConfirmReg(
            array(
                'mobile'=>'15355499236',
                'code'=>'1111',
            )
        );
        echo json_encode($result);
    }

    public function InsertResult()
    {
        $this->User_service->InsertResult();
    }

    public function InsertSnp()
    {
        $this->User_service->InsertSnp();
    }

    public function InsertData()
    {
        $this->Result_service->InsertData();
    }

    public function GetCharacter()
    {
        $this->Result_service->GetCharacter();
    }

    public function GetDeaseCount()
    {
        $this->Result_service->GetDeaseCount();
    }



    //下面开始是MimuTao的Test
    public function insertTopic(){
        //$this->load->model('topic_model');
        $this->load->model('article_model');
        $topic_id=10000;
        $data=$this->article_model->GetArticleInfoByTopicId($topic_id);
        //$dataSend=$data[0];
        echo json_encode($data);

    }
    public function getArticleId(){
        $this->load->model('article_model');
        $topic_id=10000;
        $data=$this->article_model->GetArticleIdByTopicId($topic_id);
        echo json_encode($data);
    }
    public function getArticleInfo(){
        $this->load->model('article_model');
        $article_id=10002;
        $data=$this->article_model->GetInfoByArticleId($article_id);
        //echo json_encode($data);
        if(empty($data)){
            echo var_dump($data);
        }    
    }
    public function getUserTopicList(){
         $this->load->model('usertopic_model');
         $user_id=100014;
         $data=$this->usertopic_model->GetTopicIdListByUserId($user_id);
         echo var_dump($data);
    }
    public function AddUserTopic(){
         $this->load->model('usertopic_model');
         $user_id=100014;
         $topic_id=10001;
         
         if(!$this->usertopic_model->is_exist($user_id,$topic_id)){
             $this->usertopic_model->AddUserTopic($user_id,$topic_id);
             echo '插入成功@';
         }
         else 
             echo '已经有数据，不能插入';
    }
    public function GetTopicListNot(){
        $this->load->model('topic_model');
        $this->load->model('usertopic_model');
        $topicInfoList=$this->topic_model->GetTopicInfo();
        foreach ($topicInfoList as $key => $value) {
            echo $key.':'.$value['topic_id'].$value['topic_name'].'</br>';
        }
        $user_id=100014;
        //$userTopicList=$this->usertopic_model->GetTopicIdListByUserId($user_id);
        $userTopicList=$this->usertopic_model->GetUserTopicInfo($user_id);
        $topicListNot=array();
        echo var_dump($userTopicList);
        $tempUser=array();
        foreach ($userTopicList as $key => $value) {
            $tempUser[$key]=$value['topic_id'];
        }
        foreach ($topicInfoList as $key=> $value) {
            if(!in_array($value['topic_id'],$tempUser))
                $topicListNot[]=$value['topic_id'];
        }
        echo var_dump($topicListNot);  
    }   
        public function delete(){
            $this->load->model('usertopic_model');
            $usertopic_id=100000;
            $this->usertopic_model->DeleteUserTopic($usertopic_id);
            $this->GetTopicListNot();
        }
   

}
