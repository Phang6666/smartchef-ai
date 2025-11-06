<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartChef AI</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 text-gray-800">

    <!-- Navbar -->
    <nav class="bg-white shadow-md p-4">
        <div class="container mx-auto">
            <h1 class="text-2xl font-bold text-green-600">🍲 SmartChef AI</h1>
        </div>
    </nav>

    <!-- Hero Section -->
    <main class="container mx-auto p-6">
        <div class="text-center my-12">
            <h2 class="text-4xl font-bold mb-2">Turn Your Leftovers Into A Masterpiece!</h2>
            <p class="text-gray-600">Enter the ingredients you have, and our AI will create a custom recipe for you.</p>
        </div>

        <!-- Input Form -->
        <div class="max-w-2xl mx-auto bg-white p-8 rounded-lg shadow-lg">
            <form action="{{ route('recipe.generate') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="ingredients" class="block text-lg font-medium mb-2">Your Ingredients:</label>
                    <input type="text" name="ingredients" id="ingredients" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500" placeholder="e.g., chicken breast, tomatoes, rice, onion" required>
                </div>
                <button type="submit" class="w-full bg-green-600 text-white font-bold py-3 px-4 rounded-lg hover:bg-green-700 transition duration-300">
                    Generate Recipe
                </button>
            </form>
        </div>

        <!-- Recipe Display Area -->
        @if (isset($recipe))
            <div class="max-w-2xl mx-auto bg-white p-8 rounded-lg shadow-lg mt-10">
                <h3 class="text-3xl font-bold mb-4">Your AI-Generated Recipe</h3>
                <div class="prose max-w-none">
                    {!! \Illuminate\Support\Str::markdown($recipe) !!}
                </div>
            </div>
        @endif

        {{-- ADD THIS BLOCK TO SHOW ERRORS --}}
        @if (isset($error))
            <div class="max-w-2xl mx-auto bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg shadow-lg mt-10" role="alert">
                <strong class="font-bold">Error!</strong>
                <span class="block sm:inline">{{ $error }}</span>
            </div>
        @endif
    </main>

    <!-- Footer -->
    <footer class="text-center p-6 mt-12 text-gray-500">
        <p>Built by Phang Jet | Powered by Google Gemini AI</p>
    </footer>

</body>
</html>