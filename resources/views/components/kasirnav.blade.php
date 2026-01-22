<nav class="bg-[#5A9CB5] w-64 p-4 flex flex-col">
    <div class="flex items-center mb-6">
        <svg xmlns="http://www.w3.org/2000/svg" class="mr-2" width="20" height="20" viewBox="0 0 432 384"><path fill="#fff" d="M384 0q18 0 30.5 12.5T427 43v64q0 17-12.5 29.5T384 149h-43v64q0 36-25 61t-60 25H128q-35 0-60-25t-25-61V0h341zm0 107V43h-43v64h43zM0 384v-43h384v43H0z"/></svg>
        <a href="{{ route('kasir.dashboard') }}" class="text-white text-lg font-bold">CoffeeCafe</a>
    </div>
    <h1 class="text-white font-semibold hover:text-white py-2">Welcome, {{ auth()->user()->name }}!</h1>

    
    <a href="{{ route('kasir.dashboard') }}" class="text-white px-3 py-2 rounded-md hover:bg-white/20 {{ request()->routeIs('kasir.dashboard') ? 'bg-white/30' : '' }}">Dashboard</a>
    <a href="{{ route('kasir.transaction.index') }}" class="text-white px-3 py-2 rounded-md hover:bg-white/20 {{ request()->routeIs('kasir.transaction.index') ? 'bg-white/30' : '' }}">Transaksi</a>
    
    <div class="mt-auto">

        <form action="/logout" method="POST" class="inline w-full">
            @csrf
            <button class="text-white px-3 py-2 w-full text-left rounded-md hover:bg-red-500/50 cursor-pointer">Logout</button>
        </form>
    </div>
</nav>