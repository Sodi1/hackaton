# HeadHunter парсер топ работодателей РФ с сортировкой по отраслям

Данная директория содержит скрипты для получения информации с сайта hh.ru за 2017-2019 гг.

## Каталог

```bash
    all.json              // Полный список компаний
    check.py              // Сборка процентов по годам в один json
    install.txt           // Установка нужных модулей для запуска скриптов
    percent2017.json      // Процент компаний конкретной отрасли за 2017 год
    percent2018.json      // Процент компаний конкретной отрасли за 2018 год
    percent2019.json      // Процент компаний конкретной отрасли за 2019 год
    README.md             // Этот документ
    requirements.txt      // Список требуемых модулей
    to_panel.json         // Проценты по годам для панели управления
    work2017.py           // Парсинг данных за 2017 год
    work2018.py           // Парсинг данных за 2018 год
    work2019.py           // Парсинг данных за 2019 год
```

## Запуск

#### Требования для запуска

Установленные модули из `requirements.txt` и Python3.

#### Запуск парсера

```bash
python work201X.py
```

`X` - требуемый год

## Формат выходных данных

Данные представляют собой формат **JSON**, который легко может быть использован как на back-end'e проекта, так и на front-end'e.