# !/usr/bin/env python3
# -*- coding: utf-8 -*-
from urllib import request,parse
from sys import argv
import re

dytt = 'http://www.dytt8.net'
requestUrl = dytt+argv[1]

req = request.Request(requestUrl)
req.add_header('User-Agent', 'Mozilla/6.0 (iPhone; CPU iPhone OS 8_0 like Mac OS X) AppleWebKit/536.26 (KHTML, like Gecko) Version/8.0 Mobile/10A5376e Safari/8536.25')
with request.urlopen(req) as f:
    data = f.read().decode('gbk')

    download = re.findall(r'(ftp.*?)">ftp:', data)
    download = download[0]
    name = re.findall(r'<div class="title_all"><h1><font color=#07519a>.*《(.*?)》.*</font>', data)
    name = name[0]
    img = re.findall(r'(http.*?jpg)', data)
    cover = img[0]
    image = img[1]
    introduction = re.findall(r'介 <br /><br />(.*?)<br /><br />', data)
    introduction = introduction[0]


login_data = parse.urlencode([
    ('name', name),
    ('cover', cover),
    ('image', image),
    ('introduction', introduction),
    ('download', download),
])

req1 = request.Request('http://www.tvapi.cn/movie/add')

with request.urlopen(req1, data=login_data.encode('utf-8')) as f:
    data = f.read()
    data = data.decode('utf-8')
    print(data)