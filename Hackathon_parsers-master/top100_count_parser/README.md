

# Парсер ТОП 100 вузов (RAEX)

Данная директория содержит скрипты для получения списка вузов, входящих в ТОП 100 по РФ на текущий год. Рейтинг основывается на оценке организации [RAEX](https://raex-rr.com).

**Не нарушайте структуру нахождения скриптов для парсинга, иначе данные не будут корректно прочитаны!**

## Каталог

```bash
    install.txt           // Как ставить модули
    README.md             // Этот файл
    requirements.txt      // Список модулей
    top100.py             // Скрипт, выполняющий парсинг ТОП 100 вузов
    uni.json              // Выходной файл
```

## Запуск

#### Требования для запуска

Особенных требований нет, кроме установки модулей (тех же, что в других парсерах).

#### Запуск парсера

```bash
python top100.py
```

## Формат выходных данных

Данные представляют собой *JSON* файл, содержащий список топовых вузов РФ на текущий год.