#TP框架多应用
1、composer create-project topthink/think tp 6.0.*  
2、composer require topthink/think-multi-app  
3、php think build 应用名  
4、在vhost下的.conf文件location /中加入  
```
     if (!-e $request_filename) {
        rewrite  ^(.*)$  /index.php?s=/$1  last;
     }
```
5、创建路由-应用文件夹下创建route文件夹/app.php（例home应用下）app.php内容如下  
```
<?php
namespace app\home\route;

use think\facade\Route;

Route::get('/', 'index/index');
```
#tp分页后数据处理并携带参数
```
$list = Db::name('user')->where('status',1)->order('id', 'desc')->paginate()->each(function($item, $key){
    $item['nickname'] = 'think';
    return $item;
})->appends(['workname'=>$name]);
```
