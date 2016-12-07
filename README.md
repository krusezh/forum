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
