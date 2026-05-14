# Packdock

[![Laravel 13](https://img.shields.io/badge/Laravel-13-FF2D20?logo=laravel&logoColor=white)](https://laravel.com/)
[![Vue 3](https://img.shields.io/badge/Vue-3-4FC08D?logo=vuedotjs&logoColor=white)](https://vuejs.org/)
[![Inertia 2](https://img.shields.io/badge/Inertia-2-9553E9?logo=inertia&logoColor=white)](https://inertiajs.com/)
[![Vite 6](https://img.shields.io/badge/Vite-6-646CFF?logo=vite&logoColor=white)](https://vite.dev/)
[![DomPDF](https://img.shields.io/badge/PDF-DomPDF-EF4444)](https://github.com/barryvdh/laravel-dompdf)
[![PHPUnit 12](https://img.shields.io/badge/PHPUnit-12-3C9CD7)](https://phpunit.de/)

> [English version](README.en.md)

Веб-сервис для быстрого формирования пакетов юридических и бизнес-документов: договоры, акты, счета, инвойсы. Пользователь выбирает направление (фриланс, бытовые услуги, консалтинг, обучение, строительство, юр. услуги), проходит анкету — и получает готовый комплект PDF.

Монолит на **Laravel 13** + **Vue 3** через **Inertia.js**. Рендеринг документов — **DomPDF** (Blade → HTML → PDF) с поддержкой кириллицы.

<p align="center">
  <img src="docs/assets/screenshot.png" alt="Packdock — выбор направления для пакета документов" width="800">
</p>

---

## Возможности

- **Карточный выбор направления** — фриланс, бытовые услуги, консалтинг, обучение / репетиторство, строительство / подряд, юридические услуги (часть направлений в разработке)
- **Анкета пакета** — структурированный ввод данных по разделам: договор, исполнитель, клиент, услуга, оплата, мета-поля (номер акта, дни приёмки, штрафные санкции)
- **Пред-заполнение из профиля** — реквизиты исполнителя (ФИО, компания, ИНН, телефон, валюта по умолчанию) подтягиваются автоматически
- **Генерация комплекта** — для фриланса в пакет входят договор, акт выполненных работ и инвойс
- **PDF-рендеринг** — DomPDF на базе Blade-шаблонов, формат A4, шрифт DejaVu Sans (кириллица)
- **Превью всего пакета одним PDF** — `streamCombinedPdf` склеивает HTML-фрагменты документов в единый предпросмотр
- **Черновики и завершённые пакеты** — статус `draft` / `completed`, возврат к незаконченной анкете
- **Дублирование пакета** — создание нового на основе существующего (статус сбрасывается в draft)
- **Скачивание / предпросмотр отдельных документов** — три действия на каждый документ: HTML-рендер, inline-превью PDF, скачивание PDF
- **Подписка** — статус `free` / `trial` / `paid` + счётчик созданных пакетов (`package_created_count`)
- **Авторизация Laravel Breeze (Inertia)** — регистрация, вход, восстановление пароля, подтверждение email

---

## Стек технологий

| Слой | Технологии |
|------|-----------|
| Backend | Laravel 13, Sanctum 4, Inertia Laravel 2, Ziggy 2, Eloquent ORM, SQLite |
| Frontend | Vue 3 (Composition API), Inertia.js Vue 3, Vite 6, Tailwind CSS 3, Axios |
| PDF | barryvdh/laravel-dompdf 3, Blade-шаблоны, DejaVu Sans |
| Auth | Laravel Breeze (Inertia stack) |
| Тесты | PHPUnit 12 (feature + unit) |
| Тулинг | Laravel Pail (логи), Laravel Pint (style), Concurrently (dev-режим) |

---

## Архитектура

### Workflow генерации пакета

```
Пользователь ──► /packages/create ──► Выбор направления (карточки)
                                              │
                                              ▼
                                /packages/create/{category}
                                              │
                                              ▼
                                  Анкета (Questionnaire.vue)
                       — пред-заполнение из UserProfile
                       — секции: contract / contractor / client / service / payment / meta
                                              │
                          ┌───────────────────┼───────────────────┐
                          ▼                   ▼                   ▼
                   POST /packages       POST /preview      POST /draft
                  status: completed   stream combined PDF  status: draft
                          │                                       │
                          ▼                                       ▼
                  DocumentPackage (data JSON)            возврат в /packages
                          │
                          ▼
              /packages/{id}/documents
                          │
              ┌───────────┼────────────┐
              ▼           ▼            ▼
         render HTML  preview PDF  download PDF
                      (stream)     (attachment)
                          │
                          ▼
              DomPDF: Blade → HTML → PDF (A4, DejaVu Sans)
```

### Хранение данных пакета

`DocumentPackage` хранит ввод анкеты в JSON-поле `data` — без отдельной таблицы на каждое направление. Структура:

```
data
├── contract        # номер, дата, город
├── contractor      # ФИО, email, телефон
├── client          # ФИО / компания, email
├── service         # название, описание, даты начала / окончания
├── payment         # цена, валюта, условия, реквизиты, срок оплаты
└── meta            # номер акта, номер инвойса, дни приёмки, штрафы
```

Поле `type` (`freelance`, в roadmap — `household`, `consulting`, …) определяет, какие Blade-шаблоны рендерятся: `documents.{$type}.{$document}`. Добавление нового направления = новая папка шаблонов + ветка в `DocumentPackageController`.

### Подписка

`User.subscription_status` (`free` / `trial` / `paid`) и `User.package_created_count` живут на модели пользователя. Это база для будущих лимитов на бесплатном тарифе и биллинга.

### Авторизация

Laravel Breeze в Inertia-варианте: сессии + CSRF, гостевые маршруты (`/`, `/login`, `/register`) и защищённые `auth` middleware (`/dashboard`, `/packages`, `/profile`, `/account`).

---

## Структура проекта

```
packdock/
├── app/
│   ├── Enums/                  # DocumentPackageStatus, DocumentType, EmploymentType, SubscriptionStatus
│   ├── Http/
│   │   ├── Controllers/        # Dashboard, DocumentPackage, Profile, UserProfile, Auth/*
│   │   ├── Middleware/
│   │   └── Requests/
│   ├── Models/                 # User, UserProfile, DocumentPackage, DocumentCategory, DocumentTemplate
│   ├── Providers/
│   └── Services/
│       └── DocumentGeneratorService.php   # обёртка над DomPDF (download / stream / combined)
├── resources/
│   ├── js/
│   │   ├── Components/         # Header, Footer, Modal, DocumentPreview, UserProfileForm, …
│   │   ├── Composables/
│   │   ├── Layouts/            # AppLayout, AuthenticatedLayout, GuestLayout
│   │   └── Pages/              # Welcome, Dashboard, Packages, Packages/{Create,Questionnaire,Documents}, Account, Profile, Auth/*
│   └── views/
│       └── documents/
│           ├── freelance/      # contract.blade.php, act.blade.php, invoice.blade.php
│           └── preview-all.blade.php
├── routes/
│   ├── web.php                 # Inertia + auth-защищённые маршруты
│   └── auth.php                # Breeze
├── database/
│   ├── migrations/             # users (+ subscription), user_profiles, document_categories/templates, document_packages
│   └── seeders/                # DocumentCategorySeeder, DocumentTemplateSeeder, UserProfileSeeder, DocumentPackageSeeder
└── tests/
    ├── Feature/                # Auth/*, ProfileTest
    └── Unit/
```

---

## Быстрый старт

### Требования

- PHP >= 8.3
- Node.js >= 20
- Composer
- SQLite (по умолчанию; для другой СУБД — поправить `DB_*` в `.env`)

### Установка

```bash
composer install
cp .env.example .env
php artisan key:generate
touch database/database.sqlite
php artisan migrate --seed

npm install
npm run build       # или npm run dev в режиме разработки
```

### Запуск

В одну команду (server + queue + logs + vite):

```bash
composer dev
```

Или раздельно:

```bash
php artisan serve   # http://localhost:8000
npm run dev         # vite dev-сервер
```

---

## Маршруты

Все защищённые маршруты — под middleware `auth`. Аутентификация через Laravel Breeze (`/login`, `/register`, `/forgot-password` и т. д.) подключается из `routes/auth.php`.

| Метод | Путь | Назначение | Auth |
|-------|------|------------|:----:|
| `GET` | `/` | Welcome | — |
| `GET` | `/dashboard` | Личный кабинет | + |
| `GET` | `/packages` | Список пакетов пользователя (пагинация 20) | + |
| `GET` | `/packages/create` | Выбор направления | + |
| `GET` | `/packages/create/{category}` | Анкета направления | + |
| `POST` | `/packages` | Создать пакет (`status: completed`) | + |
| `POST` | `/packages/preview` | Склеенный PDF-предпросмотр всех документов | + |
| `POST` | `/packages/draft` | Сохранить черновик | + |
| `GET` | `/packages/{package}/edit` | Редактирование пакета | + |
| `PUT` | `/packages/{package}` | Обновить пакет | + |
| `POST` | `/packages/{package}/draft` | Перевести пакет в черновик | + |
| `GET` | `/packages/{package}/documents` | Список документов пакета | + |
| `GET` | `/packages/{package}/documents/{document}` | HTML-рендер документа | + |
| `GET` | `/packages/{package}/documents/{document}/preview` | Inline-превью PDF | + |
| `GET` | `/packages/{package}/documents/{document}/pdf` | Скачать PDF | + |
| `POST` | `/packages/{package}/duplicate` | Дублировать пакет | + |
| `DELETE` | `/packages/{package}` | Удалить пакет | + |
| `GET` | `/profile` | Настройки аккаунта | + |
| `PATCH` | `/profile` | Обновить аккаунт | + |
| `DELETE` | `/profile` | Удалить аккаунт | + |
| `GET` | `/account` | Профиль исполнителя | + |
| `PUT` | `/user-profile` | Обновить профиль исполнителя | + |

---

## Тесты

```bash
php artisan test
```

Покрытие: регистрация / вход / выход, восстановление пароля, подтверждение email, обновление пароля, обновление профиля, удаление аккаунта.

---

## Ключевые инженерные решения

| Решение | Почему |
|---------|--------|
| **Inertia вместо отдельного SPA + REST** | Один стек, общие маршруты, server-driven навигация — нет дублирования роутинга и валидации |
| **JSON-поле `data` в `DocumentPackage`** | Анкеты сильно различаются между направлениями; нормализация под каждое направление — преждевременная сложность |
| **`type`-driven Blade-шаблоны (`documents.{type}.{slug}`)** | Новое направление = новая папка шаблонов, без правок в сервисе генерации |
| **DomPDF + DejaVu Sans** | Поддержка кириллицы из коробки, рендеринг через знакомый HTML/CSS, не нужен headless-браузер |
| **Склейка preview через `<body>`-extraction** | Объединение нескольких документов в один PDF без хака с iframe / отдельной библиотеки PDF-merge |
| **Черновики на уровне статуса, не отдельной таблицы** | Один и тот же тип записи проходит весь lifecycle (draft → completed) — проще миграции и аналитика |
| **Laravel Breeze (Inertia)** | Стандартный auth-скейфолд под выбранный стек, без самописной реализации |

---

## Roadmap

- [ ] Пакет «Бытовые услуги» (договор + акт + счёт)
- [ ] Пакет «Консалтинг» (договор + план работ + акт + счёт)
- [ ] Пакет «Обучение / репетиторство»
- [ ] Пакет «Строительство / подряд»
- [ ] Пакет «Юридические услуги»
- [ ] Экспорт в DOCX (`DocumentType::Docx` уже зарезервирован)
- [ ] Электронная подпись документов
- [ ] Биллинг и лимиты на free-тарифе
- [ ] Email-уведомления (отправка пакета клиенту)
- [ ] E2E-тесты Vue-страниц

---

## Авторы

**Серенко Роман**
