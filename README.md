#基于B/S架构的网络论坛    
***  

###Q1:关于Mysql插入数据乱码问题:    

>参见<http://shengtang.blog.51cto.com/1290225/498212/>    

我们可以完全无视数据库默认的字符集是什么，我们关心的只有数据库在建立的时候是不是加入了字符集选择。
 
* 使用如下指令建立数据库：    
   
```sql
CREATE DATABASE `database` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
```    

* 客户端php程序使用如下方法设定连接所使用的字符集： 
PHP程序在查询数据库之前，执行mysql_query("set names utf8;"); 
例子：    

```php
<?php
mysql_connect('localhost','user','password'); 
mysql_select_db('my_db'); 
/*
请注意,这步很关键,如果没有这步,所有的数据读写都会不正确的 
它的作用是设置本次数据库联接过程中,数据传输的默认字符集
*/
mysql_query("set names utf8;");
//必须将gb2312(本地编码)转换成utf-8,也可以使用iconv()函数 
mysql_query(mb_convet_encoding("insert into my_table values('测试');","utf-8","gb2312")); 
?> 
```    
* 如果你想使用gb2312编码,那么建议你使用latin1作为数据表的默认字符集,    
这样就能直接用中文在命令行工具中插入数据,并且可以直接显示出来,    
而不要使用gb2312或者gbk等字符集,如果担心查询排序等问题,可以使用binary属性约束    
    
###例如:    

```sql
create table my_table ( name varchar(20) binary not null default '')type=myisam default charset latin1;
```    
自此,使用utf8字符集的完整的例子结束了。    

* 在用sql脚本对数据库进行操作时，在sql脚本最开始添加下面这句，以防乱码    

```sql
SET NAMES utf8;
```    

###Q2:关于v2ex和GitHub上的初始头像    

>参见    
>[解析 Github 的默认头像](http://debbbbie.iteye.com/blog/1991128)    
>[PHP Image Requests](https://en.gravatar.com/site/implement/images/php/)    
>[Gravatar: Retrieve Gravatar images](https://www.phpclasses.org/package/4227-PHP-Retrieve-Gravatar-images.html#view_files/files/21166)    
>[最近针对 V2EX 的 Gravatar 头像加载做了一个优化](https://www.v2ex.com/t/141485)    

* GitHub给无头像用户生成了初始头像，像这样:        
![](http://www.gravatar.com/avatar/c69f8f6920d6816f485ca5c8255f518c?s=73&default=retro)    

```
这一生成过程使用了用户ID的哈希值，    
根据哈希值每一位的奇偶值来决定对应位置上的像素的开关。    
这样生成的图像，配上由哈希值决定的颜色，保证可生成大量独一无二的图像。
```    

###Q3:记Mysql停止工作（环境：macOS Sierra 10.12.1)    

更新完brew和OpenSSL后，mysql不能打开了。    

报错如下：    

```
ERROR 2002 (HY000): Can't connect to local MySQL server through socket '/tmp/mysql.sock' (2)
```    

日志如下：    

```
161210 19:55:46 mysqld_safe mysqld from pid file /usr/local/mysql/data/MacBook-Pro-6.local.pid ended
161210 19:57:45 mysqld_safe Starting mysqld daemon with databases from /usr/local/mysql/data
2016-12-10 19:57:45 0 [Warning] TIMESTAMP with implicit DEFAULT value is deprecated. Please use --explicit_defaults_for_timestamp server option (see documentation for more details).
2016-12-10 19:57:45 0 [Note] /usr/local/mysql/bin/mysqld (mysqld 5.6.24) starting as process 9431 ...
2016-12-10 19:57:45 9431 [Warning] Setting lower_case_table_names=2 because file system for /usr/local/mysql/data/ is case insensitive
2016-12-10 19:57:45 9431 [Note] Plugin 'FEDERATED' is disabled.
/usr/local/mysql/bin/mysqld: Can't find file: './mysql/plugin.frm' (errno: 13 - Permission denied)
2016-12-10 19:57:45 9431 [ERROR] Can't open the mysql.plugin table. Please run mysql_upgrade to create it.
2016-12-10 19:57:45 9431 [Note] InnoDB: Using atomics to ref count buffer pool pages
2016-12-10 19:57:45 9431 [Note] InnoDB: The InnoDB memory heap is disabled
2016-12-10 19:57:45 9431 [Note] InnoDB: Mutexes and rw_locks use GCC atomic builtins
2016-12-10 19:57:45 9431 [Note] InnoDB: Memory barrier is not used
2016-12-10 19:57:45 9431 [Note] InnoDB: Compressed tables use zlib 1.2.3
2016-12-10 19:57:45 9431 [Note] InnoDB: Using CPU crc32 instructions
2016-12-10 19:57:45 9431 [Note] InnoDB: Initializing buffer pool, size = 128.0M
2016-12-10 19:57:45 9431 [Note] InnoDB: Completed initialization of buffer pool
2016-12-10 19:57:45 9431 [ERROR] InnoDB: ./ibdata1 can't be opened in read-write mode
2016-12-10 19:57:45 9431 [ERROR] InnoDB: The system tablespace must be writable!
2016-12-10 19:57:45 9431 [ERROR] Plugin 'InnoDB' init function returned error.
2016-12-10 19:57:45 9431 [ERROR] Plugin 'InnoDB' registration as a STORAGE ENGINE failed.
2016-12-10 19:57:45 9431 [ERROR] Unknown/unsupported storage engine: InnoDB
2016-12-10 19:57:45 9431 [ERROR] Aborting
```    

我试了几个方法，最后是文件属主问题，更改属主为mysql，成功解决      

```bash
#/usr/local/mysql目录下
sudo chown -R mysql data
sudo /usr/local/mysql/support-files/mysql.server start
```     

过程中还找了一些解决方法，但是不适用    
>[MySQL服务器启动错误 'The server quit without updating PID file'](http://pein0119.github.io/2015/03/25/MySQL%E6%9C%8D%E5%8A%A1%E5%99%A8%E5%90%AF%E5%8A%A8%E9%94%99%E8%AF%AF-The-server-quit-without-updating-PID-file/)    
>[mysql启动报错：Starting MySQL... ERROR! The server quit without updating PID file ](http://732233048.blog.51cto.com/9323668/1636409)    
>[启动mysql错误解决方案，学会查看错误日志：mysql.sock丢失，mysqld_safe启动报错](http://www.cnblogs.com/super-lucky/p/superlucky.html)    
>[MySql数据库Plugin 'FEDERATED' is disabled.错误解决方法](http://www.111cn.net/database/mysql/55532.htm)    
>[mysql启动时报错: [Note] Plugin 'FEDERATED' is disabled. Plugin 'ndbcluster' is disabled](http://xingxing5421.blog.163.com/blog/static/11944631920123923537430/)    

###Q4:记HTTP ERROR 500  
####如下  
![HTTP ERROR 500.png](https://ooo.0o0.ooo/2016/12/11/584d63161cdde.png)    
###原因是：我在删除文件后没有把用到它的require语句删除    


