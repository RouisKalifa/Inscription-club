<x-app-layout>
    <div class="container mx-auto p-4">
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-2xl font-bold">Adhérents archivés</h1>
            <a href="{{ route('secretaire.adherents.index') }}"
               class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400">
                ← Liste des adhérents actifs
            </a>
        </div>

        @if(session('success'))
            <div class="mb-4 p-2 bg-green-100 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif

        @if($archivedAdherents->isEmpty())
            <p>Aucun adhérent archivé pour l’instant.</p>
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
                    @foreach($archivedAdherents as $adherent)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-2 border">{{ $adherent->id }}</td>
                            <td class="px-4 py-2 border">{{ $adherent->nom }}</td>
                            <td class="px-4 py-2 border">{{ $adherent->prenom }}</td>
                            <td class="px-4 py-2 border">{{ ucfirst($adherent->statut) }}</td>
                            <td class="px-4 py-2 border">{{ $adherent->telephone }}</td>
                            <td class="px-4 py-2 border space-x-2">
                                <!-- Bouton “Désarchiver” -->
                                <form action="{{ route('secretaire.adherents.restore', $adherent) }}"
                                      method="POST"
                                      class="inline"
                                      onsubmit="return confirm('Désarchiver cet adhérent ?');">
                                    @csrf
                                    <button type="submit" class="text-blue-600 hover:underline">
                                        Désarchiver
                                    </button>
                                </form>
                                <!-- Vous pouvez aussi avoir un lien “Voir” si vous voulez afficher le détail, mais attention : show() filtrait peut-être sur est_archive=false => à adapter -->
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</x-app-layout>
