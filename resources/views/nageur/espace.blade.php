<x-app-layout>
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Espace Nageur</h1>
        <p>Bienvenue, {{ Auth::user()->name }} !</p>
    </div>
</x-app-layout>