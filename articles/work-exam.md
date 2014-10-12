-----
<!-- toc -->
##第一题
###描述
> * 这道题是10月11日京东笔试的笔试题
具体描述记不太清了，大概是这样的：给一个数n，输出一个最小的数m，使得m的各个位的乘积等于n。
例如: 输入36，输出49；输入100，输出455

###分析
> * 关键字：最小
拿到题之后我自己在草稿纸上画图分析，当时画了这样一个图
![此处输入图片的描述][1]
感觉这样就把所有的情况列举了出来，然后一步步算把最小的记录下来就行。
事实上这种方法是可以得到正确结果的，但明显是非常暴力的。
由于时间关系当时在卷子上实现的程序就是按照这个想法去写的。

> * 但是我回到家里越想越不对。明显这么做是一分都拿不到的。。。
仔细阅读了题目之后，发现题目要求的最小会是一个突破口。
于是有了下面的想法
divider从9开始，一直到1，看n能不能整除divider，如果能整除了，将rs的最低位写为divider，进行下一轮，如果某一轮divider到了1，返回-1。每次n=n/divider，直到n小于10。
比如126，
第一轮divider为9，有n=126/9=14  rs=9
第二轮divider为7，有n=14/7=2    rs=79 
n已经小于10了，rs=279 
目前来讲我认为这么做是最优的，如果各位有更好的方法欢迎交流。

###实现
```c++
#include <iostream>
using namespace std;
int func(int n){
    cout<<”call func “<<n<<endl;
    if(n>=1&&n<=9) 
        return n;
    int result=0;
    int tmp=0;
    int flag=0;
    for(int i=9;i>=2;i--){
        if(n%i==0){
            flag=1;
            tmp=n/i;
            if(tmp==1){
                result=i;
                break;
            }
            else{
                result=func(tmp)*10+i;
                break;
            }
        }       
    }
    if(flag&&result>0)
        return result;
    else 
        return -1;
}
int main(){
    cout<<func(36);
    return 0; 
}
```




[1]: http://soloimage-soloimage.stor.sinaapp.com/original/48d6ddd3b0f29a444df540cb94871a07.png
