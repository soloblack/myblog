-----
<!-- toc -->
##第一题
###描述
> 这道题是10月11日京东笔试的笔试题
具体描述记不太清了，大概是这样的：给一个数n，输出一个最小的数m，使得m的各个位的乘积等于n。
例如: 输入36，输出49；输入100，输出455

###分析
关键字：最小
拿到题之后我自己在草稿纸上画图分析，当时画了这样一个图
![此处输入图片的描述][1]
感觉这样就把所有的情况列举了出来，然后一步步算把最小的记录下来就行。
事实上这种方法是可以得到正确结果的，但明显是非常暴力的。
由于时间关系当时在卷子上实现的程序就是按照这个想法去写的。

但是我回到家里越想越不对。明显这么做是一分都拿不到的。。。
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

##第二题
###描述
给定一个数组a[N]，我们希望构造数组b[N]，其中b[i]=a\[0\]\*a\[1\]\*...\*a\[N-1\]/a\[i\]。
在构造过程中
> 不允许使用除法；
> 要求O(1)的空间复杂度和O(n)的时间复杂度；
> 除去遍历计数器与a[N]、b[N]外，不可使用新的变量（包括但不限于栈临时变量、堆空间和全局静态变量等）
本题来自新浪微博

###分析
乍一看这个题没有什么难的，可是在笔试过程中我足足想了大概20分钟。
拿到题目分析得出
b\[0\] = a\[0\]^0 \* a\[1\]^1 \* a\[2\] \*...a\[N-1\]^1;
b\[1\] = a\[0\]^1 \* a\[1\]^0 \* a\[2\] \*...a\[N-1\]^1;
......
b\[N-1\] = a\[0\]^1 \* a\[1\]^1 \* a\[2\] \*...a\[N-1\]^0;
若N=8,由此可得矩阵
$$
\begin{matrix}
0 & 1 & 1 & 1 & 1 & 1 & 1 & 1\\\\
1 & 0 & 1 & 1 & 1 & 1 & 1 & 1\\\\
1 & 1 & 0 & 1 & 1 & 1 & 1 & 1\\\\
1 & 1 & 1 & 0 & 1 & 1 & 1 & 1\\\\
1 & 1 & 1 & 1 & 0 & 1 & 1 & 1\\\\
1 & 1 & 1 & 1 & 1 & 0 & 1 & 1\\\\
1 & 1 & 1 & 1 & 1 & 1 & 0 & 1\\\\
1 & 1 & 1 & 1 & 1 & 1 & 1 & 0\\\\
\end{matrix}
$$
根据题目要求，空间复杂度O(1)，时间复杂度O(N)
以0为分割线看这个矩阵可以分析得出
（注:b\_left为0左边的值 b\_right为0右边的值 并且b\_left\[\]和b\_\[\]right初始化为1）
b\_left\[1\]    = b\_left\[0\] \* a\[0\] \* b\_right\[1\];
b\_right\[N-2\] = b\_right\[N-1\] \* a\_\[N-1\] \* b\_left\[N-2\];
...
b\_left\[N-1\]    = b\_left\[N-2\] \* a\[N-2\] \* b\_right\[N-1\];
b\_right\[0\] = b\_right\[1\] \* a\_\[1\] \* b\_left\[0\];
进行到这里就发现了。我们需要一个大小为n的空间啊
可是题目不让啊。。。这怎么办呢。。。
我在考试的时候那个版本是错的，现在这个马上就要展示的版本是我好基友想出来的。
计算的思想和上边讲的一样
只不过在空间的利用上巧妙了一些。说白了就是看破了对角线这两个
b\_left\[0\]=a\[0\]^0
b\_right\[N-1\]=a\[N-1\]^0
这两个值永远是1
所以我们可以利用他们的空间，随便用上一个这个问题就解决了
Talk is cheap , show you the code
最后唠叨一下。我觉得这题这么出真的没啥意义。

###实现
```c++
#include <iostream>
#define length 8
using namespace std;
int main(){
	int N=length;
	int a[length]={
		1,2,3,4,5,6,7,8
	};
	int b[length];
	for(int i = 0;i<length;i++){
		b[i]=1;
	}
	for(int i=length-2;i>=0;i--){
		b[i]=b[i+1]*a[i+1];
	}
	for(int i=1;i<length-1;i++){
		a[i]=a[i-1]*a[i];
	}
	for(int i=length-1;i>0;i--){
		a[i]=a[i-1];
	}
	a[0]=1; //这里利用的是 b\_left\[0\]=a\[0\]^0
	for(int i=0;i<length;i++){
		cout<<i<<" "<<a[i]<<" "<<b[i]<<" "<<a[i]*b[i]<<endl;
	}
}
```
##第三题
###描述
> 这个题目很朴素，两个排好序的数组，高效地找出相同的数

###分析
正式开始自我吐槽，当时做这个题的时候脑子一定是让驴踢了。满脑子的二分递归递归二分的。
直接导致了我把两个数组二分成四个部分，然后根据a[half]和b[half]的值来进行递归计算。
假定数组A的长度为M，B的长度为N，如果不剪枝，时间复杂度为惊人的O(3^(ln(max(M,N))/ln(2))
我写完了还觉得挺开心。。。真是学的太死了。最近做题都有些模板化了，不怎么动脑子去想。总是用感觉指导自己。

哎。来说一下正确的思路。
既然是排序好的数组那我们用两个指针来遍历数组，Code大概是这样的
```c++
bool find_same_num(int a[], int a_length, int b[], int b_length)
{
     int i=0,j=0;
     while(i<a_length && j<b_length)
     {
          if(a[i]==b[j])
               return true;
          if(a[i]>b[j])
               j++;
          if(a[i]<b[j])
               i++;
     }
     return false;
}
```
多么朴素的方法，时间复杂度为O(max(M,N))。
有的时候。。。真的是拿到题要多想一下，不要着急下笔，自己算一算时间复杂度。

再说一个O(M*logN)的算法
遍历其中一个数组，然后对另一个数组做二分查找，代码如下
```c++
bool find_same_num(int a[],int a_length,int b[],int b_length)
{
     int i;
     for(i=0;i<a_length;i++)
     {
          int start=0,end=b_length-1,mid;
          while(start<=end)
          {
               mid=(start+end)/2;
               if(a[i]==b[mid])
                    return true;
               else if (a[i]<b[mid])
                    end=mid-1;
               else
                    start=mid+1;
          }
     }
     return false;
}
```

###代码
为了保持原汁原味。。。我还是贴一下我最开始那个变态思路的代码吧。多了一些剪枝

```c++
#include <iostream>
using namespace std;
int find_same_num(int a[],int b[],int a_s,int a_e,int b_s,int b_e){
    if(a[a_e]<b[b_s]||b[b_e]<a[a_s])
        return 0;
    printf("call find_same_num(%d,%d,%d,%d)\n",a_s,a_e,b_s,b_e);
    int a_half=(a_s+a_e)/2;
    int b_half=(b_s+b_e)/2;
    if(a[a_half]==b[b_half]){
        printf("%d ",a[a_half]);
        return 1;
    }
    if(a_e==a_s&&b_e==b_s){
        return 0;
    }
    if(a[a_half]>b[b_half]){
        if(a_s==a_e)
            return find_same_num(a,b,a_s,a_half,b_s,b_half)+find_same_num(a,b,a_half,a_e,b_half+1,b_e)+find_same_num(a,b,a_s,a_half,b_half+1,b_e);
        else if(b_s==b_e)
            return find_same_num(a,b,a_s,a_half,b_s,b_half)+find_same_num(a,b,a_half+1,a_e,b_half,b_e)+find_same_num(a,b,a_s,a_half,b_half,b_e);
        else
            return find_same_num(a,b,a_s,a_half,b_s,b_half)+find_same_num(a,b,a_half+1,a_e,b_half+1,b_e)+find_same_num(a,b,a_s,a_half,b_half+1,b_e);
    }
    if(a[a_half]<b[b_half]){
        if(a_s==a_e)
            return find_same_num(a,b,a_s,a_half,b_s,b_half)+find_same_num(a,b,a_half,a_e,b_half+1,b_e)+find_same_num(a,b,a_half,a_e,b_s,b_half);
        else if(b_s==b_e)
            return find_same_num(a,b,a_s,a_half,b_s,b_half)+find_same_num(a,b,a_half+1,a_e,b_half,b_e)+find_same_num(a,b,a_half+1,a_e,b_s,b_half);
        else
            return find_same_num(a,b,a_s,a_half,b_s,b_half)+find_same_num(a,b,a_half+1,a_e,b_half+1,b_e)+find_same_num(a,b,a_half+1,a_e,b_s,b_half);
    }
    return 0;
}
int main(){
    int a[8]={
        1,3,5,7,9,11,13,15
    };
    int b[8]={
        2,4,6,8,10,12,14,16
    };
    find_same_num(a,b,0,7,0,7);
}
```


[1]: http://soloimage-soloimage.stor.sinaapp.com/original/48d6ddd3b0f29a444df540cb94871a07.png
