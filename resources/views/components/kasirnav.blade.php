<div class="h-screen flex">
    <nav class="bg-[#5A9CB5] w-1/5 p-4">
        <div class="container mx-auto flex flex-col items-start">
            <div class="flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="mr-2" width="20" height="20" viewBox="0 0 432 384"><path fill="#fff" d="M384 0q18 0 30.5 12.5T427 43v64q0 17-12.5 29.5T384 149h-43v64q0 36-25 61t-60 25H128q-35 0-60-25t-25-61V0h341zm0 107V43h-43v64h43zM0 384v-43h384v43H0z"/></svg>
            <a href="/ahome" class="text-white text-lg font-bold">CoffeeCafe</a>
            </div>
            <h1 class="text-white font-semibold hover:text-white  py-2">Welcome, {{ auth()->user()->name }}!</h1>
            <hr class="m-3">
            
            <a href="/ahome" class="text-white px-3 py-2 hover:text-gray-600 hover:bg-[#FACE68] active:bg-[#FACE68] w-full">Dashboard</a>
            <a href="" class="text-white px-3 py-2 hover:text-gray-600 hover:bg-[#FACE68] active:bg-[#FACE68] w-full">Menu</a>
            <hr class="m-3">
            <form action="/logout" method="POST" class="inline ">
                @csrf
                <button class="text-white px-3 py-2 active:bg-red-600 w-full hover:bg-[#FA6868] cursor-pointer">Logout</button>
            </form>
            
        </div>
    </nav>
    <div class="flex-1 p-4"></div>