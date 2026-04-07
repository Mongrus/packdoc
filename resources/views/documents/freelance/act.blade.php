<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Акт № {{ $data['meta']['act_number'] ?? '—' }}</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 11pt;
            color: #1a1a1a;
            line-height: 1.7;
            margin: 0;
            padding: 50px 60px;
        }
        h1 {
            font-size: 16pt;
            text-align: center;
            margin: 0 0 4px;
            font-weight: 700;
        }
        .subtitle {
            text-align: center;
            font-size: 12pt;
            color: #444;
            margin-bottom: 24px;
        }
        .header-row {
            display: table;
            width: 100%;
            margin-bottom: 28px;
        }
        .header-left, .header-right {
            display: table-cell;
            width: 50%;
            vertical-align: top;
        }
        .header-right { text-align: right; }
        hr {
            border: none;
            border-top: 1px solid #ccc;
            margin: 20px 0;
        }
        .section-title {
            font-size: 11pt;
            font-weight: 700;
            text-transform: uppercase;
            margin: 24px 0 10px;
            letter-spacing: 0.03em;
        }
        p { margin: 4px 0; }
        ul { margin: 6px 0; padding-left: 24px; }
        ul li { margin-bottom: 3px; }
        .signatures {
            display: table;
            width: 100%;
            margin-top: 50px;
        }
        .sig-col {
            display: table-cell;
            width: 50%;
            vertical-align: top;
        }
        .sig-line {
            border-bottom: 1px solid #1a1a1a;
            width: 200px;
            display: inline-block;
            margin-top: 30px;
        }
        .sig-name { font-size: 10pt; color: #555; margin-top: 4px; }
    </style>
</head>
<body>
    <h1>АКТ № {{ $data['meta']['act_number'] ?? '—' }}</h1>
    <p class="subtitle">выполненных работ</p>

    <div class="header-row">
        <div class="header-left">г. {{ $data['contract']['city'] ?? '—' }}</div>
        <div class="header-right">Дата: {{ $data['contract']['date'] ?? '—' }}</div>
    </div>

    <hr>

    <p class="section-title">1. Стороны</p>

    <p><strong>Исполнитель:</strong> {{ $data['contractor']['name'] ?? '—' }}</p>
    <p><strong>Заказчик:</strong> {{ $data['client']['name'] ?? '—' }}</p>

    <hr>

    <p class="section-title">2. Основание</p>

    <p>Договор № {{ $data['contract']['number'] ?? '—' }} от {{ $data['contract']['date'] ?? '—' }}</p>

    <hr>

    <p class="section-title">3. Выполненные работы</p>

    <p>{{ $data['service']['description'] ?? '—' }}</p>

    <hr>

    <p class="section-title">4. Стоимость</p>

    <p>Общая стоимость выполненных работ: <strong>{{ $data['payment']['price'] ?? '—' }} {{ $data['payment']['currency'] ?? '' }}</strong></p>

    <hr>

    <p class="section-title">5. Подтверждение</p>

    <p>Стороны подтверждают, что:</p>
    <ul>
        <li>работы выполнены в полном объёме;</li>
        <li>претензий по качеству и срокам нет.</li>
    </ul>

    <hr>

    <p class="section-title">6. Юридическое значение</p>

    <p>Настоящий акт является основанием для окончательного расчёта между сторонами.</p>

    <hr>

    <div class="signatures">
        <div class="sig-col">
            <p><strong>Исполнитель:</strong></p>
            <span class="sig-line"></span>
            <p class="sig-name">{{ $data['contractor']['name'] ?? '' }}</p>
        </div>
        <div class="sig-col">
            <p><strong>Заказчик:</strong></p>
            <span class="sig-line"></span>
            <p class="sig-name">{{ $data['client']['name'] ?? '' }}</p>
        </div>
    </div>
</body>
</html>
