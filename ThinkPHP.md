#TP��ܶ�Ӧ��
1��composer create-project topthink/think tp 6.0.*  
2��composer require topthink/think-multi-app  
3��php think build Ӧ����  
4����vhost�µ�.conf�ļ�location /�м���  
```
     if (!-e $request_filename) {
        rewrite  ^(.*)$  /index.php?s=/$1  last;
     }
```
5������·��-Ӧ���ļ����´���route�ļ���/app.php����homeӦ���£�app.php��������  
```
<?php
namespace app\home\route;

use think\facade\Route;

Route::get('/', 'index/index');
```
#tp��ҳ�����ݴ���Я������
```
$list = Db::name('user')->where('status',1)->order('id', 'desc')->paginate()->each(function($item, $key){
    $item['nickname'] = 'think';
    return $item;
})->appends(['workname'=>$name]);
```
