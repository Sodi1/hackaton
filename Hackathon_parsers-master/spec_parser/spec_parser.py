from lxml import html
from lxml import etree
import html as hhhh
import re
import json
import sys
import time
import requests

# Вставить свои UA
header = {'user-agent': 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.106 Safari/537.36',}


if __name__ == "__main__":

    univer_name = list()

    static_url = ''
    result = list()

    for x in range(10): # По 10 вузов на страницу
        if x == 0:
            static_url = 'https://vuzoteka.ru/вузы/Автоматизация-технологических-процессов-и-производств-15-03-04'
        else:
            static_url = 'https://vuzoteka.ru/вузы/Автоматизация-технологических-процессов-и-производств-15-03-04?page='+str(x+1)
        
        response = requests.get(static_url, headers=header)
        #print(static_url)
        
        page_code = html.fromstring(response.text)
        if x == 0:
            uni_name = page_code.xpath('/html/body/div[1]/div[2]/div[2]/div/div[1]/div/div/div[8]/div[*]/div[1]/div[1]/div[2]/a/text()') # Названия Универа
        else:
            uni_name = page_code.xpath('/html/body/div[1]/div[2]/div[2]/div/div[1]/div/div/div[4]/div[*]/div[1]/div[1]/div[2]/a/text()') # Названия Универа

        if not uni_name:
            sys.exit("Что-то пошло не так..")
        for element in uni_name:
            heh = element
            univer_name.append(heh)
            print(hhhh.unescape(heh))

        time.sleep(5)

    with open("uni.txt", "w") as write_file:
        for item in univer_name:
            write_file.write("%s\n" % item)

    with open("uni.json", "w", encoding='utf-8') as write_file:
        json.dump(univer_name, write_file, indent=4)