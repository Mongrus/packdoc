<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Предпросмотр документов</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            margin: 0;
            padding: 0;
            color: #1a1a1a;
            line-height: 1.7;
            font-size: 11pt;
        }
        .document {
            padding: 50px 60px;
        }
        .document + .document {
            page-break-before: always;
        }
        h1 {
            font-size: 16pt;
            text-align: center;
            margin: 0 0 4px;
            font-weight: 700;
        }
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
    @foreach($sections as $section)
        <div class="document">
            {!! $section !!}
        </div>
    @endforeach
</body>
</html>
