<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Slinkie sludinājumi' }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css">
    <style>
        :root {
            --color-white-shade: #fbfef9;
            --color-black-shade: #191923;
            --color-blue-shade: #0e79b2;
        }

        body {
            background-color: var(--color-white-shade);
            color: var(--color-black-shade);
        }

        .navbar-custom {
            background-color: var(--color-black-shade) !important;
        }

        .btn-primary-custom {
            background-color: var(--color-blue-shade);
            border-color: var(--color-blue-shade);
            color: var(--color-white-shade);
        }

        .btn-primary-custom:hover {
            background-color: #0a5d8a;
            border-color: #0a5d8a;
            color: var(--color-white-shade);
        }

        .card-custom {
            background-color: var(--color-white-shade);
            border: 1px solid #e0e0e0;
        }

        .card-custom:hover {
            box-shadow: 0 4px 12px rgba(14, 121, 178, 0.15);
            transition: box-shadow 0.3s ease;
        }

        .text-primary-custom {
            color: var(--color-blue-shade);
        }

        .bg-primary-custom {
            background-color: var(--color-blue-shade);
        }

        .alert-success-custom {
            background-color: #d4edda;
            border-color: var(--color-blue-shade);
            color: var(--color-black-shade);
        }
    </style>
</head>
<body>
    <x-navbar />

    <main class="container mt-4">
        @if(session('success'))
            <div class="alert alert-success alert-success-custom">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        {{ $slot }}
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>