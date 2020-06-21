

# Парсер и форматтер ТОП 100 вузов (RussiaEdu)

Данная директория содержит скрипты для получения списка вузов, входящих в ТОП 100 по РФ на текущий год. Рейтинг основывается на оценке организации [RussiaEdu](https://russiaedu.ru).

**Данный парсер не использовался в конечной реализации проекта, однако оставлен для возможности расширения функций комплекса.**

**Требуется указание ключа сессии в запросе!**

## Каталог

```bash
    curl.txt              // Команда для получения значений
    json_get.py           // Скрипт для форматирования в JSON
    README.md             // Этот файл
    res.json              // Выходной JSON файл
```

## Запуск

#### Требования для запуска

Особенных требований нет, лишь наличие Python3.

Сам парсинг происходит посредствам запуска утилиты `curl`.

#### Запуск форматтера

```bash
curl 'https://russiaedu.ru/_ajax/rating' \
  -H 'Connection: keep-alive' \
  -H 'Pragma: no-cache' \
  -H 'Cache-Control: no-cache' \
  -H 'Accept: application/json, text/javascript, */*; q=0.01' \
  -H 'DNT: 1' \
  -H 'X-Requested-With: XMLHttpRequest' \
  -H 'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.106 Safari/537.36' \
  -H 'Content-Type: application/x-www-form-urlencoded; charset=UTF-8' \
  -H 'Origin: https://russiaedu.ru' \
  -H 'Sec-Fetch-Site: same-origin' \
  -H 'Sec-Fetch-Mode: cors' \
  -H 'Sec-Fetch-Dest: empty' \
  -H 'Referer: https://russiaedu.ru/rating' \
  -H 'Accept-Language: ru-RU,ru;q=0.9,en-US;q=0.8,en;q=0.7' \
  -H 'Cookie: PHPSESSID=YOUR_SESSION_KEY; amp_test_=0; geolocation=restricted'\
  --data-raw 'edu_university%5BsearchString%5D=&pp=100&pageNumber=1' \
  --compressed

python json_get.py
```

`YOUR_SESSION_KEY` - ключ текущей сессии

## Формат выходных данных

Данные представляют собой *JSON* файл, содержащий список топовых вузов РФ на текущий год.
