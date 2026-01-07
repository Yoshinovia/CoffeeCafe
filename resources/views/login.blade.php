<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CoffeeCafe</title>
    @vite('resources/css/app.css')
</head>
<body>
    <div class="min-h-screen flex items-center justify-center bg-gray-100 p-4">
    <div class="flex max-w-5xl w-full bg-white rounded-3xl shadow-2xl overflow-hidden">
        <div class="hidden lg:block w-1/2 p-10 relative">
            <div class="absolute inset-0 rounded-l-3xl">
                <img src="{{ asset('img/coffee-login.jpg') }}" alt="coffee image">
            </div>
            
            <div class="relative h-full flex flex-col justify-between text-white">
                <span class="text-3xl font-bold">*</span>
                
                
            </div>
        </div>

        <div class="w-full lg:w-1/2 p-12 py-16">
            <div class="flex items-center justify-center min-h-screen">
        <div class="max-w-md mx-auto">
            
            <h2 class="text-4xl font-bold text-gray-900 mt-4 mb-2">
                Login
            </h2>
            <p class="text-gray-500 mb-8">
                Memanage cafe jadi lebih cepat,efektif dan efisien.
            </p>

            <form class="space-y-6" action="/login" method="POST">
                @csrf
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Your email</label>
                    <div class="mt-1">
                        <input name="email" type="email" placeholder="example@gmail.com" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 shadow-sm transition duration-150 ease-in-out">
                    </div>
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <div class="mt-1 relative">    
                        <input name="password" type="password" placeholder="password" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 shadow-sm transition duration-150 ease-in-out pr-10">
                    </div>
                </div>

                <div>
                    <button type="submit" 
                        class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-lg font-medium text-white bg-[#5A9CB5] hover:bg-[#4A7A8C] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#5A9CB5] transition duration-150 ease-in-out cursor-pointer">
                        Login
                    </button>
                </div>
            </form>
        </div>
            </div>
    </div>
</div>
</body>
</html>