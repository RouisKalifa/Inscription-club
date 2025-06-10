<x-app-layout>
    <div class="container mx-auto p-4 max-w-xl">
        <h1 class="text-2xl font-bold mb-4">Mon Profil</h1>

        @if(session('success'))
            <div class="mb-4 p-2 bg-green-100 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif

        @php
            // Helper pour déchiffrer et formater les dates
            function decryptDateValue(?string $raw): ?string {
                if (!$raw) return null;
                try {
                    $val = \Illuminate\Support\Facades\Crypt::decryptString($raw);
                } catch (\Throwable $e) {
                    $val = $raw;
                }
                try {
                    return \Illuminate\Support\Carbon::parse($val)->format('Y-m-d');
                } catch (\Throwable $e) {
                    return null;
                }
            }

            $dateNaissanceValue = decryptDateValue($adherent->date_naissance);
            $dateCertificatValue = decryptDateValue($adherent->date_certificat);
        @endphp

        <form action="{{ route('nageur.profil.update') }}" method="POST" enctype="multipart/form-data">
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
                       value="{{ old('date_naissance', $dateNaissanceValue) }}"
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

            <!-- Photo (trombinoscope) -->
            <div class="mb-4">
                <label for="photo_path" class="block text-sm font-medium text-gray-700">Photo (trombinoscope)</label>
                @if($adherent->photo_path)
                    <div class="mb-2">
                        <img src="{{ asset('storage/' . $adherent->photo_path) }}"
                             alt="Photo de {{ $adherent->prenom }} {{ $adherent->nom }}"
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
                       value="{{ old('date_certificat', $dateCertificatValue) }}"
                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200 focus:border-indigo-500" />
                @error('date_certificat')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Visibilité trombinoscope -->
            <div class="mb-4 flex items-center">
                <input type="checkbox"
                       name="visible_trombinoscope"
                       id="visible_trombinoscope"
                       value="1"
                       {{ old('visible_trombinoscope', $adherent->visible_trombinoscope) ? 'checked' : '' }}
                       class="mr-2" />
                <label for="visible_trombinoscope" class="text-sm text-gray-700">
                    Je veux apparaître dans le trombinoscope
                </label>
            </div>

            <!-- Visibilité annuaire -->
            <div class="mb-4 flex items-center">
                <input type="checkbox"
                       name="visible_annuaire"
                       id="visible_annuaire"
                       value="1"
                       {{ old('visible_annuaire', $adherent->visible_annuaire) ? 'checked' : '' }}
                       class="mr-2" />
                <label for="visible_annuaire" class="text-sm text-gray-700">
                    Je veux apparaître dans l'annuaire
                </label>
            </div>

            <!-- Boutons -->
            <div class="mt-6 space-x-4">
                <button type="submit"
                        class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    Enregistrer
                </button>
                <a href="{{ route('nageur.espace') }}"
                   class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400">
                    Annuler
                </a>
            </div>
        </form>
    </div>
</x-app-layout>
