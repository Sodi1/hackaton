from lxml import html
from lxml import etree
import json
import sys
import requests


def remove_prefix(text, prefix):
    if text.startswith(prefix):
        return text[len(prefix):]
    return text  # or whatever

def remove_postfix(text, postfix):
    if text.endswith(postfix):
        return text[:len(text)-len(postfix)]
    return text  # or whatever

# Получаем html код.
def get_html(url):
    try:
        r = requests.get(url, headers=header, cookies=cookie)
        return r.text
    except requests.exceptions.TooManyRedirects:
        print('Ловим бамп в кучу редиректов..')
        print('Кажется, протухли cookies')
        print('http://www.editthiscookie.com/')


# Вставить свои UA и куки (дохнуть быстро)
header = {'user-agent': 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.106 Safari/537.36',}

cookie = {
    "__cfduid" : "dbf07728ba940cb6b8e391f1d3c9e43d11592644872",
    "__cfruid" : "92be9c9a854c295ddee74543e45b02649574ffba-1592644872",
    "AWSELB" : "CB9317D502BF07938DE10C841E762B7A33C19AADB1A4C687F3E432697E5F305D47399607EFB1BA02317C65AAC94DFA1ABE70BAEC90A31AAC5A6BDE3E4B4DACF34F3854CEEBC02F3847D0AAAEDC9D28CCA245E9BCF9",
    "javaScript" : "true",
    "scopus.machineID" : "EA52F003F4EF798897933DD9AA1FCDAEBE5BE63C212B0628FEBB82B2F6157739.wsnAw8kcdt7IPYLO0V48gA",
    "scopusSessionUUID" : "e5fbf9a7-f8f3-4052-8",
    "screenInfo" : "\"774:1376\"",
    "SCSessionID" : "BE5BE63C212B0628FEBB82B2F6157739.wsnAw8kcdt7IPYLO0V48gA",
    "xmlHttpRequest" : "true"
}

if __name__ == "__main__":
    res = dict()
    h = ''
    if len(sys.argv) > 1:
        h = sys.argv[1]
    else:
        print('Usage:\n  - python hirsch.py <Scopus ID string>')
        sys.exit()
    static_url = 'https://www.scopus.com/authid/detail.uri?authorId='
    author_id = h # Тут должен быть id в Scopus'е
    print('URL: ',static_url+author_id)

    page_code = html.fromstring(get_html(static_url+author_id))
    h_index = ''
    cit_index = ''
    cit_node = page_code.xpath('//*[@id="totalCiteCount"]/text()')
    if not cit_node:
        sys.exit("Не удалось получить количество цитирований")
    else:
        cit_index = cit_node[0]
    cec = str(cit_index)
    res['CiteCount'] = cec
    print(cec)

    div_node = page_code.xpath('//*[@id="authorDetailsHindex"]/div[2]/div/span/text()') # теги с индексом Хирша
    if not div_node:
        sys.exit("Не удалось получить индекс Хирша")
    else:
        h_index = div_node[0]
    heh = str(h_index)
    res['Hirsch'] = heh
    print(heh)

    with open("hirsch.json", "w") as write_file:
        json.dump(res, write_file, indent=4)