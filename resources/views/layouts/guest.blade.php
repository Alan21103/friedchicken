<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - My Fried Chiken</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans text-gray-900 antialiased bg-[#E5E5E5] min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-[1100px] bg-white rounded-[50px] shadow-lg overflow-hidden flex flex-col md:flex-row min-h-[600px]">
        {{ $slot }}
    </div>
</body>
</html>