#redis安装
###参考网址：https://www.cnblogs.com/hunanzp/p/12304622.html
###进入官网找到下载地址 https://redis.io/download

```
1、wget http://download.redis.io/releases/redis-5.0.7.tar.gz
2、tar -zvxf redis-5.0.7.tar.gz
3、make
4、make PREFIX=/usr/local/redis install
5、将解压目录里的redis.conf 复制到 安装目录 cp redis.conf /usr/local/redis
6、前端模式启动redis 
6-1、cd /usr/local/redis/bin
6-2、./redis-server
7、后端启动 修改redis.conf文件里 daemonize on 为 daemonize yes
7-1、cd /usr/local/redis
7-2、./bin/redis-server ./redis.conf
7-3、 ps -ef | grep -i redis 查看是否启动
8、停止redis cd /usr/local/redis   ./bin/redis-cli shutdown
9、进入redis命令模式 就如mysql -u root -p后的模式  cd /usr/local/redis   ./bin/redis-cli
```
#php redis扩展 可用php -m 查看安装了哪些扩展
### 检查phpize与php-config是否安装 可用命令which phpize以及 which php-config查看
### 如果没有安装可用命令 yum install php-devel安装
###下载 
```
1、wget https://github.com/phpredis/phpredis/archive/develop.zip
2、unzip develop.zip
3、cd phpredis-develop
4、phpize
4、./configure --with-php-config=/usr/local/php7.2/bin/php-config
5、make
6、make install
7、寻找php.ini 可用命令 php --php.ini
8、最后一行加入 extension=redis.so
9、php -m 检测redis扩展是否安装成功
```