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
`ln -s /home/shengbao.shang/zhangyi_op/shengbao_shang.conf shengbao_shang.conf`
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
#查看端口
`netstat -aptn 查看所有开启的端口号`
#服务器如果不能联网可以试试
`vi /etc/sysconfig/network-scripts/ifcfg-eth0（每个机子都可能不一样，但格式会是“ifcfg-eth数字”），把ONBOOT=no，改为ONBOOT=yes`  
`重启网络：service network restart`








