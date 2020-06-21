from lxml import html
from lxml import etree
import html as hhhh
import re
import json
import sys
import requests

# Вставить свои UA
header = {'user-agent': 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.106 Safari/537.36',}


if __name__ == "__main__":

    h = ''
    if len(sys.argv) > 1:
        h = sys.argv[1]
    else:
        print('Usage:\n  - python portal_parser.py <ID string>')
        sys.exit()

    teacher_res = list()

    static_url = 'http://login:pass@portal.stankin.ru/stankin/ppsv12.nsf/ids/' + h
    response = requests.get(static_url, headers=header)

    # Немного костыльно, но работает
    page_code = etree.HTML(response.text)
    # print(hhhh.unescape(etree.tostring(page_code).decode('utf-8')))
    teach_res = page_code.xpath('//tr/td/b/font/text()') # Интегральный показатель результативности
    if not teach_res:
        sys.exit("Что-то пошло не так..")
    for element in teach_res:
        heh = element
        teacher_res.append(heh)


    print(teacher_res[-1])