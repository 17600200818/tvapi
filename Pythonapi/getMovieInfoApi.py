# !/usr/bin/env python3
# -*- coding: utf-8 -*-
import urllib.request

requestUrl = 'http://www.tvapi.cn/movie/getMovieInfo'
webhead = {'User-Agent':'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:23.0) Gecko/20100101 Firefox/23.0', 'charset':'utf-8'}
urlRequest = urllib.request.Request(url = requestUrl, headers = webhead)

with urllib.request.urlopen(urlRequest) as f:
    pass