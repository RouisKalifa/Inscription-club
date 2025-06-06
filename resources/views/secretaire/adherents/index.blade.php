<x-app-layout>
    <div class="container mx-auto p-4">
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-2xl font-bold">Liste des adhérents</h1>

            <div class="space-x-2">
                <!-- Bouton “Voir les archivés” -->
                <a href="{{ route('secretaire.adherents.archived') }}"
                   class="px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600">
                    {{ __('Voir les archivés') }}
                </a>

                <!-- Bouton “+ Nouvel adhérent” -->
                <a href="{{ route('secretaire.adherents.create') }}"
                   class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    {{ __('+ Nouvel adhérent') }}
                </a>
            </div>
        </div>

        <!-- Message flash “success” -->
        @if(session('success'))
            <div class="mb-4 p-2 bg-green-100 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif

        @if($adherents->isEmpty())
            <p>Aucun adhérent actif pour l’instant.</p>
        @else
            <table class="min-w-full bg-white border">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="px-4 py-2 border">ID</th>
                        <th class="px-4 py-2 border">Nom</th>
                        <th class="px-4 py-2 border">Prénom</th>
                        <th class="px-4 py-2 border">Statut</th>
                        <th class="px-4 py-2 border">Téléphone</th>
                        <th class="px-4 py-2 border">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($adherents as $adherent)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-2 border">{{ $adherent->id }}</td>
                            <td class="px-4 py-2 border">{{ $adherent->nom }}</td>
                            <td class="px-4 py-2 border">{{ $adherent->prenom }}</td>
                            <td class="px-4 py-2 border">{{ ucfirst($adherent->statut) }}</td>
                            <td class="px-4 py-2 border">{{ $adherent->telephone }}</td>
                            <td class="px-4 py-2 border space-x-2">
                                <a href="{{ route('secretaire.adherents.show', $adherent) }}"
                                   class="text-blue-600 hover:underline">
                                    {{ __('Voir') }}
                                </a>
                                <a href="{{ route('secretaire.adherents.edit', $adherent) }}"
                                   class="text-green-600 hover:underline">
                                    {{ __('Éditer') }}
                                </a>
                                <form action="{{ route('secretaire.adherents.destroy', $adherent) }}"
                                      method="POST"
                                      class="inline"
                                      onsubmit="return confirm('Êtes-vous sûr de vouloir archiver cet adhérent ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline">
                                        {{ __('Archiver') }}
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</x-app-layout>
