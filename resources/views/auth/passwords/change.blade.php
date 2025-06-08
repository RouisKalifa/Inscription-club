<x-app-layout>
    <div class="container mx-auto p-4 max-w-md">
        <h1 class="text-2xl font-bold mb-4">Changer mon mot de passe</h1>

        <!-- Message de succès -->
        @if(session('success'))
            <div class="mb-4 p-2 bg-green-100 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif

        <!-- Erreurs de validation -->
        @if($errors->any())
            <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
                <ul class="list-disc list-inside">
                  @foreach($errors->all() as $e)
                    <li>{{ $e }}</li>
                  @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('password.update') }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Ancien mot de passe -->
            <div class="mb-4">
                <label for="current_password" class="block text-sm font-medium text-gray-700">
                    Ancien mot de passe
                </label>
                <input type="password"
                       name="current_password"
                       id="current_password"
                       required
                       onpaste="return false;"
                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" />
            </div>

            <!-- Nouveau mot de passe -->
            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700">
                    Nouveau mot de passe
                </label>
                <input type="password"
                       name="password"
                       id="password"
                       required
                       onpaste="return false;"
                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" />
            </div>

            <!-- Confirmation -->
            <div class="mb-6">
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">
                    Confirmer le mot de passe
                </label>
                <input type="password"
                       name="password_confirmation"
                       id="password_confirmation"
                       required
                       onpaste="return false;"
                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" />
            </div>

            <button type="submit"
                    class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                Enregistrer
            </button>
        </form>
    </div>
</x-app-layout>
