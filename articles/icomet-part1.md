# iComet代码粗解（1）
-----
<!-- toc -->
##初识iComet
iComet 是一个使用 C++ 语言开发的支持百万并发连接的 comet/push 服务器, 支持百万级并发连接, 内存占用少, 性能优越. 可用于移动 App 的 Push Server(消息推送服务器), 或者用于 Web Push(Web 服务器推). 用于 Web Push 时, 支持的浏览器和操作系统平台包括: Safari(iOS, Mac), Firefox/Chrome(Windows, Mac), IE6+
[iComet项目主页][1]，[GitHub地址][2]，在此感谢iComet的[作者ideawu][3]。

推荐各位在阅读以下内容之前看一下原作者之前的两篇Blog：
> * [构建C1000K的服务器(1) – 基础][4]
> * [构建C1000K的服务器(2) – 实现百万连接的comet服务器][5]

在阅读完两篇blog之后让我们先粗略的了解一下整个代码。

###subscriber.h & subscriber.cpp
> * 订阅者

###channel.h & channel.cpp
> * 通道，subscriber可以订阅通道，通道中有消息就会发过来

###server.h & server.cpp
> * server有多种连接策略，poll，iframe，stream

###Presence.h
> * 相应的presence.cpp在另一个文件夹中，而现有的comet-server中已经整合了之前的功能，presence是一个特殊的订阅者（我是这么理解的），它订阅所有channel的存在情况（用在IM上就可以理解为在线状态）

###comet-server.cpp
> * comet-server最终实现版本，暂且这里就列个TODO吧，理解不够深有点讲不清楚

##iComet结构 & API
###结构
![iComet大致结构][6]

每个Subscriber订阅一个Channel，每个Channel里有它的订阅者的链表。每个Channel被一个Server控制。

  [1]: http://www.ideawu.net/blog/icomet
  [2]: https://github.com/ideawu/icomet
  [3]: http://weibo.com/ideawu
  [4]: http://www.ideawu.net/blog/archives/740.html
  [5]: http://www.ideawu.net/blog/archives/742.html
  [6]: http://soloimage-soloimage.stor.sinaapp.com/original/776c88e46f39991731106860e78dd268.png
