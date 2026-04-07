<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Акт выполненных работ</title>
    <style>
        body { font-family: 'DejaVu Sans', sans-serif; max-width: 800px; margin: 40px auto; padding: 0 20px; color: #1a1a1a; line-height: 1.6; }
        h1 { font-size: 1.5rem; border-bottom: 2px solid #4f46e5; padding-bottom: 8px; }
        .section { margin-top: 24px; }
        .label { font-weight: 600; color: #555; }
    </style>
</head>
<body>
    <h1>Акт выполненных работ (фриланс)</h1>

    <div class="section">
        <p><span class="label">Дата:</span> {{ $data['date'] ?? '—' }}</p>
    </div>

    <div class="section">
        <h2>Исполнитель</h2>
        <p><span class="label">ФИО:</span> {{ $data['contractor_name'] ?? '—' }}</p>
        <p><span class="label">Email:</span> {{ $data['contractor_email'] ?? '—' }}</p>
        <p><span class="label">Телефон:</span> {{ $data['contractor_phone'] ?? '—' }}</p>
    </div>

    <div class="section">
        <h2>Заказчик</h2>
        <p><span class="label">ФИО / Компания:</span> {{ $data['client_name'] ?? '—' }}</p>
        <p><span class="label">Email:</span> {{ $data['client_email'] ?? '—' }}</p>
    </div>

    <div class="section">
        <h2>Выполненные работы</h2>
        <p><span class="label">Услуга:</span> {{ $data['service'] ?? '—' }}</p>
        <p><span class="label">Описание:</span> {{ $data['service_description'] ?? '—' }}</p>
        <p><span class="label">Стоимость:</span> {{ $data['price'] ?? '—' }}</p>
    </div>

    <div class="section">
        <p>Работы выполнены в полном объёме. Стороны претензий не имеют.</p>
    </div>
</body>
</html>
