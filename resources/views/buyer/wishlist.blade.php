<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>??</text></svg>">
    <title>Wishlist - BookMart</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

{{-- Navbar --}}
<nav class="bg-white shadow px-6 py-4 flex justify-between items-center">
    <a href="{{ route('books.index') }}" class="text-2xl font-bold text-indigo-600">📚 BookMart</a>
    <div class="flex gap-4">
        <a href="{{ route('buyer.dashboard') }}" class="text-gray-600 hover:text-indigo-600">Dashboard</a>
        <a href="{{ route('cart.index') }}" class="text-gray-600 hover:text-indigo-600">🛒 Cart</a>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="text-gray-600 hover:text-red-500">Logout</button>
        </form>
    </div>
</nav>

<div class="max-w-5xl mx-auto px-4 py-8">

    <h1 class="text-2xl font-bold text-gray-800 mb-6">❤️ My Wishlist</h1>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if($wishlists->isEmpty())
        <div class="bg-white rounded shadow p-12 text-center">
            <p class="text-5xl mb-4">❤️</p>
            <p class="text-xl text-gray-500 mb-4">Your wishlist is empty!</p>
            <a href="{{ route('books.index') }}"
                class="bg-indigo-600 text-white px-6 py-3 rounded hover:bg-indigo-700">
                Browse Books
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($wishlists as $wishlist)
                <div class="bg-white rounded shadow hover:shadow-md transition">
                    <a href="{{ route('books.show', $wishlist->book) }}">
                        @if($wishlist->book->image)
                            <img src="{{ Storage::url($wishlist->book->image) }}"
                                class="w-full h-48 object-cover rounded-t">
                        @else
                            <div class="w-full h-48 bg-indigo-100 flex items-center justify-center rounded-t">
                                <span class="text-5xl">📚</span>
                            </div>
                        @endif
                    </a>
                    <div class="p-4">
                        <h3 class="font-semibold text-gray-800 truncate">{{ $wishlist->book->title }}</h3>
                        <p class="text-gray-500 text-sm">{{ $wishlist->book->author }}</p>
                        <p class="text-indigo-600 font-bold mt-2">৳{{ $wishlist->book->price }}</p>
                        <div class="flex gap-2 mt-3">
                            <a href="{{ route('books.show', $wishlist->book) }}"
                                class="flex-1 text-center bg-indigo-600 text-white py-2 rounded hover:bg-indigo-700 text-sm">
                                View
                            </a>
                            <form method="POST" action="{{ route('wishlist.toggle', $wishlist->book->id) }}">
                                @csrf
                                <button class="bg-red-100 text-red-600 px-3 py-2 rounded hover:bg-red-200 text-sm">
                                    ❤️
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
</body>
</html>