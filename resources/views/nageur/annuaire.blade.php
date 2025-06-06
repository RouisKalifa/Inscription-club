<x-app-layout>
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Annuaire des nageurs</h1>

        @if($annuaire->isEmpty())
            <p>Aucun nageur n'apparait dans l'annuaire pour le moment.</p>
        @else
            <table class="min-w-full bg-white border">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="px-4 py-2 border">Nom</th>
                        <th class="px-4 py-2 border">Prénom</th>
                        <th class="px-4 py-2 border">Ville</th>
                        <th class="px-4 py-2 border">Téléphone</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($annuaire as $adh)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-2 border">{{ $adh->nom }}</td>
                            <td class="px-4 py-2 border">{{ $adh->prenom }}</td>
                            <td class="px-4 py-2 border">{{ $adh->ville ?? '—' }}</td>
                            <td class="px-4 py-2 border">{{ $adh->telephone ?? '—' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</x-app-layout>
