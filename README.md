# PHP SDK для MarketСall API

## Документация

https://www.marketcall.ru/merchant/api/docs

## Установка

```bash
composer require supercute/marketcall-sdk-php
```


## Поддержка

1. Звонки
2. Офферы
3. Лиды
4. Брокер
5. Счета

## Пример использования

```php
<?php
use Marketcall\Client;use Marketcall\Request\Leads\LeadsRequest;

$apiKey = 'API_KEY';
$client = new Client($apiKey);

// Запрос с фильтрами по статусу и дате
$request = (new LeadsRequest())
    ->setStates(['approved', 'pending'])
    ->setDateFrom(new DateTimeImmutable('2025-01-01T00:00:00+00:00'))
    ->setDateTo(new DateTimeImmutable('2025-12-31T23:59:59+00:00'));

try {
    $leadsResult = $client->getLeads($request);

    foreach ($leadsResult['data'] as $lead) {
        echo "Лид №{$lead->id}, статус: {$lead->state}\n";
    }
} catch (Exception $e) {
    echo "Ошибка: " . $e->getMessage();
}
```

