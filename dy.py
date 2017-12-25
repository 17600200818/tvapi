from urllib import request,parse
import re
#
# req = request.Request('http://www.dytt8.net/html/gndy/jddy/20171223/55868.html')
# req.add_header('User-Agent', 'Mozilla/6.0 (iPhone; CPU iPhone OS 8_0 like Mac OS X) AppleWebKit/536.26 (KHTML, like Gecko) Version/8.0 Mobile/10A5376e Safari/8536.25')
# with request.urlopen(req) as f:
#     data = f.read().decode('gbk')
#
#     download = re.findall(r"(ftp.*?rmvb)", data)
#     download = download[0]
#     name = re.findall(r'<div class="title_all"><h1><font color=#07519a>.*《(.*?)》.*</font>', data)
#     name = name[0]
#     img = re.findall(r'(http://www.imageto.org/images.*?jpg)', data)
#     cover = img[0]
#     image = img[1]
#     introduction = re.findall(r'介 <br /><br />(.*?)<br /><br />', data)
#     introduction = introduction[0]


# login_data = parse.urlencode([
#     ('name', name),
#     ('cover', cover),
#     ('image', image),
#     ('introduction', introduction),
#     ('download', download),
# ])
login_data = parse.urlencode([
    ('name', 123),
    ('cover', 222),
    ('image', 333),
    ('introduction', 444),
    ('download', 111),
])

req1 = request.Request('http://www.tv.cn/api/')

with request.urlopen(req1, data=login_data.encode('utf-8')) as f:
    print('Status:', f.status, f.reason)
    for k, v in f.getheaders():
        print('%s: %s' % (k, v))
    print('Data:', f.read().decode('utf-8'))