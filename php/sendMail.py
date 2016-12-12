#coding:utf-8

import smtplib
from email.mime.text import MIMEText
from email.header import Header
import sys

def send_mail(mreceive,murl):
    _user = "redfolder@126.com"
    _pwd  = "159357oIl"
    _to   = mreceive

    #使用MIMEText构造符合smtp协议的header及body
    #下面构造网页
    mail_msg = r"""
    <html>
        <body>
            恭喜你成功注册成为我们论坛的用户。
            <br />
            <br />
            这是一封注册认证邮件，请点击以下链接确认
            <br />
            <br />
            <a href="http://redfolder.cn/forum/php/active.php?verify={0}">http://redfolder.cn/forum/php/active.php?verify={0}</a>
            <br />
            <br />
            如果链接不能点击，请复制以上地址到浏览器，然后直接打开。
            <br />
            <br />
            该链接24小时内有效。如果激活链接失效，请您登录网站<a href="http://redfolder.cn/forum">http://redfolder.cn/forum</a>重新申请认证。
        </body>
    </html>
    """.format(murl)

    message = MIMEText(mail_msg, 'html', 'utf-8')#内容
    message['From'] = _user#发送方
    message['To'] =  _to#接收方

    subject = 'FORUM-用户注册认证'#标题
    message['Subject'] = Header(subject, 'utf-8')

    s = smtplib.SMTP("smtp.126.com", timeout=300)#连接smtp邮件服务器,端口默认是25
    s.login(_user, _pwd)
    s.sendmail(_user, _to, message.as_string())#发送邮件
    s.close()

if __name__ == "__main__":
    args=sys.argv
    send_mail(args[1],args[2])
    print args[2]
