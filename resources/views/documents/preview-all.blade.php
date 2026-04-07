<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Предпросмотр документов</title>
    <style>
        body { font-family: 'DejaVu Sans', sans-serif; margin: 0; padding: 0; color: #1a1a1a; line-height: 1.6; }
        .document { max-width: 800px; margin: 0 auto; padding: 40px 20px; }
        .document + .document { page-break-before: always; }
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
    @foreach($sections as $section)
        <div class="document">
            {!! $section !!}
        </div>
    @endforeach
</body>
</html>
