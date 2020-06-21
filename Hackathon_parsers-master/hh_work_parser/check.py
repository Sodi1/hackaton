import json

count_dict = dict()

for x in range(3):
    all = list() # Список фирм

    with open('percent'+str(2017+x)+'.json', encoding='utf-8') as json_file:
        all = json.load(json_file)
        #print(json.dumps(spec, sort_keys=False, indent=4, ensure_ascii=False))
    len(all)

    print('------')
    print('Количество за',str(2017+x),'(%):', len(all))
    count_dict[str(2017+x)] = len(all)
    
    with open("to_panel.json", "w") as write_file:
        json.dump(count_dict, write_file, indent=4)