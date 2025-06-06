<x-app-layout>
    <div class="container mx-auto p-4 max-w-2xl">
        {{-- Bouton “Retour à la liste” --}}
        <a href="{{ route('secretaire.adherents.index') }}"
           class="inline-block mb-6 px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400">
            ← Retour à la liste
        </a>

        <h1 class="text-2xl font-bold mb-4">Détails de l’adhérent</h1>

        <div class="bg-white shadow rounded p-6 space-y-4">
            {{-- Photo du trombinoscope --}}
            @if($adherent->photo_path)
                <div class="mb-4">
                    <img src="{{ asset('storage/' . $adherent->photo_path) }}"
                         alt="Photo de {{ $adherent->prenom }} {{ $adherent->nom }}"
                         class="w-32 h-32 object-cover rounded-full border" />
                </div>
            @endif

            <p><strong>ID :</strong> {{ $adherent->id }}</p>
            <p><strong>Prénom :</strong> {{ $adherent->prenom }}</p>
            <p><strong>Nom :</strong> {{ $adherent->nom }}</p>
            <p><strong>Date de naissance :</strong>
               {{ $adherent->date_naissance 
                    ? $adherent->date_naissance->format('d/m/Y')
                    : 'Non renseignée' }}
            </p>
            <p><strong>Adresse :</strong> {{ $adherent->adresse ?? 'Non renseignée' }}</p>
            <p><strong>Ville :</strong> {{ $adherent->ville ?? 'Non renseignée' }}</p>
            <p><strong>Code postal :</strong> {{ $adherent->code_postal ?? 'Non renseigné' }}</p>
            <p><strong>Téléphone :</strong> {{ $adherent->telephone ?? 'Non renseigné' }}</p>
            <p><strong>Statut :</strong> {{ ucfirst($adherent->statut) }}</p>
            <p><strong>Date certificat médical :</strong>
               {{ $adherent->date_certificat 
                    ? $adherent->date_certificat->format('d/m/Y')
                    : 'Non renseignée' }}
            </p>
            <p><strong>Archivage :</strong> 
               {{ $adherent->est_archive ? 'Oui' : 'Non' }}
            </p>

            {{-- Actions : Éditer / Archiver --}}
            <div class="mt-6 space-x-4">
                <a href="{{ route('secretaire.adherents.edit', $adherent) }}"
                   class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    Éditer
                </a>

                <form action="{{ route('secretaire.adherents.destroy', $adherent) }}"
                      method="POST"
                      class="inline"
                      onsubmit="return confirm('Archiver cet adhérent ?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                        Archiver
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
