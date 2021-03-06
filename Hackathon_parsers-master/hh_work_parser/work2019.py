from lxml import html
from lxml import etree
import json
import sys
import requests


# Получаем html код.
def get_html(url):
    try:
        r = requests.get(url, headers=header, cookies=cookie)
        return r.text
    except requests.exceptions.TooManyRedirects:
        print('Ловим бамп в кучу редиректов..')
        print('Кажется, протухли cookies')
        print('http://www.editthiscookie.com/')


all = list() # Список фирм из всех отраслей
ok = list() # Список подходящих фирм
mask = 'Энергетика и добыча сырья'

# Вставить свои UA и куки (дохнуть быстро)
header = {'user-agent': 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.106 Safari/537.36',}

cookie = {
    "__ddg1" : "uxGEcpPGWWA4IV1d3qOl",
    "__zzatgib-w-hh" : "MDA0dBA=Fz2+aQ==",
    "_xsrf" : "c1d200f08e2852a1d82187013caa4de0",
    "cfidsgib-w-hh" : "6Rb0F/JtD9akFuuNAXvZ2N+zfNHv6JTKPctLyq5VQkmFl83yDOTiAJ50ypMrMoiumaF1zfPVuv/8kiOaLnAPyZkGFots1luFDcktg1mJS6n74pkn4Daz+O6EUnz7XrzJP2NUs1va8IQPmXOrCj91OnyOAqu6J8Be+jxMng==",
    "fgsscgib-w-hh" : "7dd073d34fb042f72872ace39a1ee5b61aea41bd",
    "gsscgib-w-hh" : "llYdoWIytcvti6AHfhAplEEsjTGCm327XlBbfdWfSlVbg3qTz67ZXli3c6ZfHtlk9oW6m3S5hSCa6Vw+j9ztjMUGVgnHz4QO30em+mbd3DgasclkhTbB1tctHp89FChusaPwCfJQ7vOKyfKAVSaG3lKkm6y/aOZZYMQPcs0TC8FrCu1jzjRRtNmEEcA=",
    "hhtoken" : "H7a4VdMrHWw!dHaVdnyZSwF5jGxl",
    "hhuid" : "oNsTEVbkpJ1d1l7uEkszkw--",
    "iap.uid" : "85f181a577ab4865845c58550535e9aa",
    "region_clarified" : "NOT_SET",
    "_xsrf" : "c1d200f08e2852a1d82187013caa4de0",
    "cfidsgib-w-hh" : "6Rb0F/JtD9akFuuNAXvZ2N+zfNHv6JTKPctLyq5VQkmFl83yDOTiAJ50ypMrMoiumaF1zfPVuv/8kiOaLnAPyZkGFots1luFDcktg1mJS6n74pkn4Daz+O6EUnz7XrzJP2NUs1va8IQPmXOrCj91OnyOAqu6J8Be+jxMng==",
    "display" : "desktop",
    "GMT" : "3",
    "hhrole" : "anonymous",
    "regions" : "1",
}

if __name__ == "__main__":
    res = None
    sphere_list = list()
    name_list = list()
    static_url = 'https://hh.ru/article/26564'
    print('URL: ',static_url)

    page_code = html.fromstring(get_html(static_url))

    sphere_node = page_code.xpath('/html/body/div[6]/div/div/div[3]/div/div/div/div[1]/div/div/div[2]/div/div/table/tbody/tr[*]/td[4]/text()')
    if not sphere_node:
        sys.exit("Не удалось получить сферу")
    for element in sphere_node:
        sphere_list.append(element)
        #print(element)

    div_node = page_code.xpath('/html/body/div[6]/div/div/div[3]/div/div/div/div[1]/div/div/div[2]/div/div/table/tbody/tr[*]/td[3]/a/text()') # теги с названием
    if not div_node:
        sys.exit("Не удалось получить название")
    for element in div_node:
        name_list.append(element)
        #print(element)

    for x in range(len(name_list)):
        if sphere_list[x] == mask:
            ok.append(name_list[x])
            print(sphere_list[x],';',name_list[x])

    percent = len(ok)
    print('-----\nПроцентов: ', percent)
    with open("percent2019.json", "w") as write_file:
        json.dump(ok, write_file, indent=4)