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
    if len(introduction) == 0:
        introduction = re.findall(r'简　　介(.*?)img', data)
    introduction = introduction[0]
    #补充电影详细信息
    realname = re.findall(r'片　　名(.*?)<br', data)
    realname = realname[0]
    year = re.findall(r'年　　代(.*?)<br', data)
    year = year[0]
    place = re.findall(r'产　　地(.*?)<br', data)
    if len(place) == 0:
        place = re.findall(r'地　　区(.*?)<br', data)
    place = place[0]
    category = re.findall(r'类　　别(.*?)<br', data)
    category = category[0]
    language = re.findall(r'语　　言(.*?)<br', data)
    if len(language) == 0:
        language = ''
    else:
        language = language[0]
    subtitle = re.findall(r'字　　幕(.*?)<br', data)
    if len(subtitle) == 0:
        subtitle = ''
    else:
        subtitle = subtitle[0]
    IMDbScore = re.findall(r'IMDb评分(.*?)"', data)
    if len(IMDbScore) == 0:
        IMDbScore = ''
    else:
        IMDbScore = IMDbScore[0]
    doubanScore = re.findall(r'豆瓣评分(.*?)/10', data)
    if len(doubanScore) == 0:
        doubanScore = ''
    else:
        doubanScore = doubanScore[0]
    fileFormat = re.findall(r'文件格式(.*?)<br', data)
    fileFormat = fileFormat[0]
    videoSize = re.findall(r'视频尺寸(.*?)<br', data)
    videoSize = videoSize[0]
    filmLength = re.findall(r'片　　长(.*?)<br', data)
    if len(filmLength) == 0:
        filmLength = ''
    else:
        filmLength = filmLength[0]
    director = re.findall(r'导　　演(.*?)<br', data)
    director = director[0]
    cast = re.findall(r'主　　演(.*?)<br /><br />', data)
    cast = cast[0]

login_data = parse.urlencode([
    ('name', name),
    ('cover', cover),
    ('image', image),
    ('introduction', introduction),
    ('download', download),
    #补充电影详细信息
    ('realname', realname),
    ('year', year),
    ('place', place),
    ('category', category),
    ('language', language),
    ('subtitle', subtitle),
    ('doubanScore', doubanScore),
    ('fileFormat', fileFormat),
    ('videoSize', videoSize),
    ('filmLength', filmLength),
    ('director', director),
    ('cast', cast),
    ('doubanScore', doubanScore),
    ('requestUrl', requestUrl)
])

req1 = request.Request('http://www.tvapi.cn/movie/add')

with request.urlopen(req1, data=login_data.encode('utf-8')) as f:
    data = f.read()
    data = data.decode('utf-8')
    print(data)
