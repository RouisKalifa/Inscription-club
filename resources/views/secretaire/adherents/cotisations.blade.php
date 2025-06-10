<x-app-layout>
  <div class="container mx-auto p-4">
    <div class="flex justify-between items-center mb-4">
      <h1 class="text-2xl font-bold">Cotisations des adhérents</h1>
      <a href="{{ route('secretaire.adherents.index') }}"
         class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400">
        ← Liste des adhérents
      </a>
    </div>

    @if($adherents->isEmpty())
      <p>Aucun adhérent actif pour l’instant.</p>
    @else
      <table class="min-w-full bg-white border">
        <thead>
          <tr class="bg-gray-100">
            <th class="px-4 py-2 border">ID</th>
            <th class="px-4 py-2 border">Nom</th>
            <th class="px-4 py-2 border">Prénom</th>
            <th class="px-4 py-2 border">Date de cotisation</th>
          </tr>
        </thead>
        <tbody>
          @foreach($adherents as $adh)
            <tr class="hover:bg-gray-50">
              <td class="px-4 py-2 border">{{ $adh->id }}</td>
              <td class="px-4 py-2 border">{{ $adh->nom }}</td>
              <td class="px-4 py-2 border">{{ $adh->prenom }}</td>
              <td class="px-4 py-2 border">
                @php
                  // Récupération brute
                  $raw = $adh->date_cotisation;
                  
                  // Tentative de déchiffrement, sinon on garde la valeur brute
                  try {
                      $decrypted = \Illuminate\Support\Facades\Crypt::decryptString($raw);
                  } catch (\Throwable $e) {
                      $decrypted = $raw;
                  }

                  // Format si date non vide
                  $formatted = $decrypted
                      ? \Illuminate\Support\Carbon::parse($decrypted)->format('d/m/Y')
                      : null;
                @endphp

                {{ $formatted ?? 'Non renseignée' }}
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    @endif
  </div>
</x-app-layout>
