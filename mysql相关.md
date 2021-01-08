#导出数据库
`mysqldump -u root -p DMSManage> /home/mysqlbackup.sql（数据库名与>之间不能有空格）`
#数据库导入
##第一步登录
`mysql -h 主机地址 -u 用户名 -p`
##第二步在服务器里登录到数据库里 ，使用某个库，gtmc代表数据库名称
`use gtmc`
##第三步覆盖数据库，xxx.sql文件需要先上传上去
`source /root/xxx.sql`
#修改某字段属性
`ALTER TABLE ugc_program MODIFY real_audiopath VARCHAR(200)NULL`
`查询表-字段个数`
`SELECT count(1) from information_schema.COLUMNS WHERE table_schema='cgkb1库名' and table_name='yy_info表名';`
#新增字段
`ALTER TABLE `y_system_admin` ADD  `status` tinyint(2) NOT NULL DEFAULT 0 COMMENT '状态 0待审核 1审核通过 2审核未通过';`  
