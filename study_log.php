111111111111
111111111111
222222222222

一 安装 设置git
yum -y install git-all.noarch
git config --global user.name 'good2'
git config --global user.email 'woshitongliang@126.com'


克隆的两种方式
https


1 ssh这个快 
先去https://github.com/new 新建一个项目
设置与linux对应的ssh key 
生成key 会让你写密码 默认回车就行
ssh-keygen
获取key
cat /root/.ssh/id_rsa.pub  
git上添加key 
https://github.com/settings/ssh

把线上的项目clone到本地 这个时间已经有管理了
git clone git@github.com:freeskyala/demo2.git
查看这个项目有多少个仓库
git remote -v
origin 自己的代码 git@github.com:freeskyala/demo2.git (fetch) 
origin	git@github.com:freeskyala/demo2.git (push)

touch demo.php
git status
# On branch master
# Untracked files:
#   (use "git add <file>..." to include in what will be committed)
#
#	demo.php
nothing added to commit but untracked files present (use "git add" to track)

先添加这个文件给git
git add demo.php
常后查看一下这个文件的状态
git status
# On branch master
# Changes to be committed:
#   (use "git reset HEAD <file>..." to unstage)
#
#	new file:   demo.php
#

恢复之前的一个状态
git reset HEAD


添加一个文件
git commit
[master 7560d05] 我是来描述demo.php来干嘛的 我就是一个注释吧 哈哈
 1 files changed, 7 insertions(+), 0 deletions(-)
 create mode 100644 demo.php
 
 简写
 git commit -m 'sssss'
 
git commit -a 'sssss'

 
常看用户当前的分支
git branch
* master

把本地文件推到线上demo2这个项目里
git push origin master

创建一个本地分支并且切换到那个分支下
git branch tongliang git checkout tongliang  = git checkout -b tongliang  
 


git branch -a 所有
git branch -r 远程


git log -p -3最近三次的

提交本次版本
[root@good2 demo2]# git commit -a -m 'del'
[tongliang 1ebddc3] del
 4 files changed, 0 insertions(+), 216 deletions(-)
 delete mode 100644 LICENSE
 delete mode 100644 demo.php
 delete mode 100644 git.php
 delete mode 100644 test.php
[root@good2 demo2]# git push origin tongliang



新建一个文件夹 study
让git管理这个文件夹
git init 
git status 查看一下这个管量的情况
# On branch master 分支名称
#
# Initial commit 
#
nothing to commit (create/copy files and use "git add" to track)

