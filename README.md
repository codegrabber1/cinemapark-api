# Cinema Park API
PHP библиотека для интеграции с информационными системами Синема Парк.

### Получение списка мультиплексов и городов
```php
public function getMultiplexes() : array
```
#### Результат ответа
Поле | Тип | Описание
-----|-----|---------
id | integer | Идентификатор мультиплекса
short_name | string | Короткое название мультиплекса
full_name | string | Полное название мультиплекса
description | string | Описание кинотеатра
phone | string | Телефон кинотеатра
formats | array | Список форматов показа фильмов
city_id | integer | Идентификатор города мультиплекса
city_name | string | Наименование города мультиплекса
address | string | Адес мультиплекса
multiplex_geo | string | Географические координаты мультиплекса

### Получение списка фильмов
В список могут попадать фильмы, не значащиеся в расписании мультиплексов (к примеру, поставленные в прокат на будущее, но без конкретного расписания).
```php
public function getFilms() : array
```
#### Результат ответа
Поле | Тип | Описание
-----|-----|---------
has_subtitles | bool | Если фильм идёт с субтитрами (скорее всего, с оригинальной звуковой дорожкой)
age_id | integer | Код возрастных ограничений
startdate | string | Дата старта проката в нашей сети (без учёта возможных премьерных показов)
genre | string | Текстовое описание жанра фильма
original_title | string | Оригинальное название фильма (для иностранных фильмов)
timing | integer | Продолжительность фильма в минутах
age_limit | integer | Возрастное ограничение. В будущем будет произведён полный переход от age_id к age_limit
category | string | Slug категории 
title | string | Русскоязычное название фильма с учётом формата
film_id | integer | Идентификатор фильма
youtubeid | string | Список трейлеров с Youtube (через запятую) 

### Привязка фильмов к мультиплексам
В список могут попадать фильмы, не значащиеся в расписании мультиплексов (к примеру, поставленные в прокат на будущее, но без конкретного расписания).
```php
public function getFilmsMultiplexes() : array
```
#### Результат ответа
Поле | Тип | Описание
-----|-----|---------
id | integer | Идентификатор фильма
multiplex | array | Идентификатор мультиплекса, к которому привязан фильм

### Получение расписания фильма
Выводится всё известное расписание, в т.ч. и прошедшие сеансы.
```php
public function getRepertoir($id) : array
```
#### Параметры метода
Название | Тип | Описание
-----|-----|---------
id | integer | Идентификатор фильма
#### Результат ответа
Поле | Тип | Описание
-----|-----|---------
format_id | integer | Идентификатор формата показа, соответствующий выгрузке formats
hall | integer | Идентификатор зала (уникален для всей сети)
base_price | integer | Цена билета на сеанс без учёта скидок (в российских рублях)
id | integer | Идентификатор сеанса
state | bool | Состояние сеанса (открыт, либо фильмокопия не поступила / произошёл срыв сеанса / сеанс отменён)
datetime | string | Дата/время сеанса (местное время соответствующего мультиплекса)
multiplex | integer | Идентификатор мультиплекса
glasses_price | integer | Дополнительная стоимость, взимаемая на кассе за 3D-очки

### Получение расписания мультиплекса
```php
public function getMultiplexRepertoir($id) : array
```
#### Параметры метода
Название | Тип | Описание
-----|-----|---------
id | integer | Идентификатор мультиплекса
#### Результат ответа
Поле | Тип | Описание
-----|-----|---------
format_id | integer | Идентификатор формата показа, соответствующий выгрузке formats
hall | integer | Идентификатор зала (уникален для всей сети)
base_price | integer | Цена билета на сеанс без учёта скидок (в российских рублях)
id | integer | Идентификатор сеанса
state | bool | Состояние сеанса (открыт, либо фильмокопия не поступила / произошёл срыв сеанса / сеанс отменён)
datetime | string | Дата/время сеанса (местное время соответствующего мультиплекса)
multiplex | integer | Идентификатор мультиплекса
glasses_price | integer | Дополнительная стоимость, взимаемая на кассе за 3D-очки

### Получение дополнительной информации по фильму
```php
public function getFilmInfo($id) : array
```
#### Параметры метода
Название | Тип | Описание
-----|-----|---------
id | integer | Идентификатор фильма

#### Результат ответа
Поле | Тип | Описание
-----|-----|---------
hit | bool | Присвоен ли фильму статус «Хит»
description | string | Описание фильма
addinfo | array | Дополнительная информация, тип которой указан в атрибуте «title» (режиссёр, актёры, озвучка)
year | integer | од выпуска фильма
country | string | Страна фильма

### Получение списка залов по всем мультиплексам
```php
public function getHalls() : array
```
#### Результат ответа
Поле | Тип | Описание
-----|-----|---------
multiplex_id | integer | Идентификатор мультиплекса
title | string | Идентификатор зала внутри мультиплекса
id | integer | Идентификатор зала внутри мультиплекса