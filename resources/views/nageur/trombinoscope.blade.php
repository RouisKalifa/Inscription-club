<x-app-layout>
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Trombinoscope des nageurs</h1>

        @if($trombinos->isEmpty())
            <p>Aucun nageur n'apparaît dans le trombinoscope pour le moment.</p>
        @else
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($trombinos as $adh)
                    <div class="bg-white shadow rounded p-4 flex flex-col items-center">
                        @if($adh->photo_path)
                            <img src="{{ asset('storage/' . $adh->photo_path) }}"
                                 alt="Photo de {{ $adh->prenom }} {{ $adh->nom }}"
                                 class="w-24 h-24 object-cover rounded-full mb-2" />
                        @else
                            <div class="w-24 h-24 bg-gray-200 rounded-full mb-2 flex items-center justify-center">
                                <span class="text-gray-500">Pas de photo</span>
                            </div>
                        @endif
                        <p class="font-semibold">{{ $adh->prenom }} {{ $adh->nom }}</p>
                        <p class="text-sm text-gray-600">{{ ucfirst($adh->statut) }}</p>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</x-app-layout>
