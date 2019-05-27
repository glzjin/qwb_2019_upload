<?php
namespace app\web\controller;
use think\Controller;

class Register extends Controller
{
    public $checker;
    public $registed;

    public function __construct()
    {
        $this->checker=new Index();
    }

    public function register()
    {
        if ($this->checker) {
            if($this->checker->login_check()){
                $curr_url="http://".$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME']."/home";
                $this->redirect($curr_url,302);
                exit();
            }
        }
        if (!empty(input("post.username")) && !empty(input("post.email")) && !empty(input("post.password"))) {
            $email = input("post.email", "", "addslashes");
            $password = input("post.password", "", "addslashes");
            $username = input("post.username", "", "addslashes");
            if($this->check_email($email)) {
                if (empty(db("user")->where("username", $username)->find()) && empty(db("user")->where("email", $email)->find())) {
                    $user_info = ["email" => $email, "password" => md5($password), "username" => $username];
                    if (db("user")->insert($user_info)) {
                        $this->registed = 1;
                        $this->success('Registed successful!', url('../index'));
                    } else {
                        $this->error('Registed failed!', url('../index'));
                    }
                } else {
                    $this->error('Account already exists!', url('../index'));
                }
            }else{
                $this->error('Email illegal!', url('../index'));
            }
        } else {
            $this->error('Something empty!', url('../index'));
        }
    }

    public function check_email($email){
        $pattern = "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/";
        preg_match($pattern, $email, $matches);
        if(empty($matches)){
            return 0;
        }else{
            return 1;
        }
    }

    public function __destruct()
    {
        if(!$this->registed){
            $this->checker->index();
        }
    }


}