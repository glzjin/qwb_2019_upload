<?php
namespace app\web\controller;
use think\Controller;

class Login extends Controller
{
    public $checker;

    public function __construct()
    {
        $this->checker=new Index();
    }

    public function login(){
        if($this->checker){
            if($this->checker->login_check()){
                $curr_url="http://".$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME']."/home";
                $this->redirect($curr_url,302);
                exit();
            }
        }
        if(input("?post.email") && input("?post.password")){
            $email=input("post.email","","addslashes");
            $password=input("post.password","","addslashes");
            $user_info=db("user")->where("email",$email)->find();
            if($user_info) {
                if (md5($password) === $user_info['password']) {
                    $cookie_data=base64_encode(serialize($user_info));
                    cookie("user",$cookie_data,3600);
                    $this->success('Login successful!', url('../home'));
                } else {
                    $this->error('Login failed!', url('../index'));
                }
            }else{
                $this->error('email not registed!',url('../index'));
            }
        }else{
            $this->error('email or password is null!',url('../index'));
        }
    }


}