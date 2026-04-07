<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Invoice {{ $data['meta']['invoice_number'] ?? '' }}</title>
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
            font-size: 20pt;
            font-weight: 700;
            margin: 0 0 4px;
            letter-spacing: 0.05em;
        }
        .inv-number {
            font-size: 12pt;
            color: #555;
            margin-bottom: 6px;
        }
        .inv-date {
            font-size: 10pt;
            color: #777;
            margin-bottom: 30px;
        }
        hr {
            border: none;
            border-top: 1px solid #ccc;
            margin: 20px 0;
        }
        .section-label {
            font-size: 9pt;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: #888;
            margin: 20px 0 6px;
        }
        .parties {
            display: table;
            width: 100%;
            margin-bottom: 10px;
        }
        .party-col {
            display: table-cell;
            width: 50%;
            vertical-align: top;
        }
        p { margin: 3px 0; }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th {
            background: #f5f5f5;
            font-size: 9pt;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            padding: 10px 14px;
            text-align: left;
            border-bottom: 2px solid #ddd;
        }
        td {
            padding: 12px 14px;
            border-bottom: 1px solid #eee;
        }
        td.amount { text-align: right; font-weight: 600; }
        th.amount { text-align: right; }
        .total-row {
            margin-top: 14px;
            text-align: right;
            font-size: 14pt;
            font-weight: 700;
        }
        .details-block p {
            margin: 2px 0;
            font-size: 10pt;
        }
        .note {
            margin-top: 40px;
            font-size: 10pt;
            color: #777;
            font-style: italic;
        }
        .signature {
            margin-top: 50px;
        }
        .sig-line {
            border-bottom: 1px solid #1a1a1a;
            width: 200px;
            display: inline-block;
            margin-top: 24px;
        }
        .sig-name { font-size: 10pt; color: #555; margin-top: 4px; }
    </style>
</head>
<body>
    <h1>INVOICE</h1>
    <p class="inv-number">№ {{ $data['meta']['invoice_number'] ?? '—' }}</p>
    <p class="inv-date">Date: {{ $data['contract']['date'] ?? '—' }}</p>

    <hr>

    <div class="parties">
        <div class="party-col">
            <p class="section-label">From</p>
            <p><strong>{{ $data['contractor']['name'] ?? '—' }}</strong></p>
            <p>{{ $data['contractor']['email'] ?? '—' }}</p>
            @if(!empty($data['contractor']['phone']))
                <p>{{ $data['contractor']['phone'] }}</p>
            @endif
        </div>
        <div class="party-col">
            <p class="section-label">To</p>
            <p><strong>{{ $data['client']['name'] ?? '—' }}</strong></p>
            <p>{{ $data['client']['email'] ?? '—' }}</p>
        </div>
    </div>

    <hr>

    <p class="section-label">Description</p>

    <table>
        <thead>
            <tr>
                <th>Service</th>
                <th>Description</th>
                <th class="amount">Amount</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $data['service']['name'] ?? '—' }}</td>
                <td>{{ $data['service']['description'] ?? '—' }}</td>
                <td class="amount">{{ $data['payment']['price'] ?? '—' }} {{ $data['payment']['currency'] ?? '' }}</td>
            </tr>
        </tbody>
    </table>

    <p class="total-row">Total: {{ $data['payment']['price'] ?? '—' }} {{ $data['payment']['currency'] ?? '' }}</p>

    <hr>

    <div class="parties">
        <div class="party-col">
            <p class="section-label">Payment Terms</p>
            <p>{{ $data['payment']['terms'] ?? '—' }}</p>
        </div>
        <div class="party-col">
            <p class="section-label">Due Date</p>
            <p>{{ $data['payment']['due_date'] ?? '—' }}</p>
        </div>
    </div>

    @if(!empty($data['payment']['details']))
        <p class="section-label">Payment Details</p>
        <div class="details-block">
            <p>{{ $data['payment']['details'] }}</p>
        </div>
    @endif

    <p class="note">Thank you for your business.</p>

    <div class="signature">
        <span class="sig-line"></span>
        <p class="sig-name">{{ $data['contractor']['name'] ?? '' }}</p>
    </div>
</body>
</html>
