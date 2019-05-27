<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

Route::post("login",'web/login/login');

Route::get("index",'web/index/index');

Route::get("home","web/index/home");

Route::post("register","web/register/register");

Route::get("logout","web/index/logout");

Route::post("upload","web/profile/upload_img");

Route::miss('web/index/index');

return [

];
