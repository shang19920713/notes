#参考网址：https://blog.csdn.net/u010404725/article/details/91041688
#安装mysql
`brew search mysql`  
`brew install mysql@5.6`
###安装成功之后 启动mysql
`brew services start mysql@5.6`
###因为用的是zsh所以需要设置一下软链
`cd /usr/local/bin/`  
`sudo ln -fs /usr/local/opt/mysql@5.6/bin/mysql mysql` 
####或者 下面当时没成功
`echo 'export PATH="/usr/local/opt/mysql@5.6/bin:$PATH"' >> ~/.zshrc`  
`source ~/.zshrc `
###进入mysql  密码为空，直接回车就行 
`mysql -uroot -p `
###修改密码
`SET PASSWORD = PASSWORD('123456');`
#安装nginx
`brew install nginx`  
###打开 nginx
`sudo nginx`
###重新加载配置|重启|停止|退出 nginx
`nginx -s reload|reopen|stop|quit`
###测试配置是否有语法错误
`nginx -t`
#安装php
`brew search php`  
`brew install php@7.1`
###(因为是zsh 所以需要 可能安装时有提示)
`echo 'export PATH="/usr/local/opt/php@7.1/bin:$PATH"' >> ~/.zshrc`    
`source ~/.zshrc`
###启动php@7.1 php-fpm 
`brew services start php@7.1`
###直接用php-fpm启动的方法
`cd /usr/local/etc/php/7.1`  
`sudo cp php-fpm.conf /private/etc`  
`sudo mkdir -p /usr/var/log`  
`sudo touch  /usr/var/log/php-fpm.log`
#修改nginx配置 是其能运行php 实际操作是 修改nginx.conf servers下建立了一个.conf文件  
#操作位置在/usr/local/etc
###nginx.conf
```
worker_processes  1;  
events {
    worker_connections  1024;
}
http {
        include       mime.types;
        default_type  application/octet-stream;
        sendfile        on; 
        keepalive_timeout  65; 
        include servers/*.conf;
}
```
###servers下的配置文件
```
server {  
    listen 8100;  
    root    /home/shengbao.shang/zhangyi_op/public;  
    index index.php;  
    access_log  /home/shengbao.shang/logs/zhangyi_op/access.log;  
    error_log   /home/shengbao.shang/logs/zhangyi_op/error.log;  
    client_max_body_size    30M;  
    client_body_buffer_size 30M;  
    location ~ .*\.(gif|jpg|jpeg|png|bmp|swf|flv|ico|woff|svg)$ {  
        rewrite ^/dms/(.*)$ /$1 last;  
        expires 30d;  
    }  
    location ~ .*\.(js|css)?$ {  
        rewrite ^/dms/(.*)$ /$1 last;  
        expires 1d;  
    }  
    location ~ \.php$ {  
        root  /home/shengbao.shang/zhangyi_op/public;  
        fastcgi_pass   127.0.0.1:9000;  
        fastcgi_index  index.php;  
        fastcgi_param  SCRIPT_FILENAME  $document_root$fastcgi_script_name;  
        include        fastcgi_params;  
    }  
    location  / {  
       #下面这个if 是tp6框架所需 其它的框架不加  
        if (!-e $request_filename) {  
         rewrite  ^(.*)$  /index.php?s=/$1  last;  
        }  
    }  
    location ~ ^(.*)/\.svn/{  
        deny all;  
    }  
}
```

#安装多版本php
###如果brew search php没有想要的php版本可以通过下个命令将php老版本找回
`brew tap exolnet/homebrew-deprecated`




