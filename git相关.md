#git创建
`git --bare init`  
`git pull origin master`
#git add出现：The file will have its original line endings in your working directory
`git rm -r --cached .`  
`git config core.autocrlf false`  
`git add .`
#error: Your local changes to the following files would be overwritten by merge:
###1、服务器代码合并本地代码
`git stash //暂存当前正在进行的工作`。  
`git pull origin master //拉取服务器的代码`  
`git stash pop //合并暂存的代码`
###2、服务器代码覆盖本地代码
`git reset --hard`  
`git pull origin master`
#首次提交需要设置用户名以及邮箱
git config --global user.name "用户名"  
git config --global user.email "邮箱名"  
#git pull 报错：insufficient permission for adding an object to repository database .git/objects
```
进入项目.git/objects下
sudo chgrp -R shengbao.shang(用户组名) .
sudo chmod -R g+rwX .
```
