import json
from fuzzywuzzy import fuzz
from fuzzywuzzy import process

# Ищем пересечения списков с помощью нечёткого поиска

top = None # Список Топ 100 вузов
spec = None # Список топ вузов с данной специальностью

with open('uni.json', encoding='utf-8') as json_file:
    spec = json.load(json_file)
    #print(json.dumps(spec, sort_keys=False, indent=4, ensure_ascii=False))

with open('../top100_count_parser/uni.json') as json_file:
    top = json.load(json_file)
    #print(json.dumps(top, sort_keys=False, indent=4, ensure_ascii=False))

sss = list()
for top_uni in top:
    hhhhh = process.extractOne(top_uni, spec)
    if hhhhh[1] > 90:
        sss.append(hhhhh[0])
        #print(hhhhh,'\n',top_uni,'\n-----')


for x in range(len(sss)):
    print(sss[x])


with open("all.json", "w") as write_file:
        json.dump(sss, write_file, indent=4)