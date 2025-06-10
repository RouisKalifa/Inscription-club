<x-app-layout>
    <div class="container mx-auto p-4 max-w-xl">
        <h1 class="text-2xl font-bold mb-4">Modifier l’adhérent</h1>

        @php
            // Fonction utilitaire pour déchiffrer et formater en Y-m-d
            function decryptDate(?string $raw): ?string {
                if (!$raw) {
                    return null;
                }
                try {
                    $decrypted = \Illuminate\Support\Facades\Crypt::decryptString($raw);
                } catch (\Throwable $e) {
                    $decrypted = $raw;
                }
                try {
                    return \Illuminate\Support\Carbon::parse($decrypted)->format('Y-m-d');
                } catch (\Throwable $e) {
                    return null;
                }
            }

            $dateNaissanceEdit   = decryptDate($adherent->date_naissance);
            $dateCertificatEdit  = decryptDate($adherent->date_certificat);
            $dateCotisationEdit  = decryptDate($adherent->date_cotisation);
        @endphp

        <form action="{{ route('secretaire.adherents.update', $adherent) }}" 
              method="POST" 
              enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Prénom -->
            <div class="mb-4">
                <label for="prenom" class="block text-sm font-medium text-gray-700">Prénom</label>
                <input type="text"
                       name="prenom"
                       id="prenom"
                       value="{{ old('prenom', $adherent->prenom) }}"
                       required
                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200 focus:border-indigo-500" />
                @error('prenom')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Nom -->
            <div class="mb-4">
                <label for="nom" class="block text-sm font-medium text-gray-700">Nom</label>
                <input type="text"
                       name="nom"
                       id="nom"
                       value="{{ old('nom', $adherent->nom) }}"
                       required
                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200 focus:border-indigo-500" />
                @error('nom')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Date de naissance -->
            <div class="mb-4">
                <label for="date_naissance" class="block text-sm font-medium text-gray-700">Date de naissance</label>
                <input type="date"
                       name="date_naissance"
                       id="date_naissance"
                       value="{{ old('date_naissance', $dateNaissanceEdit) }}"
                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200 focus:border-indigo-500" />
                @error('date_naissance')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Adresse -->
            <div class="mb-4">
                <label for="adresse" class="block text-sm font-medium text-gray-700">Adresse</label>
                <input type="text"
                       name="adresse"
                       id="adresse"
                       value="{{ old('adresse', $adherent->adresse) }}"
                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200 focus:border-indigo-500" />
                @error('adresse')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Ville -->
            <div class="mb-4">
                <label for="ville" class="block text-sm font-medium text-gray-700">Ville</label>
                <input type="text"
                       name="ville"
                       id="ville"
                       value="{{ old('ville', $adherent->ville) }}"
                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200 focus:border-indigo-500" />
                @error('ville')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Code postal -->
            <div class="mb-4">
                <label for="code_postal" class="block text-sm font-medium text-gray-700">Code postal</label>
                <input type="text"
                       name="code_postal"
                       id="code_postal"
                       value="{{ old('code_postal', $adherent->code_postal) }}"
                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200 focus:border-indigo-500" />
                @error('code_postal')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Téléphone -->
            <div class="mb-4">
                <label for="telephone" class="block text-sm font-medium text-gray-700">Téléphone</label>
                <input type="text"
                       name="telephone"
                       id="telephone"
                       value="{{ old('telephone', $adherent->telephone) }}"
                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200 focus:border-indigo-500" />
                @error('telephone')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Statut -->
            <div class="mb-4">
                <label for="statut" class="block text-sm font-medium text-gray-700">Statut</label>
                <select name="statut"
                        id="statut"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200 focus:border-indigo-500">
                    <option value="adhérent" {{ old('statut', $adherent->statut) === 'adhérent' ? 'selected' : '' }}>Adhérent</option>
                    <option value="coach" {{ old('statut', $adherent->statut) === 'coach' ? 'selected' : '' }}>Coach</option>
                    <option value="président" {{ old('statut', $adherent->statut) === 'président' ? 'selected' : '' }}>Président</option>
                </select>
                @error('statut')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Photo (trombinoscope) -->
            <div class="mb-4">
                <label for="photo_path" class="block text-sm font-medium text-gray-700">Photo (facultatif)</label>
                @if($adherent->photo_path)
                    <div class="mb-2">
                        <img src="{{ asset('storage/' . $adherent->photo_path) }}"
                             alt="Photo actuelle de {{ $adherent->prenom }} {{ $adherent->nom }}"
                             class="w-20 h-20 object-cover rounded-full border" />
                    </div>
                @endif
                <input type="file"
                       name="photo_path"
                       id="photo_path"
                       accept="image/*"
                       class="mt-1 block w-full text-sm text-gray-600" />
                @error('photo_path')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Date du certificat médical -->
            <div class="mb-4">
                <label for="date_certificat" class="block text-sm font-medium text-gray-700">Date du certificat médical</label>
                <input type="date"
                       name="date_certificat"
                       id="date_certificat"
                       value="{{ old('date_certificat', $dateCertificatEdit) }}"
                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200 focus:border-indigo-500" />
                @error('date_certificat')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Date de cotisation -->
            <div class="mb-4">
                <label for="date_cotisation" class="block text-sm font-medium text-gray-700">
                    Date de cotisation
                </label>
                <input type="date"
                       name="date_cotisation"
                       id="date_cotisation"
                       value="{{ old('date_cotisation', $dateCotisationEdit) }}"
                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200 focus:border-indigo-500" />
            </div>

            <!-- Boutons -->
            <div class="mt-6 space-x-4">
                <button type="submit"
                        class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    Mettre à jour
                </button>
                <a href="{{ route('secretaire.adherents.index') }}"
                   class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400">
                    Annuler
                </a>
            </div>
        </form>
    </div>
</x-app-layout>
