# PHP SDK для MarketСall API
![Packagist Version](https://img.shields.io/packagist/v/supercute/marketcall-sdk-php)
![Packagist Dependency Version](https://img.shields.io/packagist/dependency-v/supercute/marketcall-sdk-php/php)



## Документация

### Merchant
https://www.marketcall.ru/merchant/api/docs

### Affiliate
https://www.marketcall.ru/affiliate/api/docs

## Установка

```bash
composer require supercute/marketcall-sdk-php
```


## Поддержка

### Рекламодатель (Merchant)

- Звонки: список и просмотр, подтверждение, отклонение и комментарий.
- Офферы: список и просмотр с фильтрами.
- Лиды: список и просмотр, подтверждение, перевод в HOLD, отклонение и изменение стоимости.
- Брокерские лиды: добавление лида.
- Счета рекламодателя: получение списка.

### Партнёр (Affiliate)

- Звонки: список, подсчёт и получение записи.
- Номера: список, в том числе без привязанных программ.
- Офферы: список и просмотр, регионы и категории, проверка возможности входящего звонка и доступные инструменты.
- Программы: список и просмотр, создание и отмена, получение промоматериалов.
- Вывод средств.
- Расходы: список и добавление; получение списка категорий и добавление категории.
- Лиды: список и просмотр, добавление лида и отправка Ping-запроса.
- Каналы: список и просмотр, создание.
- Брокерские лиды: список, просмотр, добавление и удаление.
- Постбеки: создание и получение списка шаблонов.

## Пример использования

```php
<?php
use Marketcall\MerchantClient;
use Marketcall\Requests\Merchant\LeadsRequest;

$apiKey = 'API_KEY';
$client = new MerchantClient($apiKey);

// Запрос с фильтрами по статусу и дате
$request = (new LeadsRequest())
    ->setState(['approved', 'pending'])
    ->setDateFrom(new DateTimeImmutable('2025-01-01T00:00:00+00:00'))
    ->setDateTo(new DateTimeImmutable('2025-12-31T23:59:59+00:00'));

try {
    $leadsResult = $client->getLeads($request);

    foreach ($leadsResult->data as $lead) {
        echo "Лид №{$lead->id}, статус: {$lead->state}\n";
    }
} catch (Exception $e) {
    echo "Ошибка: " . $e->getMessage();
}
```

