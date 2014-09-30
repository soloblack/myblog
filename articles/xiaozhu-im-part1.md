# 小猪短租IM整体架构及实现

------
<!-- toc -->

##IM现状及需求
网站业务逻辑复杂，面对即将上线的IOS,Android的房东以及房客客户端，IM Server将面临巨大的压力，所以需要对现有IM架构进行调整。

###IM现状
IM现状有两个Server：
> * 与无线端通信使用开源的[XMPP协议](http://zh.wikipedia.org/wiki/XMPP)使用XMPP Server
> * 与WebIM端和HTML5端使用JSON数据格式进行通讯，使用[Pushlets](http://en.wikipedia.org/wiki/Push_technology)，开源地址[Pushlets](http://www.pushlets.com/)

两个Server之间还需要互相通信

###IM需求

####业务需求

目前来讲消息来源主要有6个：
> * WebIM
> * HTML5 IM
> * IOS房东客户端
> * IOS房客客户端
> * Android房东客户端
> * Android房客客户端

消息的类型主要有3种:
> * 提醒
> * 消息
> * 心跳 (heartbeat)

####性能需求
现状日均消息量1w+，并发量不高，但是为了以后扩展方便，需要解决高并发的问题，并且使新的服务器支持分布式。[C1000K问题](http://www.ideawu.net/blog/tag/c1000k)
需要无阻塞的通信框架，对于IO操作需要谨慎。

##IM架构
###业界案例
参考几个大网站的架构，例如Facebook、淘宝、赶集、陌陌等

FaceBook IM架构
![FaceBook IM][1]

淘宝 IM架构
![淘宝IM架构][2]

赶集 IM架构
![赶集IM架构][3]

陌陌 IM架构
![陌陌IM架构][4]

###本次修改
小猪新老架构，橙色为新的架构（还未完全设计完成，涉及业务逻辑比较复杂，所以需要对现有版本做兼容）
![小猪新老架构][5]

##具体实现
Comet Server 使用了开源项目iComet进行二次开发，[iComet项目主页][6]，[GitHub地址][7]
在此感谢iComet的[作者ideawu][8]。

###介绍iComet
iComet 是一个使用 C++ 语言开发的支持百万并发连接的 comet/push 服务器, 支持百万级并发连接, 内存占用少, 性能优越. 可用于移动 App 的 Push Server(消息推送服务器), 或者用于 Web Push(Web 服务器推). 用于 Web Push 时, 支持的浏览器和操作系统平台包括: Safari(iOS, Mac), Firefox/Chrome(Windows, Mac), IE6+
###iComet的工作流程
![iComet的工作流程][9]
###对于iComet二次开发的修改点
> * 对于在线状态的修改，iComet支持订阅在线状态，但是不符合业务需求
> * 对于好友关系的维护，预期是在Web Tier中用PHP实现，它的功能是维护好友关系并且把用户在线状态，好友关系状态都放到队列去，然后定期执行队列里的命令，放到数据库。
> * 对于离线消息，iComet放到内存里没有进行持久化，在改版中要进行持久化。
> * 对于消息的格式需要根据业务进行一定的修改。

  [1]: http://soloimage-soloimage.stor.sinaapp.com/original/2e778b0b5e475a601538405d4ff4192b.png
  [2]: http://soloimage-soloimage.stor.sinaapp.com/original/9bc6a8296234d35568075839eafc6fa7.png
  [3]: http://soloimage-soloimage.stor.sinaapp.com/original/80929ad6e0db38e08b37878cbb182ee6.png
  [4]: http://soloimage-soloimage.stor.sinaapp.com/original/b5297a8901fce67dce42d4e88dea685e.png
  [5]: http://soloimage-soloimage.stor.sinaapp.com/original/b5b58cf1432c1ddc1f5c13d853450386.png
  [6]: http://www.ideawu.net/blog/icomet
  [7]: https://github.com/ideawu/icomet
  [8]: http://weibo.com/ideawu
  [9]: http://soloimage-soloimage.stor.sinaapp.com/original/6e62787cf161ffb3ddfee69e78a4a589.png
