<h1 align="center">
  <a href="http://hyperdrive.vhs.codeberg.page"><img src="https://codeberg.org/vhs/hyperdrive/blob/master/logo.png" alt="Hyperdrive плагин для WordPress" title="Самый быстрый способ загрузки страниц на WordPress" width="888"></a>
  <span style="clip: rect(1px, 1px, 1px, 1px); clip-path: polygon(0px 0px, 0px 0px,0px 0px, 0px 0px); position: absolute !important; white-space: nowrap; height: 1px; width: 1px; overflow: hidden;">Hyperdrive</span>
</h1>

<p align="center">
  <a href="https://packagist.org/packages/vhs/hyperdrive"><img src="https://img.shields.io/packagist/v/vhs/hyperdrive.svg?style=flat-square" alt="Packagist"></a>
  <a href="https://php.net/"><img src="https://img.shields.io/badge/php-%3E%3D%205.6-8892BF.svg?style=flat-square" alt="PHP"></a>
  <a href="https://wordpress.com/"><img src="https://img.shields.io/badge/wordpress-%3E%3D%204.6-0087BE.svg?style=flat-square" alt="WordPress"></a>
  <a href="https://travis-ci.org/vhs/hyperdrive"><img src="https://img.shields.io/travis/vhs/hyperdrive.svg?style=flat-square" alt="Travis"></a>
  <a href="https://codecov.io/gh/vhs/hyperdrive"><img src="https://img.shields.io/codecov/c/github/vhs/hyperdrive.svg?style=flat-square" alt="Codecov"></a>
</p>

<h4 align="center">Самый быстрый способ загрузки страниц на WordPress</h4>

<p align="center"><em>Hyperdrive - это плагин WordPress, повышающий скорость загрузки страниц используя <a href="https://fetch.spec.whatwg.org/">современные веб-стандарты</a>. На основе проведенного тестирования Hyperdrive, <a href="https://hackernoon.com/putting-wordpress-into-hyperdrive-4705450dffc2">можно сказать</a> что скорость загрузки всех видимых элементов страницы увеличилась на 200-300%.</em></p>

<p align="center">
  Переводы:
  <a href="../README.md">English</a>,
  <a href="README_es-419.md">español</a>
</p>

## Как это работает

Hyperdrive использует технику оптимизации, известную как [Fetch Injection](https://hackcabin.com/post/managing-async-dependencies-javascript/) ([информация о совместимости с браузерами](http://caniuse.com/#search=fetch)). Fetch Injection использует библиотеку [Fetch](https://github.com/whatwg/fetch) - современную замену AJAX запросов.

## Установка

Доступно несколько способов установки. Выберите тот, который соответствует вашему рангу знаний.

### Прапорщик

Чтобы установить плагин вручную, просто:

1. Загрузите `hyperdrive.php` в папку `/wp-content/plugins/`,
1. Активируйте плагин через меню *Плагины* в WordPress.

### Лейтенант

Чтобы установить плагин с помощью [Composer](https://getcomposer.org/doc/00-intro.md#installation-linux-unix-osx), запустите следующую команду из дирректории установки WP:

    composer require vhs/hyperdrive:1.0.x-dev

Эта команда загрузит Hyperdrive beta вместе со всей историей изменений git и установит его в папку `/wp-content/plugins`. Запустите команду `composer update`, чтобы обновить версию.

### Командир

Единственная деталь, которая может вас смущать, это [`rupa/z`](https://github.com/rupa/z/):

```shell
ssh user:pass@wordpressbox.tld
z plugins
curl -O https://raw.githubusercontent.com/vhs/hyperdrive/master/src/hyperdrive.php
wp plugin activate hyperdrive
```

## Сделать до релиза версии 1.0.0

- [ ] Предотвращать загрузку и запуск скриптов только если [браузер поддерживает Fetch](http://caniuse.com/#search=fetch) для совместимости со старыми версиями браузеров
- [ ] Интегрировать локализацию, [как указано здесь](https://gist.github.com/vhs/64e8380010e43a526fb9c9ee511fad17#file-functions-php-L507).
- [ ] Протестировать с несколькими разными темами и создать баг-репорты, если потребуется

## Участие в разработке

Сотни тысяч людей используют WordPress каждый день, чтобы получать и делиться информацией онлайн. Поэтому Hyperdrive имеет четкие требования к контрибьютерам.

Однако, не смотря на то, что Hyperdrive может иметь высокие требования к качеству, пусть это не останавливает вас от участия в разработке. Мы принимаем всех желающих.

Основатели проектов, участники и контрибьютеры должны соблюдать [ценности манифеств Agile](https://pragdave.me/blog/2014/03/04/time-to-kill-agile.html), где это возможно:

> - **Люди и взаимодействие** важнее процессов и инструментов
> - **Работающий продукт** важнее исчерпывающей документации
> - **Сотрудничество с заказчиком** важнее согласования условий контракта
> - **Готовность к изменениям** важнее следования первоначальному плану

### Вопросы

Hyperdrive принимает к рассмотрению любые вопросы. Даже если они плохо сформулированы. Отзыв - это дар и именно так мы к нему относимся. Вопросы не бывают тупыми, даже тупые вопросы.

### Pull requests (PR)

Пожалуйста, создавйте Вопросы (Issues), перед созданием пулл-реквеста. Это помогает понять мотивацию, сподвигнувшую автора к написанию, собственно, кода.

Перед тем как работать над пулл-реквестом, пожалуйста установите и настройте [EditorConfig](http://editorconfig.org/) для вашего редактора кода или IDE, чтобы упорядочить синтаксис проекта.

## Лицензия

[![AGPL-3.0 or any later version](https://img.shields.io/github/license/vhs/hyperdrive.svg?style=flat-square)](https://codeberg.org/vhs/hyperdrive/blob/master/COPYING)
