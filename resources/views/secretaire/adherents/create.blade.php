<x-app-layout>
    <div class="container mx-auto p-4 max-w-2xl">
        <h1 class="text-2xl font-bold mb-6">Créer un nouvel adhérent</h1>

        {{-- Affichage des erreurs de validation --}}
        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('secretaire.adherents.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- 1) Création du compte utilisateur (rôle = "nageur") --}}
            <div class="mb-6">
                <h2 class="text-lg font-semibold mb-2">Informations du compte Nageur</h2>

                {{-- Email du nageur --}}
                <div class="mb-4">
                    <label for="email_user" class="block text-sm font-medium text-gray-700">Email du nageur</label>
                    <input type="email"
                           name="email_user"
                           id="email_user"
                           value="{{ old('email_user') }}"
                           required
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-200 focus:border-indigo-500" />
                </div>

                {{-- Mot de passe --}}
                <div class="mb-4">
                    <label for="password_user" class="block text-sm font-medium text-gray-700">Mot de passe</label>
                    <input type="password"
                           name="password_user"
                           id="password_user"
                           required
                           onpaste="return false;"
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-200 focus:border-indigo-500" />
                </div>

                {{-- Confirmation du mot de passe --}}
                <div class="mb-4">
                    <label for="password_user_confirmation" class="block text-sm font-medium text-gray-700">
                        Confirmation mot de passe
                    </label>
                    <input type="password"
                           name="password_user_confirmation"
                           id="password_user_confirmation"
                           required
                           onpaste="return false;"
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-200 focus:border-indigo-500" />
                </div>
            </div>

            <hr class="my-6">

            {{-- 2) Fiche Adhérent --}}
            <div class="mb-6">
                <h2 class="text-lg font-semibold mb-2">Informations personnelles de l’adhérent</h2>

                {{-- Prénom --}}
                <div class="mb-4">
                    <label for="prenom" class="block text-sm font-medium text-gray-700">Prénom</label>
                    <input type="text"
                           name="prenom"
                           id="prenom"
                           value="{{ old('prenom') }}"
                           required
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-200 focus:border-indigo-500" />
                </div>

                {{-- Nom --}}
                <div class="mb-4">
                    <label for="nom" class="block text-sm font-medium text-gray-700">Nom</label>
                    <input type="text"
                           name="nom"
                           id="nom"
                           value="{{ old('nom') }}"
                           required
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-200 focus:border-indigo-500" />
                </div>

                {{-- Date de naissance --}}
                <div class="mb-4">
                    <label for="date_naissance" class="block text-sm font-medium text-gray-700">Date de naissance</label>
                    <input type="date"
                           name="date_naissance"
                           id="date_naissance"
                           value="{{ old('date_naissance') }}"
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-200 focus:border-indigo-500" />
                </div>

                {{-- Adresse --}}
                <div class="mb-4">
                    <label for="adresse" class="block text-sm font-medium text-gray-700">Adresse</label>
                    <input type="text"
                           name="adresse"
                           id="adresse"
                           value="{{ old('adresse') }}"
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-200 focus:border-indigo-500" />
                </div>

                {{-- Ville --}}
                <div class="mb-4">
                    <label for="ville" class="block text-sm font-medium text-gray-700">Ville</label>
                    <input type="text"
                           name="ville"
                           id="ville"
                           value="{{ old('ville') }}"
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-200 focus:border-indigo-500" />
                </div>

                {{-- Code postal --}}
                <div class="mb-4">
                    <label for="code_postal" class="block text-sm font-medium text-gray-700">Code postal</label>
                    <input type="text"
                           name="code_postal"
                           id="code_postal"
                           value="{{ old('code_postal') }}"
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-200 focus:border-indigo-500" />
                </div>

                {{-- Téléphone --}}
                <div class="mb-4">
                    <label for="telephone" class="block text-sm font-medium text-gray-700">Téléphone</label>
                    <input type="text"
                           name="telephone"
                           id="telephone"
                           value="{{ old('telephone') }}"
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-200 focus:border-indigo-500" />
                </div>

                {{-- Statut --}}
                <div class="mb-4">
                    <label for="statut" class="block text-sm font-medium text-gray-700">Statut</label>
                    <select name="statut"
                            id="statut"
                            required
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-200 focus:border-indigo-500">
                        <option value="adhérent" {{ old('statut') === 'adhérent' ? 'selected' : '' }}>Adhérent</option>
                        <option value="coach"     {{ old('statut') === 'coach'     ? 'selected' : '' }}>Coach</option>
                        <option value="président" {{ old('statut') === 'président' ? 'selected' : '' }}>Président</option>
                    </select>
                </div>

                {{-- Photo du trombinoscope --}}
                <div class="mb-4">
                    <label for="photo_path" class="block text-sm font-medium text-gray-700">Photo (trombinoscope)</label>
                    <input type="file"
                           name="photo_path"
                           id="photo_path"
                           accept="image/*"
                           class="mt-1 block w-full text-sm text-gray-600" />
                </div>

                {{-- Date du certificat médical --}}
                <div class="mb-4">
                    <label for="date_certificat" class="block text-sm font-medium text-gray-700">Date du certificat médical</label>
                    <input type="date"
                           name="date_certificat"
                           id="date_certificat"
                           value="{{ old('date_certificat') }}"
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-200 focus:border-indigo-500" />
                </div>

                <div class="mb-4">
  <label for="date_cotisation" class="block text-sm font-medium text-gray-700">
    Date de cotisation
  </label>
  <input type="date"
         name="date_cotisation"
         id="date_cotisation"
         value="{{ old('date_cotisation', $adherent->date_cotisation ?? '') }}"
         class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
  />
</div>


            </div>

            <div class="mb-4">
  <label class="flex items-center space-x-2">
    <input type="checkbox"
           name="consentement_rgpd"
           value="1"
           required
           class="mt-1" />
    <span>
      J’accepte que mes données personnelles soient collectées et traitées.
    </span>
  </label>
  @error('consentement_rgpd')
    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
  @enderror
</div>



            {{-- Bouton de soumission --}}
            <div class="mt-6">
                <button type="submit"
                        class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                    {{ __('Enregistrer l’adhérent') }}
                </button>

                <a href="{{ route('secretaire.adherents.index') }}"
                   class="ml-4 px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400">
                    {{ __('Annuler') }}
                </a>
            </div>
        </form>
    </div>
</x-app-layout>
