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

    univer_pos = list()
    univer_name = list()

    static_url = 'https://raex-rr.com/education/universities/rating_of_universities_of_russia'
    response = requests.get(static_url, headers=header)


    page_code = html.fromstring(response.text)

    uni_pos = page_code.xpath('//*[@id="carouselExampleIndicators"]/div/div[*]/div[1]/div/span[2]') # Позиция Универа
    if not uni_pos:
        sys.exit("Что-то пошло не так..")
    for element in uni_pos:
        heh = etree.tostring(element).decode('utf-8')
        univer_pos.append(heh)

    uni_name = page_code.xpath('//*[@id="carouselExampleIndicators"]/div/div[*]/div[3]/div/h3/a') # Названия Универа
    if not uni_name:
        sys.exit("Что-то пошло не так..")
    for element in uni_name:
        heh = etree.tostring(element).decode('utf-8')
        univer_name.append(heh)

    result = list()
    for x in range(len(uni_pos)):
       cur_uni = re.sub(r'\<[^>]*\>', '', etree.tostring(uni_name[x]).decode('utf-8'))
       result.append(hhhh.unescape(cur_uni))

    with open("uni.json", "w") as write_file:
        json.dump(result, write_file, indent=4)
    print(result)