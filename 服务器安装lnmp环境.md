#准备阶段 参考链接：http://www.jingfengshi.com/article/40
###关闭防火墙
`service iptables stop`
###关闭 selinux
`setenforce 0` #使配置立即生效
###安装约定
软件源码包存放位置： /usr/local/src  
源码包编译安装位置： /usr/local/软件名  
数据库文件存储路径： /data/mysql  
###安装编译工具及库文件
使用 centos yum 命令 一键安装
`yum install -y  apr*  autoconf  automake  gcc  gcc-c++ cmake gtk+-devel  libcurl-devel  zlib-devel  openssl openssl-devel  pcre pcre-devel gd kernel  keyutils  patch  perl  kernel-headers  compat* cpp glibc  libgomp  libstdc++-devel  keyutils-libs-devel  libsepol-devel  libselinux-devel krb5-devel libXpm*  freetype-devel fontconfig  fontconfig-devel  libjpeg*  php-gd  gettext  gettext-devel  ncurses*  libtool*  libxml2  libxml2-devel  patch  policycoreutils bison  libpng libpng-devel`
#软件安装
###安装nginx  下载地址：http://nginx.org/download/
  `useradd  www -s /sbin/nologin`   #创建nginx 运行账户 www,不允许直接登陆系统  
  `cd /usr/local/src`  
  `tar -zxvf  nginx.tar.gz`  
  `cd nginx`
#####安装选项
  `./configure  --prefix=/usr/local/nginx  --without-http_memcached_module --user=www --group=www  --with-http_stub_status_module  --with-http_ssl_module
  make  && make install`
#####设置nginx开启启动
  `cp  /usr/local/nginx  /etc/rc.d/init.d/ `#拷贝启动文件，关于启动文件，会另起一篇文章  
  `chmod 775 /etc/rc.d/init.d/nginx`  #赋予文件执行权限  
  `chkconfig  nginx on`  #设置开启启动  
  `service  nginx start ` #启动niginx
#####如果启动报错 Failed to start nginx.service:unit not found
1、在/etc/init.d/目录下新建文件，文件名为nginx  
2、在nginx文件中加入以下代码
```
#!/bin/sh
# nginx - this script starts and stops the nginx daemin
#
# chkconfig:   - 85 15

# description:  Nginx is an HTTP(S) server, HTTP(S) reverse \
#               proxy and IMAP/POP3 proxy server

# processname: nginx
# config:      /usr/local/nginx/conf/nginx.conf
# pidfile:     /usr/local/nginx/logs/nginx.pid

# Source function library.

. /etc/rc.d/init.d/functions

# Source networking configuration.

. /etc/sysconfig/network

# Check that networking is up.

[ "$NETWORKING" = "no" ] && exit 0

nginx="/usr/local/nginx/sbin/nginx"

prog=$(basename $nginx)

NGINX_CONF_FILE="/usr/local/nginx/conf/nginx.conf"

lockfile=/var/lock/subsys/nginx

start() {

    [ -x $nginx ] || exit 5

    [ -f $NGINX_CONF_FILE ] || exit 6

    echo -n $"Starting $prog: "

    daemon $nginx -c $NGINX_CONF_FILE

    retval=$?

    echo

    [ $retval -eq 0 ] && touch $lockfile

    return $retval

}


stop() {

    echo -n $"Stopping $prog: "

    killproc $prog -QUIT

    retval=$?

    echo

    [ $retval -eq 0 ] && rm -f $lockfile

    return $retval

}



restart() {

    configtest || return $?

    stop

    start

}


reload() {

    configtest || return $?

    echo -n $"Reloading $prog: "

    killproc $nginx -HUP

    RETVAL=$?

    echo

}

force_reload() {

    restart

}


configtest() {

  $nginx -t -c $NGINX_CONF_FILE

}



rh_status() {

    status $prog

}


rh_status_q() {

    rh_status >/dev/null 2>&1

}

case "$1" in

    start)

        rh_status_q && exit 0
        $1
        ;;

    stop)


        rh_status_q || exit 0
        $1
        ;;

    restart|configtest)
        $1
        ;;

    reload)
        rh_status_q || exit 7
        $1
        ;;


    force-reload)
        force_reload
        ;;
    status)
        rh_status
        ;;


    condrestart|try-restart)

        rh_status_q || exit 0
            ;;

    *)

        echo $"Usage: $0 {start|stop|status|restart|condrestart|try-restart|reload|force-reload|configtest}"
        exit 2

esac
```
3、进入此目录 `cd /etc/init.d`  
4、依此执行以下命令  
`chmod 755 /etc/init.d/nginx`
`chkconfig --add nginx`  
5、开启nginx  
`service nginx start`
#####如果启动继续报错，执行下面命令 env: /etc/init.d/nginx: No such file or directory
`dos2unix /etc/init.d/nginx`
#####设置 nginx开机启动 当时没有成功
`cp /usr/local/src/nginx  /etc/rc.d/init.d/ ` #拷贝启动文件  
`chmod 775  /etc/rc.d/init.d/nginx   `#赋予文件执行权限  
`chkconfig  nginx on  `#设置开机启动  
`service  nginx  start  `#启动nginx
###安装mysql Operating System:选择Source Code 下载地址：https://downloads.mysql.com/archives/community/  
#####开始安装 参考链接：https://www.centoschina.cn/server/sql/mysql/9204.html
1、下载mysql  
2、下载boost 地址：http://www.boost.org/users/download/  
`wget --no-check-certificate http://sourceforge.net/projects/boost/files/boost/1.59.0/boost_1_59_0.tar.gz`  
3、安装必要的软件依赖  
`yum install -y cmake bison bison-devel libaio-devel gcc gcc-c++ git  ncurses-devel`  
4、解压  
`tar -zxvf mysql-5.7.20.tar.gz`  
5、将boost的压缩包移动至解压后的源文件目录内  
`mv boost_1_65_1.tar.gz mysql-5.7.20`
6、进入MySQL源文件目录，新建configure做为编译目录，并进入该目录  
`cd mysql-5.7.20`  
`mkdir configure`  
`cd configure`  
7、使用cmake进行生成编译环境  
#####这里需要注意的是mysql安装目录这里可以设置 想安装在哪直接改就行
`-DCMAKE_INSTALL_PREFIX=/var/mysql/ \`
`-DINSTALL_PLUGINDIR="/var/mysql/lib/plugin" \`
####生成环境运行代码如下
```
cmake .. -DBUILD_CONFIG=mysql_release \
-DINSTALL_LAYOUT=STANDALONE \
-DCMAKE_BUILD_TYPE=RelWithDebInfo \
-DENABLE_DTRACE=OFF \
-DWITH_EMBEDDED_SERVER=OFF \
-DWITH_INNODB_MEMCACHED=ON \
-DWITH_SSL=bundled \
-DWITH_ZLIB=system \
-DWITH_PAM=ON \
-DCMAKE_INSTALL_PREFIX=/var/mysql/ \
-DINSTALL_PLUGINDIR="/var/mysql/lib/plugin" \
-DDEFAULT_CHARSET=utf8 \
-DDEFAULT_COLLATION=utf8_general_ci \
-DWITH_EDITLINE=bundled \
-DFEATURE_SET=community \
-DCOMPILATION_COMMENT="MySQL Server (GPL)" \
-DWITH_DEBUG=OFF \
-DWITH_BOOST=..
```
#####如果编译出现错误，请先删除CMakeCache.txt后，再重新编译
#####如果出现下面的提示就表示成功生成了编译环境
`-- Configuring done`  
`-- Generating done`  
8、执行`make && make install`
#####安装成功后 需要做以下配置
1、添加mysql用户 `useradd -s /sbin/nologin mysql`  
2、新建数据库文件夹及日志文件夹，并更改用户为mysql  以下路径皆可自定义
```
mkdir /mysql_data
mkdir /var/mysql/log
chown -R mysql:mysql /mysql_data/
chown -R mysql:mysql /var/mysql/log
```
3、修改配置文件如果目录没有my.cnf 看有没有my.cnf.其它后缀的文件 直接将其重命名 my.cnf   将[mysqld]项下的内容替换为
```
[mysqld]
port=3306
datadir=/mysql_data #这个是编译时 设置的安装目录
log_error=/var/mysql/log/error.log#这个是自定义的日志目录
basedir=/var/mysql/#这个是自定义的数据库文件夹
```
4、初始化数据库 `/var/mysql/bin/mysqld  --initialize --user=mysql`  
####配置启动文件
1、从模板文件中复制启动文件  
`cp /var/mysql/support-files/mysql.server /etc/init.d/mysqld`  
2、修改启动文件  
`vim /etc/init.d/mysqld`修改为  
```
basedir=/var/mysql/#数据库安装地址
datadir=/mysql_data#数据库文件夹
```
3、设置软链 ` ln -s 数据库安装目录/bin/mysql /usr/bin`  
4、启动mysql `service mysql start`或者`/etc/init.d/mysqld start`  
5、设置MySQL开机自动启动 `systemctl enable mysqld`  
6、配置MySQL环境变量  
`vim /root/.bash_profile`  
将 `PATH=$PATH:$HOME/bin`修改为`PATH=$PATH:$HOME/bin:/数据库安装目录/bin`
#####修改root的初始密码
查看root的初始密码  MySQL从5.7开始不支持安装后使用空密码进行登录，因此在这里需要先查询程序生成的临时密码  
`cat /数据库安装目录/log/error.log |grep 'A temporary password'`  
1、登录数据库 `mysql -uroot -p`  
2、修改密码 `alter user 'root'@'localhost' identified by '密码';`  
###安装php 下载地址非官方：https://museum.php.net/ https://windows.php.net/downloads/releases/archives/
1、安装 libmcrypt扩展  
```
wget https://sourceforge.net/projects/mcrypt/files/Libmcrypt/2.5.8/libmcrypt-2.5.8.tar.gz
cd /usr/local/src  
tar zxvf libmcrypt-2.5.8.tar.gz  
cd libmcrypt-2.5.8
./configure
make && make install
```
2、解压 `tar zxvf php.tar.gz`  
3、`cd php `开始编译,涉及很多路径 正确填写 运行出现错误 根据提示安装所需扩展   
```
./configure --prefix=/usr/local/php7.1 --with-config-file-path=/usr/local/php7.1/etc --with-mysqli=/usr/local/mysql/bin/mysql_config  --enable-mysqlnd --with-mysql-sock=/usr/local/mysql/mysql.sock  --with-gd  --with-iconv  --with-zlib  --enable-xml  --enable-bcmath  --enable-shmop --enable-sysvsem --enable-inline-optimization  --enable-mbregex  --enable-fpm  --enable-mbstring  --enable-ftp --enable-gd-native-ttf  --with-openssl  --enable-pcntl  --enable-sockets  --with-xmlrpc --enable-zip  --enable-soap  --without-pear  --with-gettext --enable-session --with-mcrypt  --with-curl --with-jpeg-dir  --with-freetype-dir  --with-pdo-mysql=/usr/local/mysql/
```
4、`make && make install ` #安装  
5、进行相关配置 以下安装时选择忽略吧 有需要的时候在做相应处理 
`cp php.ini-production  /usr/local/php7.1/etc/php.ini`  #复制php配置文件到安装目录  
`rm -rf /etc/php.ini ` #删除系统自带配置文件  
`ln -s /usr/local/php7.1/etc/php.ini  /etc/php.ini `  #添加软连接  
`cp  /usr/local/php7.1/etc/php-fpm.conf.default  /usr/local/php7.1/etc/php-fpm.conf`  #拷贝模板配置文件为php-fpm的配置文件  
修改：`/usr/local/php7.1/etc/php-fpm.conf`  
`pid=/run/php-fpm.pid` #取消前面的分号  
`cp /usr/local/php7.1/etc/php-fpm.d/www.conf.default  /usr/local/php7.1/etc/php-fpm.d/www.conf`  
修改：`/usr/local/php7.1/etc/php-fpm.d/www.conf`  
`user=www #设置php-fpm 运行账号为www`  
`group=www #设置php-fpm运行组为www`  
#####设置 php-fpm 开机启动
```
cp sapi/fpm/init.d.php-fpm  /etc/rc.d/init.d/php-fpm #拷贝php-fpm到启动目录
chmod +x /etc/rc.d/init.d/php-fpm  #添加执行权限
chkconfig php-fpm on #设置开机启动
service php-fpm start #启动php-fpm
```
6、配置nginx文件 以及conf/vhost 文件  
#####nginx.conf
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
        include vhosts/*.conf;
}
```
#####vhosts下的配置文件
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
#多版本php 参考地址：https://www.cnblogs.com/starfish29/archive/2004/01/13/10722149.html
1、下载需要的php版本进行上面php安装1-4步  
2、此时启动该版本php  /usr/local/php71/sbin/php-fpm 应该会报错  
3、进行以下修改
```
首先进入 /usr/local/php71/etc目录
cp php-fpm.conf.default php-fpm.conf
然后进入 /usr/local/php71/etc/php-fpm.d目录
cp www.conf.default www.conf
vim www.conf
将listen = 127.0.0.1:9000 改成其它端口 比如listen = 127.0.0.1:9001
在运行/usr/local/php71/sbin/php-fpm
ps -aux | grep php 看是否有两个版本的php启动
```




