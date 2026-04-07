<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Договор № {{ $data['contract']['number'] ?? '—' }}</title>
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
        .indent { padding-left: 20px; }
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
    <h1>ДОГОВОР № {{ $data['contract']['number'] ?? '—' }}</h1>
    <p class="subtitle">на оказание услуг</p>

    <div class="header-row">
        <div class="header-left">г. {{ $data['contract']['city'] ?? '—' }}</div>
        <div class="header-right">Дата: {{ $data['contract']['date'] ?? '—' }}</div>
    </div>

    <hr>

    <p class="section-title">1. Стороны договора</p>

    <p><strong>Исполнитель:</strong> {{ $data['contractor']['name'] ?? '—' }}, email: {{ $data['contractor']['email'] ?? '—' }}@if(!empty($data['contractor']['phone'])), тел.: {{ $data['contractor']['phone'] }}@endif</p>
    <p><strong>Заказчик:</strong> {{ $data['client']['name'] ?? '—' }}, email: {{ $data['client']['email'] ?? '—' }}</p>

    <hr>

    <p class="section-title">2. Предмет договора</p>

    <p>2.1. Исполнитель обязуется оказать следующие услуги:</p>
    <p class="indent">{{ $data['service']['description'] ?? '—' }}</p>
    <p>2.2. Заказчик обязуется принять и оплатить оказанные услуги.</p>

    <hr>

    <p class="section-title">3. Сроки оказания услуг</p>

    <p>3.1. Срок выполнения работ: с <strong>{{ $data['service']['start_date'] ?? '—' }}</strong> по <strong>{{ $data['service']['end_date'] ?? '—' }}</strong></p>

    <hr>

    <p class="section-title">4. Стоимость и порядок оплаты</p>

    <p>4.1. Общая стоимость услуг составляет: <strong>{{ $data['payment']['price'] ?? '—' }} {{ $data['payment']['currency'] ?? '' }}</strong></p>
    <p>4.2. Оплата производится на основании выставленного инвойса.</p>
    <p>4.3. Срок оплаты: {{ $data['payment']['terms'] ?? '—' }}</p>

    <hr>

    <p class="section-title">5. Порядок сдачи и приёмки</p>

    <p>5.1. По завершении работ Исполнитель направляет результат Заказчику.</p>
    <p>5.2. Заказчик обязан в течение <strong>{{ $data['meta']['acceptance_days'] ?? '5' }}</strong> дней:</p>
    <ul>
        <li>либо принять работы;</li>
        <li>либо направить мотивированные замечания.</li>
    </ul>
    <p>5.3. При отсутствии ответа работы считаются принятыми.</p>

    <hr>

    <p class="section-title">6. Права и обязанности сторон</p>

    <p><strong>Исполнитель обязуется:</strong></p>
    <ul>
        <li>выполнить услуги качественно и в срок;</li>
        <li>информировать Заказчика о ходе работ.</li>
    </ul>

    <p><strong>Заказчик обязуется:</strong></p>
    <ul>
        <li>предоставить необходимые данные;</li>
        <li>своевременно оплатить услуги.</li>
    </ul>

    <hr>

    <p class="section-title">7. Ответственность сторон</p>

    <p>7.1. За нарушение сроков стороны несут ответственность в виде штрафа: {{ $data['meta']['penalty_terms'] ?? '—' }}</p>
    <p>7.2. Исполнитель не несёт ответственности за убытки, превышающие сумму договора.</p>

    <hr>

    <p class="section-title">8. Конфиденциальность</p>

    <p>Стороны обязуются не разглашать информацию, полученную в рамках настоящего договора.</p>

    <hr>

    <p class="section-title">9. Форс-мажор</p>

    <p>Стороны освобождаются от ответственности при наступлении обстоятельств непреодолимой силы.</p>

    <hr>

    <p class="section-title">10. Заключительные положения</p>

    <p>10.1. Договор вступает в силу с момента подписания обеими сторонами.</p>
    <p>10.2. Все споры решаются путём переговоров.</p>

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
