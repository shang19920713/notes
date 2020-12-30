#查看nginx配置文件：
`ps -ef | grep nginx`
#文件上传下载
###把本地的source.txt文件拷贝到192.168.0.10机器上的/home/work目录下
`scp /home/work/source.txt work@192.168.0.10:/home/work/` 
###把192.168.0.10机器上的source.txt文件拷贝到本地的/home/work目录下
`scp work@192.168.0.10:/home/work/source.txt /home/work/`
###把192.168.0.10机器上的source.txt文件拷贝到192.168.0.11机器的/home/work目录下
`scp work@192.168.0.10:/home/work/source.txt work@192.168.0.11:/home/work/ `
###拷贝文件夹，加-r参数
`scp -r /home/work/sourcedir work@192.168.0.10:/home/work/`
#删除文件夹或者文件
`rm -rf 文件名//强制删除 -r为询问删除`
#文件软链 将/home/shengbao.shang/zhangyi_op/shengbao_shang.conf 文件建立软链 到/usr/local/nginx/config/vhost/shengbao_shang.conf文件
###注意：比如想把/home/shengbao.shang/123.conf 建立软链到vhost下命令应该这样写
`ln -s /home/shengbao.shang/123.conf /usr/local/nginx/conf/vhost`  
###不应该这样写
`ln -s /home/shengbao.shang/123.conf /usr/local/nginx/conf/vhost/123.conf`  
#用户相关
##添加用户：root权限下 
`添加用户: useradd -m 用户名`
`设置密码: passwd 用户名`
`删除用户: userdel -r 用户名`
`切换用户的命令为：su username`
`切换到root用户：sudo -i`
#权限修改
`chmod -Rf 777 /home/shengbao.shang/zhangyi_op/runtime/`
`chmod -Rf 755 /home/shengbao.shang/`
#寻找文件
`find / -name 文件名`
#重启PHP
`service php-fpm restart`
#nginx服务器重启
`service nginx restart`
#如何在linux下查看目录的剩余空间大小 
###https://www.cnblogs.com/zknublx/p/9174448.html 
`命令格式：df -hl`
#linux设置ssh
`vim /etc/ssh/sshd_config ` 
`service sshd restart`
#linux 安装ffmpeg
`https://www.cnblogs.com/lpyan/p/9015890.html`  
`https://blog.csdn.net/yzhang6_10/article/details/75635734`
#服务器如果不能联网可以试试
`vi /etc/sysconfig/network-scripts/ifcfg-eth0（每个机子都可能不一样，但格式会是“ifcfg-eth数字”），把ONBOOT=no，改为ONBOOT=yes`  
`重启网络：service network restart`
#-bash: nginx: command not found
```
1、vim /etc/profile
2、环境变量里加入nginx安装目录 例如
export PATH=$PATH:/usr/local/mysql/bin:/usr/local/nginx/sbin
3、source /etc/profile 让配置文件重新生效
```
#设置开机启动应该是在/etc/rc.local文件，加入需要设置的运行路径即可
#开放端口 出现FirewallD is not running 需要开启防火墙
```
1、开启防火墙 
    systemctl start firewalld
2、开放指定端口
      firewall-cmd --zone=public --add-port=1935/tcp --permanent
 命令含义：
--zone #作用域
--add-port=1935/tcp  #添加端口，格式为：端口/通讯协议
--permanent  #永久生效，没有此参数重启后失效
3、重启防火墙
      firewall-cmd --reload
4、查看端口号
netstat -ntlp   //查看当前所有tcp端口·
netstat -ntulp | grep 1935   //查看所有1935端口使用情况
```
#虚拟机设置共享文件夹 
`1、进入sss目录`  
`2、mount -t vboxsf www（共享文件名） sss（存入共享文件目录）`  
#查看进程https://www.linuxprobe.com/12linux-process-commands.html
`ps -aux |grep - #列出所有进程`  
`ps -aux |grep nginx #列出指定进程`   
