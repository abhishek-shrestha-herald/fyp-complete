@props([
    'pageName' => ''
])

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }} | {{ $pageName }}</title>

    <link rel="shortcut icon" href="/assets/images/favicon/favicon.ico" type="image/x-icon">

    <link rel="stylesheet" href="/assets/css/main.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Roboto:wght@400;500;700&display=swap"
        rel="stylesheet">

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        @vite([
            'resources/css/app.css',
            'resources/css/ecommerce.css',
            'resources/js/app.js',
        ])
    </head>

<body>
    <livewire:toasts />

    <x-partials.header/>
    <x-partials.navbar/>

    {{ $slot }}

    <x-partials.footer/>

    @livewireScriptConfig
</body>

</html>
