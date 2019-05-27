<?php
namespace app\web\controller;
use think\Controller;

class Index extends Controller
{
    public $profile;
    public $profile_db;

    public function index()
    {
        if($this->login_check()){
            $curr_url="http://".$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME']."/home";
            $this->redirect($curr_url,302);
            exit();
        }
        return $this->fetch("index");
    }

    public function home(){
        if(!$this->login_check()){
            $curr_url="http://".$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME']."/index";
            $this->redirect($curr_url,302);
            exit();
        }

        if(!$this->check_upload_img()){
            $this->assign("username",$this->profile_db['username']);
            return $this->fetch("upload");
        }else{
            $this->assign("img",$this->profile_db['img']);
            $this->assign("username",$this->profile_db['username']);
            return $this->fetch("home");
        }
    }

    public function login_check(){
        $profile=cookie('user');
        if(!empty($profile)){
            $this->profile=unserialize(base64_decode($profile));
            $this->profile_db=db('user')->where("ID",intval($this->profile['ID']))->find();
            if(array_diff($this->profile_db,$this->profile)==null){
                return 1;
            }else{
                return 0;
            }
        }
    }

    public function check_upload_img(){
        if(!empty($this->profile) && !empty($this->profile_db)){
            if(empty($this->profile_db['img'])){
                return 0;
            }else{
                return 1;
            }
        }
    }

    public function logout(){
        cookie("user",null);
        $curr_url="http://".$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME']."/index";
        $this->redirect($curr_url,302);
        exit();
    }

    public function __get($name)
    {
        return "";
    }

}
