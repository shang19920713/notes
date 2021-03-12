#nginx环境下 需要加入下面这段代码 位置是location / 下 注意if后面必须有一个空格
```
     if (!-e $request_filename) {
     rewrite  ^/index.php(.*)$  /index.php?s=$1  last;//如果还想路由中带index.php 需要加上这段话
      rewrite  ^/(.*)$  /index.php?s=$1  last;
      break;
    }
```
#tp框架 分页查询处理每一条数据
```
$list = Db::name('user')->where('status',1)->order('id', 'desc')->paginate()->each(function($item, $key){
    $item['nickname'] = 'think';
    return $item;
})->appends(['workname'=>$name]);
```
#如果实用tp写接口，那么控制器或者方法不存在时就不应该报页面错误，而是返回接口的相应数据
###方法不存在可以以下操作：
```
只需要在继承的BaseController里加入__call方法即可
public function __call($name, $arguments)
{
    $result = [
        'code'=>0,
        'msg'=>'找不到'.$name.'控制器'
    ];
    return json($result, 400);//tp自带的数组转换成json
    
}
```

###控制器不存在可以以下方法
```
1、首先在controller文件夹下创建一个Error.php 应该是tp框架自带的一种模式 只需要创建这个文件 后续访问到不存在的控制器便自动调用__call
<?php
namespase app\controller;
class Error
{
    public function __call($name, $arguments)
    {
        $result = [
            'code'=>0,
            'msg'=>'找不到'.$name.'控制器'
        ];
        return json($result, 400);//tp自带的数组转换成json 400是http的状态码
        
    }
}
```

### api接口统一返回json格式可以定义在common.php里 其他文件直接调用方法名即可/不需要引入这个文件
### 状态码可以统一定义在config文件夹下 例如创建个status.php 里面仿照app.php写即可
```
<?php

    return [
        'success'=>1,
        'error'=>0
    ];
    调用：config('status.error');
```
###tp排查sql错误
1、可以实用开启debug后点击右下角的图标看sql语句  
`$res = Db::table('user')->where('id', 1)->fetchSql()->find(); 会把sql语句打印出来`  
###tp6开启多应用 首先要 安装扩展
#####运行 composer require topthink/think-multi-app 

####关于多应用路由 可以在模块下创建route文件夹/route.php  访问时需要域名+模块名+路由配置才可以
`如api模块下创建路由 Route::rule('test','index/hello','GET')`;  访问时要域名/api/test 才可以  
###多应用下的项目架构 以api模块项目下demo（一般名字以数据库名创建比较好） controller为例
1、首先是api下的controller下的demo.php 这一层只用来接收判断数据 然后调用common下的business下的逻辑处理层
2、app/common/business 下的demo.php 这一层主要负责业务逻辑处理层（如果逻辑相对于模块间是独立的 可以将business放在相应模块里 如果逻辑多个模块可以用到 直接放在common里）
3、业务逻辑处理层 处理各种逻辑以及向model层获取数据返回给controller
4、model层 model文件夹可以建立在模块下 但最后建立在common下 毕竟model层获取数据库数据适用于各个模块
5、model层的目录创建 可以如下：app/common/model/mysql/demo.php 之所以加了一层mysql因为数据处理不单单涉及mysql还有redis等
6、如果用到view层 涉及到模版引擎渲染 view可以建立在各个模块之下
###关于异常
1、针对不可预知的异常 tp框架支持可以在app/ExceptionHandle.php的文件下的render方法下自定义异常
2、该方法下 可以直接加上 return show(config('code.error'), $e->getMessage());
3、说明：show方法是自定义的api返回数据通用格式方法 config('code.error')是自定义存储在配置文件下的状态码
4、关于config文件 读取配置都是config('文件名.key') 比如我们在admin模块/config/文件夹自定义了admin.php配置文件
那么读取这个文件里的配置 一样是写成config('admin.key')
 当然以上的异常处理方法是只针对api这种数据返回格式的
###加入我们的项目不止有api模块还有admin模块并且实用了模版引擎这时候都采用上面
###这种方法展示异常就不合适
###所以我们需要根据不同模块自定义返回异常方法
1、首先app/ExceptionHandle.php文件是所有模块公共的异常处理类
2、但是我们想自定义api模块的异常处理类
3、方法：创建app/api/exception/http.php 文件（名字可以自行取）
4、http.php文件里填充app/ExceptionHandle.php内容 但是class类里的方法只留render方法 use使用的东西要有
5、在render方法下可以自定义异常输出形式 比如可以直接返回return show(config('code.error'), $e->getMessage());
6、注意命名空间 另外做好这些以后还需要将app/provider.php复制到app/api目录下
7、并且修改 'think\exception\Handle' 值
8、其实就是定位到上面的http.php 可以写成'think\exception\Handle' => 'app\\api\\exception\\http'
###关于tp模版渲染 
1、首先要安装 composer require topthink/think-view
2、引入 use think\facade\View;
3、返回 return View::fetch('page/login'); //此时他会找模块名/view/page/login.html
###关于tp6验证码扩展的实用
1、前端使用可以参考手册
2、后端校验验证码 可以直接实用captcha_check()函数  captcha_check($code) 校验成功返回true否则返回false
3、要想使用tp的验证码需要开启session  因为这个验证码是存在session中的
4、开启session方法 打开app/middleware.php 将里面的\think\middleware\SessionInit::class去掉注释
###tp6自带的一种初始化方法  固定写法 待验证
```
public function initialize()
{
   parent::initialize();
}
```
