<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>CoffeeCafe</title>
    @vite('resources/css/app.css')
</head>
<body>
    @auth
        <x-navbar />
        <div class="p-6">
            <h1 class="text-3xl font-bold mb-4">Welcome, {{ auth()->user()->name }}!</h1>
            <p class="text-lg">This is your dashboard where you can manage your cafe efficiently.</p>
            </div>
    @else
    
    @endauth
</body>
</html>