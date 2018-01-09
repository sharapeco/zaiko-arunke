<img alt="＊" src="https://github.com/sharapeco/zaiko-arunke/blob/master/web/assets/img/favicon.jpg?raw=true" width="32" height="32">  在庫あるんけ（仮）
=================================

在庫あるんけ (仮) is a simple personal inventory manager made in PHP [Yii Framework 2](http://www.yiiframework.com).

<img alt="[画面イメージ 1]" src="https://github.com/sharapeco/zaiko-arunke/blob/master/web/assets/img/screenshot1.png?raw=true" width="375"> <img alt="[画面イメージ 2]" src="https://github.com/sharapeco/zaiko-arunke/blob/master/web/assets/img/screenshot2.png?raw=true" width="375">



Requirements
------------

The minimum requirement by this project template that your Web server supports PHP 5.4.0.


Installation
------------

### Install via GitHub

You can then install this application using the following command:

~~~
git clone git://github.com/sharapeco/zaiko-arunke.git
~~~


### Configuration

Copy the file `migrations/zaiko-arunke.db` to suitable directory.

Edit the file `config/db.php` with real data, for example:

```php
return [
	'class' => 'yii\db\Connection',
	'dsn' => 'sqlite:' . __DIR__ . '/../path/to/zaiko-arunke.db',
	'charset' => 'utf8',
	'enableSchemaCache' => false,
];
```

Edit `config/web.php` to set time zone and language, for example:

```php
    'timeZone' => 'Pacific/Honolulu',
    'language' => 'en-US',
```


### Run

Now you should be able to access the application through the following URL, assuming `zaiko-arunke` is the directory
directly under the Web root.

~~~
http://localhost/zaiko-arunke/web/
~~~

Use the user “neo” and password “neo”.


Thanks to
-------------
[![Yii2](https://img.shields.io/badge/Powered_by-Yii_Framework-green.svg?style=flat)](http://www.yiiframework.com)
