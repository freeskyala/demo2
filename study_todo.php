T基础教程
——吴振宇
带*的要求理解并掌握
git clone 与 git init*
初始化仓库有两种情况，一种是直接在一个空目录里建立一个项目，这时候你可以这样干：
git init 这个目录就被git管理起来了
另一种是从其他机器复制一个仓库，比如这样
git clone git@github.com:ymt360/www.git

git remote 远程仓管*
如果你是从其他服务器复制过来的仓库，这个服务器地址会自动添加到你的仓库中，你可以这样查看：
git remote 只列出服务器端的别名，不会列出地址来
git remote -v  会列出地址
git remote add yugaohe git@github.com:codefor/www.git  添加对方的地址,yugaohe是别名 你也可以写 yugong 或者 dikfu 这样的。我们一亩田的远程仓库名约定为 upstream。
git remote rm yugaohe  删除于高禾这个远程仓库
修改远程仓库
git remote set-url origin URL  或者另一种方式 ： 先删除这个远程仓库 再add

GIT 跟踪文件的状态
•	Modified(working directory)：被修改过的文件
•	Staged(staging area)：通过git add添加到暂存区域的文件
•	Committed(git directory)：通过git commit提交到仓库的文件
可能有些人会觉得很奇怪，为什么git会有暂存区域这个概念，直接提交到仓库中不就ok了。其实这是git为了做版本控制用的，试想如果没有暂存区域，每修改一个文件，就会形成一个版本，太过频繁，不易于管理。暂存区域其实就是下一个版本的文件清单，你可以自由控制该往仓库中提交什么文件，这也可以避免在一个版本中包含一些中间文件，比如编译后的文件。

git add 与 git commit *
git add 将你写好的程序文件 或者修改的文件添加到git暂存区
通过git commit提交到仓库的文件  切记commit只提交被add的文件，之后会让你填写提交信息。
git commit -a  同上，一般你代码里只有modify状态下的文件可以直接使用这个命令，省去了 git add + 被修改文件 的步骤。
git add 文件之后 git commit -m ‘’  是直接填写这次提交的备注信息
git commit -a -m  是git commit -a,git commit -m的合版。懒人专用，上面已经说过，只会提交已经在版本库的文件，一般就是modify状态也就是只有修改的文件 直接使用这样的命令即可。

当你不小心，写错了提交的注视/信息，该如何处理呢。理论上，SCM是不应该修改历史的信息的，提交的注释也是。 
  不过在git中，其commit提供了一个--amend参数，可以修改最后一次提交的信息.但是如果你已经push过了，那么其历史最后一次，永远也不能修改了。



创建分支 与checkout*
创建分支:执行git branch <branchname>命令创建新分支
切换分支:执行git checkout <branchname>命令切换到新分支
git checkout -b <new_branch> [<start_point>] 
检出命令git checkout通过参数-b <new_branch> 实现了创建分支和切换分支两个动作的合二为一
git checkout 的还原作用：
git checkout + 文件名 是放弃文件的修改，还原到你远程仓库的最近版本。 也可以指定远程仓库。


git pull 与git fetch 和 git merge**
git fetch：相当于是从远程获取最新版本到本地，不会自动merge    
git fetch upstream develop
git log -p develop..upstream/develop
git merge origin/master
以上命令的含义：
首先从远程的upstream的develop开发支下载最新的版本到本地develop分支上
然后比较本地的develop分支和upstream/develop分支的差别
最后进行合并
上述过程其实可以用以下更清晰的方式来进行：
git fetch upstream develop:test
git diff test
git merge test
从远程获取最新的版本到本地的test分支上
之后再进行比较合并
2. git pull：相当于是从远程获取最新版本并merge到本地
git pull upstream develop
上述命令其实相当于git fetch 和 git merge
在实际使用中，git fetch更安全一些
因为在merge前，我们可以查看更新情况，然后再决定是否合并
git push 与流程**
开发完 合并完之后，你可能想提交你的代码到服务器上，这时候你要用push命令了：
git push upstream develop
但是我们一亩田的流程约定是不允许直接在develop分支开发的
我们从本地develop分支获取到最新的代码后 checkout -b 一个新分支 取名为feature-xxx
再push到你自己fork一亩田的远程仓库 然后提pull request要求上线 ，具体约定请看我们github上的 wiki文档。
假定你当前的分支为develop具体做法就是这样：
git pull upstream develp
git checkout -b feature-git-study
开发完
git pull upstream develop
git push origin feature-git-study    此origin是你自己fork的远程分支。

上面的命令就是把自己master的分支提交到名字为origin的服务器上

git reset  与 git revert 
HEAD的意思为对应当前的状态下的最后一次提交。HEAD对应索引
git reset [--hard|soft|mixed|merge|keep] [<commit>或HEAD]：
将当前的分支重设（reset）到指定的<commit>或者HEAD（默认，如果不显示指定commit，默认是HEAD，即最新的一次提交），并且根据[mode]有可能更新index和working directory。mode的取值可以是hard、soft、mixed、merged、keep。下http://blog.csdn.net/hudashi/article/details/7664464 具体可以查看这篇文章 下面说下我们程序中常用的操作。
reset是指将当前head的内容重置，不会留任何痕迹。
git reset --hard  去撤销这次修改 后面加版本号 可以回到那个版本下面。
但是这样做也有问题，可能之前本地的，没有提交的修改，都消失了。可以尝试git revert命令
revert是撤销某次提交，但是这次撤销也会作为一次新的提交进行保存这样就不会丢失原来修改过，但是没有提交的内容
git statsh 与 git statsh pop
开发人员常常遇到这种情况：花了几天时间一直在做一个新功能，已经 改了差不多十几个文件，突然有一个bug需要紧急解决，然后给一个build测试组。在Git问世之前基本上靠手动备份，费 时且容易出错。
git stash命令简而言之就是帮助开发人员暂时搁置当前已做的改动，倒退到改动前的状态，进行其他的必要操作（比如发布，或者解决一个bug，或者branch，等等），之后还可以重新载入之前搁置的改动，首先，用git add把所有的改动加到staging area。
git add .
接着用git stash把这些改动搁置。
git stash
到这里，当前工作平台就回复到改动之前了。该干嘛干嘛，此处省略1万字。
需要找回之前搁置的改动继续先前的工作了？
git stash apply 即可。
也可以用 git stash list 来查看所有的 搁置版本（可能搁置了很多次，最好不要这样，容易搞混）
在出现一个搁置栈的情况下，比如如果你想找回栈中的第2个，可以用 git stash apply stash@{1}
如果想找回第1个，可以用 git stash pop
如果想删除一个stash，git stash drop <id>
删除所有stash，git stash clear

git log*
git log为查看提交历史 如下显示
commit 16eb94854e73d9a8fd9762fba264b84a0f67e506
Author: yunnian <936321732@qq.com>
Date:   Fri Dec 5 04:24:41 2014 -0800
有版本号，有作者 有时间
git log -p -2
我们常用 -p 选项展开显示每次提交的内容差异，用 -2 则仅显示最近的两次更新：

   

查看远程分支
git branch 是查看本地分支和当前分支 加上-a参数可以查看远程分支，远程分支会用红色表示出来（如果你开了颜色支持的话）
git branch -a 所有
git branch -r 远程
删除远程分支和tag
git branch -d feature-xxx 是删除本地分支

在Git v1.7.0 之后，可以使用这种语法删除远程分支：
git push origin --delete  feature-xxx  删除 远程分支或者tag这么用。两个杠加delete.
否则，下面可以使用这种语法，推送一个空分支到远程分支，其实就相当于删除远程分支：
git push origin :feature-xxx 这是删除远程分支的另一种方法，推送一个空远程分支到远程：
git push origin :feature-xxx  删除远程分支
两种放法作用完全相同。
删除不存在对应远程分支的本地分支
假设这样一种情况：
1. 我创建了本地分支b1并push到远程分支 origin/b1；
2. 其他人在本地使用fetch或pull创建了本地的b1分支；
3. 我删除了 origin/b1 远程分支；
4. 其他人再次执行fetch或者pull并不会删除这个他们本地的 b1分支，运行 git branch -a 也不能看出这个branch被删除了，如何处理？
用 git remote show origin 查看远程分支状态 只要是stale状态的
使用 git remote prune origin 可以将其从本地版本库中去除。


git tag — 标签相关操作
标签可以针对某一时间点的版本做标记，常用于版本发布。
•	列出标签
git tag  在控制台打印出当前仓库的所有标签
git tag -l ‘v0.1.*’ 搜索符合模式的标签
•	打标签
git标签分为两种类型：轻量标签和附注标签。轻量标签是指向提交对象的引用，附注标签则是仓库中的一个独立对象。建议使用附注标签。
 创建轻量标签
 git tag v0.1.2-light
 创建附注标签
 git tag -a v0.1.2 -m “0.1.2版本”
创建轻量标签不需要传递参数，直接指定标签名称即可。
创建附注标签时，参数a即annotated的缩写，指定标签类型，后附标签名。参数m指定标签说明，说明信息会保存在标签对象中。
•	切换到标签
与切换分支命令相同，用git checkout [tagname]
查看标签信息
用git show命令可以查看标签的版本信息：
 git show v0.1.2
•	删除标签
误打或需要修改标签时，需要先将标签删除，再打新标签。
 git tag -d v0.1.2  删除标签
参数d即delete的缩写，意为删除其后指定的标签。
•	给指定的commit打标签
打标签不必要在head之上，也可在之前的版本上打，这需要你知道某个提交对象的校验和（通过git log获取）。
 补打标签
 git tag -a v0.1.1 9fbc3d0
•	标签发布
通常的git push不会将标签对象提交到git服务器，我们需要进行显式的操作：
 git push origin v0.1.2  将v0.1.2标签提交到git服务器
 git push origin –tags  将本地所有标签一次性提交到git服务器
 
注意：如果想看之前某个标签状态下的文件，可以这样操作
1.git tag   查看当前分支下的标签
2.git  checkout v0.21   此时会指向打v0.21标签时的代码状态，（但现在处于一个空的分支上）
3. cat  test.txt   查看某个文件







GIT 推荐配置
配置文件位置 ~/.gitconfig
[user]
    name = Fu Xu
    email = fuxu@fuxu.name
[http]
    sslverify = false
[core]
    editor = vim
[merge]
    tool = vimdiff
[diff]
    tool = vimdiff
[alias]
    br = branch
    ck = checkout
    co= commit
    st = status
[color]
    ui = true
[gui]
    encoding = utf-8
[difftool]
    prompt = false


