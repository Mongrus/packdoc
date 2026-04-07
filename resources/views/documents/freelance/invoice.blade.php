<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Инвойс (фриланс)</title>
    <style>
        body { font-family: 'DejaVu Sans', sans-serif; max-width: 800px; margin: 40px auto; padding: 0 20px; color: #1a1a1a; line-height: 1.6; }
        h1 { font-size: 1.5rem; border-bottom: 2px solid #4f46e5; padding-bottom: 8px; }
        .section { margin-top: 24px; }
        .label { font-weight: 600; color: #555; }
        table { width: 100%; border-collapse: collapse; margin-top: 12px; }
        th, td { border: 1px solid #ddd; padding: 10px 14px; text-align: left; }
        th { background: #f5f5f5; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.05em; }
        .total { font-weight: 700; font-size: 1.1rem; }
    </style>
</head>
<body>
    <h1>Инвойс</h1>

    <div class="section">
        <p><span class="label">Дата:</span> {{ $data['date'] ?? '—' }}</p>
    </div>

    <div class="section">
        <h2>От кого</h2>
        <p>{{ $data['contractor_name'] ?? '—' }}</p>
        <p>{{ $data['contractor_email'] ?? '—' }} · {{ $data['contractor_phone'] ?? '—' }}</p>
    </div>

    <div class="section">
        <h2>Кому</h2>
        <p>{{ $data['client_name'] ?? '—' }}</p>
        <p>{{ $data['client_email'] ?? '—' }}</p>
    </div>

    <div class="section">
        <table>
            <thead>
                <tr>
                    <th>Услуга</th>
                    <th>Описание</th>
                    <th style="text-align:right">Сумма</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $data['service'] ?? '—' }}</td>
                    <td>{{ $data['service_description'] ?? '—' }}</td>
                    <td style="text-align:right">{{ $data['price'] ?? '—' }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="section" style="text-align:right">
        <p class="total">Итого: {{ $data['price'] ?? '—' }}</p>
    </div>
</body>
</html>
