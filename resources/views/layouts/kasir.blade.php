<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>CoffeeCafe</title>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100">
    @auth
    <div class="flex h-screen">
        <x-kasirnav />
        <main class="flex-1 p-6 overflow-y-auto">
            @yield('content')
        </main>
    </div>
    @else
    {{-- This part probably leads to the login page if not authenticated --}}
    <div class="flex items-center justify-center h-screen">
        <a href="/" class="text-blue-500">Please login</a>
    </div>
    @endauth
</body>