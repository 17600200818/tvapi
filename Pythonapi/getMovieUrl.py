# !/usr/bin/env python3
# -*- coding: utf-8 -*-
import urllib.request
import urllib.parse
import re
import os
import datetime

# 获取昨天日期
now_time = datetime.datetime.now()
yes_time = now_time + datetime.timedelta(days=-1)
date = yes_time.strftime('%Y%m%d')

requestUrl = 'http://www.dytt8.net/'

webhead = {'User-Agent':'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:23.0) Gecko/20100101 Firefox/23.0', 'charset':'utf-8'}
urlRequest = urllib.request.Request(url = requestUrl, headers = webhead)

with urllib.request.urlopen(urlRequest) as f:
    data = f.read()
    data = data.decode('gbk')[:20000]

    # 获取urllist
    str1 = data.split('<!--}end:最新-->')
    str2 = str1[0]
    strArr = str2.split('<!--{start:最新-->')
    str = strArr[1]

    list = re.findall(r"href='(.*?"+date+".*?\.html)", str)

login_data = urllib.parse.urlencode([
    ('list', list),
])

# 给服务器发请求 添加dytt网址到数据库
req1 = urllib.request.Request('http://www.tvapi.cn/dytt/add')

with urllib.request.urlopen(req1, data=login_data.encode('utf-8')) as f:
    data = f.read()
    data = data.decode('utf-8')
    print(data)

