<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

/*-- ----------------------------
  ----TEST 
  -- ----------------------------*/

Route::get('/testPost',function(){
        $csrf_token = csrf_token();
            $form = <<<FORM
        <form action="/hello" method="POST">
            <input type="hidden" name="_token" value="{$csrf_token}">
            <input type="submit" value="Test"/>
        </form>
FORM;
            return $form;
});

Route::get('/hello',function(){
    return "Hello [POST]";
});

/*
 *匹配多个请求方式(已经覆盖上一个/hello路由)
 */
Route::match(['get','post'],'/hello',function(){
   return "match request"; 
});

/*
 *多个参数，其中一个参数可有可无
 */

Route::get('/hello/{name}/by/{user?}',function($name,$user = "haha"){
    return "Hello {$name},author by {$user}";   
});


/*
 *正则约束参数
 */

Route::get('/hello/{name}',function($name){
    return "Hello {$name}";   
})->where('name','[A-Za-z]+');


/*
 *路由重命名和重定向
 */

Route::get('/hello/mylv/{versionName}',['as'=>'hml',function($versionName){
    return "Hello mylv {$versionName}";   
}]);
Route::get('/testNameRoute',function(){
    return redirect()->route('hml',['versionName'=>5.1]);
});



/*-- ----------------------------
  ---- 前台页面
  -- ----------------------------*/

Route::get('/', 'HomeController@index');
Route::get('/article/{id}','HomeController@show');
Route::get('/category/{id}','HomeController@category');
Route::get('/tag/{id}','HomeController@tag');
Route::get('/about',function(){
    return '要不要增加个页面模型呢？';
});

/*-- ----------------------------
  ---- 登陆注册
  -- ----------------------------*/

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);

/*-- ----------------------------
  ---- 后台管理
  -- ----------------------------*/

Route::group(['prefix' => 'admin','namespace' => 'Admin','middleware' => 'auth'],function()
{
    //Markdown上传图片
    Route::post('/uploadImage','UploadController@uploadImage');

    Route::get('/','AdminController@index');

    Route::get('article/recycle', 'ArticleController@recycle');
    Route::get('article/destroy/{id}/','ArticleController@destroy');
    Route::get('article/restore/{id}', 'ArticleController@restore');
    Route::get('article/delete/{id}', 'ArticleController@delete');
    Route::resource('article','ArticleController');

    Route::get('category/destroy/{id}/','CategoryController@destroy');
    Route::resource('category','CategoryController');

    Route::get('tags/destroy/{id}/','TagController@destroy');
    Route::resource('tags','TagController');


});
