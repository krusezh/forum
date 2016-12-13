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
            <h1>FORUM</h1>
            <br />
            <br />
            这是一封重置邮件，你的FORUM密码已被重置
            <br />
            <br />
            这是你的新密码：
            <br />
            <br />
            {0}
            <br />
            <br />
            你可以登录后在设置页面修改你的密码。
        </body>
    </html>
    """.format(murl)

    message = MIMEText(mail_msg, 'html', 'utf-8')#内容
    message['From'] = _user#发送方
    message['To'] =  _to#接收方

    subject = 'FORUM-密码重置'#标题
    message['Subject'] = Header(subject, 'utf-8')

    s = smtplib.SMTP("smtp.126.com", timeout=300)#连接smtp邮件服务器,端口默认是25
    s.login(_user, _pwd)
    s.sendmail(_user, _to, message.as_string())#发送邮件
    s.close()

if __name__ == "__main__":
    args=sys.argv
    send_mail(args[1],args[2])
