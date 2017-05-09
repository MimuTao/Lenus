<?php 
class MyTest extends CI_Controller{
    public function __construct(){
        parent::__construct();
        $this->load->database();
    }
    public function index(){
        echo 'This is The index function in MyTest.php'; 
    }
    // public function getUserTopicList(){
    //     $this->load->model('usertopic_model');
    //     $this->load->model('topic_model');
    //     $user_id=100014;
    //     $userTopicInfoList=$this->usertopic_model->GetUserTopicInfo($user_id);
    //     //echo json_encode($userTopicInfoList);
    //     $ls=array();
    //     foreach ($userTopicInfoList as $key => $value) {
    //          $ls[$key]['usertopic_id']=$value['id'];
    //          $ls[$key]['topic_id']=$value['topic_id'];
    //          //下面把topic名字也加上去
    //          $ls[$key]['topic_name']=$this->topic_model->GetTopicName($value['topic_id']);
    //     }
    //     echo json_encode($ls);
    // }
    // public function getUserTopicListNot(){
    //     $this->load->model('usertopic_model');
    //     $this->load->model('topic_model');
    //     $user_id=100014;
    //     $topicInfoList=$this->topic_model->GetTopicInfo();
    //     foreach ($topicInfoList as $key => $value) {
    //         echo $key.':'.$value['topic_id'].$value['topic_name'].'</br>';
    //     }
    //     $user_id=100014;
    //     //$userTopicList=$this->usertopic_model->GetTopicIdListByUserId($user_id);
    //     $userTopicList=$this->usertopic_model->GetUserTopicInfo($user_id);
    //     $topicListNot=array();
    //     echo var_dump($userTopicList);
    //     $tempUser=array();//储存topicid
    //     foreach ($userTopicList as $key => $value) {
    //         $tempUser[$key]=$value['topic_id'];
    //     }
    //     foreach ($topicInfoList as $key=> $value) {
    //         if(!in_array($value['topic_id'],$tempUser))
    //             $topicListNot[]=$value['topic_id'];
    //     }
    //     $ret=array();
    //     foreach ($topicListNot  as $key => $value) {
    //         $ret[$key]['topic_id']=$value;
    //         $ret[$key]['topic_name']=$this->topic_model->GetTopicName($value);
    //     }
    //     echo var_dump($ret);  
    // }
    /*
    public function AddUserTopic(){
         $this->load->model('usertopic_model');
         $user_id=100014;
         $topic_id=10000;
         
         if(!$this->usertopic_model->is_exist($user_id,$topic_id)){
             $this->usertopic_model->AddUserTopic($user_id,$topic_id);
             echo '插入成功@';
         }
         else 
             echo '已经有数据，不能插入';
    }
    */
    // public function GetCommentList(){
    //      $this->load->model('comment_model');
    //      $article_id=10000;
    //      $data=$this->comment_model->GetCommentListByArticleId($article_id);
    //      echo json_encode($data);        
    // }
    // public function AddComment(){
    //      $this->load->model('comment_model');
    //      $user_id=100014;
    //      $article_id=10001;
    //      $comment_contents='写的不错，挺好';
    //      echo $time;
    //      $this->comment_model->AddComment($user_id,$article_id,$time,$comment_contents);
    //      //echo json_encode($data);        
    // }
    // public function GetSubCommentList(){
    //      $this->load->model('subcomment_model');
    //      $comment_id=100003;
    //      $data=$this->subcomment_model->GetSubCommentListByCommentId($comment_id);
    //      echo json_encode($data);        
    // }
    // public function AddSubComment(){
    //      $this->load->model('subcomment_model');
    //      $user_id=100015;
    //      $comment_id=100003;
    //      $subcomment_contents='哈哈哈哈哈哈，你这个大Sb';
    //      $time=time();
    //      $this->subcomment_model->AddSubComment($user_id,$comment_id,$time,$subcomment_contents);
    //      //echo json_encode($data);        
    // }
    public function GetPraiseId(){
         $this->load->model('praise_model');
         $user_id=100014;
         $article_id=10000;
         $data=$this->praise_model->GetPraiseId($user_id,$article_id);
         echo json_encode($data);        
    }
    public function PraiseOrCalcelPraise(){
         $this->load->model('praise_model');
         $user_id=100014;
         $article_id=10000;
         $data=$this->praise_model->GetPraiseId($user_id,$article_id);
         if($data==NULL){      //if not praise
             $this->praise_model->Praise($user_id,$article_id);
         }
         else{                //if praise
             $this->praise_model->CancelPraise($user_id,$article_id);
         }    
    }
    public function GetUserTopicList(){
        $this->load->service('Topic_service');
        //$temp=$this->Topic_service->GetTopicList();
        $temp=$this->Topic_service->GetUserTopicList(100014);
        echo json_encode($temp);
    }
    public function GetTopicList(){
        $this->load->service('Topic_service');
        //$temp=$this->Topic_service->GetTopicList();
        $temp=$this->Topic_service->GetTopicList();
        echo json_encode($temp);
    }
    public function AddUserTopic(){
        $this->load->service('Topic_service');
        $data=array(
            'user_id'=>100014,
            'topic_id'=>10000,
        );
        $ret=$this->Topic_service->AddUserTopic($data);
        echo json_encode($ret);
    }
    public function DeleteUserTopic(){
        $this->load->service('Topic_service');
        $data=array(
            'user_id'=>100014,
            'topic_id'=>10015,
        );
        $ret=$this->Topic_service->DeleteUserTopic_($data);
        echo json_encode($ret);
    }
    public function GetArticleInfo(){
        $this->load->service('Article_service');
        $data=array(
            'user_id'=>100014,
            'article_id'=>10000,
        );
        $ret=$this->Article_service->GetArticleInfo($data);
        echo json_encode($ret);
    }
    public function GetArticleList(){
        $this->load->service('Article_service');
        $data=array(
            'topic_id'=>10000,
        );
        $ret=$this->Article_service->GetArticleList($data);
        echo json_encode($ret);
    }
    public function ArticlePraise(){
        $this->load->service('Article_service');
        $data=array(
            'user_id'=>100014,
            'article_id'=>10000,
            'flag'=>1,
        );
        $temp=$this->Article_service->OnPraise($data);
        echo json_encode($temp);
    }

    public function GetCommentList(){
        $this->load->service('Comment_service');
        $data=array(
            'user_id'=>100014,
            'article_id'=>10000,
        );
        $ret=$this->Comment_service->GetCommentList($data);
        echo json_encode($ret);
    }
    public function GetSubCommentList(){
        $this->load->service('Comment_service');
        $data=array(
            'comment_id'=>100003,
        );
        $ret=$this->Comment_service->GetSubCommentList($data);
        echo json_encode($ret);
    }
    public function AddComment(){
        $this->load->service('Comment_service');
        $user_id=100014;
        $article_id=10000;
        $comment_contents='hahahahahah, 第二个service 插入';
        $data=array(
            'user_id'=>$user_id,
            'article_id'=>$article_id,
            'comment_contents'=>$comment_contents,
        );
        $this->Comment_service->AddComment($data);
    }
    public function AddSubComment(){
        $this->load->service('Comment_service');
        $user_id=100014;
        $comment_id=100008;
        $subcomment_contents='subcomment2 contents';
        $data=array(
            'user_id'=>$user_id,
            'comment_id'=>$comment_id,
            'subcomment_contents'=>$subcomment_contents,
        );
        $this->Comment_service->AddSubComment($data);
    }
    public function DeleteComment(){
        $this->load->service('Comment_service');
        $data=array(
            'comment_id'=>100007,
        );
        $this->Comment_service->DeleteComment($data);
    }
    public function DeleteSubComment(){
        $this->load->service('Comment_service');
        $data=array(
            'subcomment_id'=>100003,
        );
        $this->Comment_service->DeleteSubComment($data);
    }
    public function collect_exist(){
        $this->load->model('collect_model');
        $user_id=100014;
        $article_id=10000;
        $ret=$this->collect_model->is_exist($user_id,$article_id);
        echo json_encode($ret);
    }
    public function GetUserCollectList(){
        $this->load->service('Article_service');
        $data=array(
            'user_id'=>100014,
        );
        $ret=$this->Article_service->GetUserCollectList($data);
        echo json_encode($ret);
    }
    public function OnCollect(){
        $this->load->service('article_service');
        $data=array(
            'user_id'=>100014,
            'article_id'=>10000,
            'flag'=>1,
        );
        $this->Article_service->OnCollect($data);
    }

    public function ResetPassword(){
        $this->load->service('User_service');
        $data=array(
            'user_id'=>100014,
            'newpwd'=>'taoyueyue54@qq.com',
            'pwd'=>'13290885619',        
        );
        $ret=$this->User_service->ResetPwd($data);
        echo json_encode($ret);
    }
    public function test(){
        $this->load->helper('url');
        $this->load->view('test');
    }

    public function Bind(){
        $this->load->model('expert_model');
        $user_id=100014;
        $basic_info="He is very popular in Math";
        $expert_field="Algorithms and system design.";
        //$this->expert_model->AddExpert($user_id);
        //$this->expert_model->DeleteExpert($user_id);
        //$this->expert_model->AddExpertWithInfo($user_id,$basic_info,$expert_field);
        // $data=$this->expert_model->is_exist($user_id);
        // echo var_dump($data);
        //$this->expert_model->UpdateInfo($user_id,$basic_info,$expert_field);
        //$this->expert_model->UpdateOnlineStatue($user_id,1);
        //echo json_encode($this->expert_model->GetExpertList());
        //echo json_encode($this->expert_model->GetInfoByUserId($user_id));
        // $rate=null;
        // $this->expert_model->UpdateRate($user_id,$rate);
        //$tag='有钱又帅';
        //$this->expert_model->AddTag($user_id,$tag);
        //$tag_id=3;
        //$this->expert_model->UpdateTag($tag_id,$tag);
        //$this->expert_model->DeleteTagByTagId($tag_id);
       // echo json_encode($this->expert_model->GetTagList($user_id));
       echo $this->expert_model->UpdateConsultTimes($user_id);
    }
    public function GetRateAverage(){
        $this->load->model('expert_model');
        $user_id=100014;
        echo json_encode($this->expert_model->GetRateAverage($user_id));
    }
    public function GetRateTimes(){
        $date=date('Y-m-d');
        //echo $date;exit;
        $this->load->model('expert_model');
        $user_id=100001;
        $expert_id=100014;
        $data=$this->expert_model->GetRateTimesInDate($user_id,$expert_id,$date);
        echo $data;
    }
    public function temp(){
        $this->load->service('Expert_service');
        $user_id=1000;
        $param=array(
            'user_id'=>$user_id,
            // 'ex'=>'这专家很牛',
            // 'ss'=>'动物发情',
        );
        //echo json_encode( $this->Expert_service->AddExpertWithInfo($param));  
        //echo json_encode( $this->Expert_service->DeleteExpert($param));    
    }

    public function SetOnlineStatue(){
        $this->load->service('Expert_service');
        $user_id=100014;
        $online_statue=2;
        $param=array(
            'user_id'=>$user_id,
            'online_statue'=>$online_statue,
        );
        echo json_encode( $this->Expert_service->SetOnlineStatue($param));   
    }
    public function SetExpertInfo(){
        $this->load->service('Expert_service');
        $user_id=100011;
        $param=array(
            'user_id'=>$user_id,
            'ex'=>'介绍已经更新了有',
            'ss'=>'擅长领域更新了与哦',
        );
        echo json_encode( $this->Expert_service->SetExpertInfo($param));  
    }
    public function GetExpertList(){
        $this->load->service('Expert_service');
        echo json_encode($this->Expert_service->GetExpertList());
    }
    public function GetExpertInfo(){
        $this->load->service('Expert_service');
        $user_id=100014;
        $data=array(
            'user_id'=>$user_id,
        );
        echo json_encode($this->Expert_service->GetExpertInfo($data));
    }
    public function AddRates(){
        $this->load->service('Expert_service');
        $user_id=10001;
        $data=array(
            'user_id'=>$user_id,
            'expert_id'=>100014,
            'rate'=>3,
        );
        echo json_encode($this->Expert_service->AddRate($data));
    }

}