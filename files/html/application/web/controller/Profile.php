<?php
namespace app\web\controller;

use think\Controller;

class Profile extends Controller
{
    public $checker;
    public $filename_tmp;
    public $filename;
    public $upload_menu;
    public $ext;
    public $img;
    public $except;

    public function __construct()
    {
        $this->checker=new Index();
        $this->upload_menu=md5($_SERVER['REMOTE_ADDR']);
        @chdir("../public/upload");
        if(!is_dir($this->upload_menu)){
            @mkdir($this->upload_menu);
        }
        @chdir($this->upload_menu);
    }

    public function upload_img(){
        if($this->checker){
            if(!$this->checker->login_check()){
                $curr_url="http://".$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME']."/index";
                $this->redirect($curr_url,302);
                exit();
            }
        }

        if(!empty($_FILES)){
            $this->filename_tmp=$_FILES['upload_file']['tmp_name'];
            $this->filename=md5($_FILES['upload_file']['name']).".png";
            $this->ext_check();
        }
        if($this->ext) {
            if(getimagesize($this->filename_tmp)) {
                @copy($this->filename_tmp, $this->filename);
                @unlink($this->filename_tmp);
                $this->img="../upload/$this->upload_menu/$this->filename";
                $this->update_img();
            }else{
                $this->error('Forbidden type!', url('../index'));
            }
        }else{
            $this->error('Unknow file type!', url('../index'));
        }
    }

    public function update_img(){
        $user_info=db('user')->where("ID",$this->checker->profile['ID'])->find();
        if(empty($user_info['img']) && $this->img){
            if(db('user')->where('ID',$user_info['ID'])->data(["img"=>addslashes($this->img)])->update()){
                $this->update_cookie();
                $this->success('Upload img successful!', url('../home'));
            }else{
                $this->error('Upload file failed!', url('../index'));
            }
        }
    }

    public function update_cookie(){
        $this->checker->profile['img']=$this->img;
        cookie("user",base64_encode(serialize($this->checker->profile)),3600);
    }

    public function ext_check(){
        $ext_arr=explode(".",$this->filename);
        $this->ext=end($ext_arr);
        if($this->ext=="png"){
            return 1;
        }else{
            return 0;
        }
    }

    public function __get($name)
    {
        return $this->except[$name];
    }

    public function __call($name, $arguments)
    {
        if($this->{$name}){
            $this->{$this->{$name}}($arguments);
        }
    }

}