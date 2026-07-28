<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-zinc-800 leading-tight">
            {{ __('Contacts') }}
        </h2>
    </x-slot>

    <div class="py-8 max-w-7xl mx-auto space-y-6 sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-zinc-900">
                @if (session('status'))
                    <p class="mb-4 rounded-md bg-emerald-50 px-3 py-2 text-sm text-emerald-700">
                        {{ session('status') }}
                    </p>
                @endif

                <form method="POST" action="{{ route('contacts.store') }}" class="grid grid-cols-1 gap-4 md:grid-cols-2">
                    @csrf

                    <div>
                        <x-input-label for="title" value="Title" />
                        <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" :value="old('title')" />
                        <x-input-error :messages="$errors->get('title')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="given_name" value="Given name" />
                        <x-text-input id="given_name" name="given_name" type="text" class="mt-1 block w-full" :value="old('given_name')" required />
                        <x-input-error :messages="$errors->get('given_name')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="family_name" value="Family name" />
                        <x-text-input id="family_name" name="family_name" type="text" class="mt-1 block w-full" :value="old('family_name')" />
                        <x-input-error :messages="$errors->get('family_name')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="nick_name" value="Nickname" />
                        <x-text-input id="nick_name" name="nick_name" type="text" class="mt-1 block w-full" :value="old('nick_name')" />
                        <x-input-error :messages="$errors->get('nick_name')" class="mt-2" />
                    </div>

                    <div class="md:col-span-2">
                        <x-input-label for="email" value="Email" />
                        <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email')" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div class="md:col-span-2">
                        <x-primary-button>Add Contact</x-primary-button>
                    </div>
                </form>
            </div>
        </div>

        <div class="space-y-4">
            @forelse ($contacts as $contact)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-zinc-900">
                        <h3 class="text-lg font-semibold">
                            {{ trim(collect([$contact->title, $contact->given_name, $contact->family_name])->filter()->implode(' ')) }}
                        </h3>

                        @if ($contact->nick_name)
                            <p class="mt-1 text-sm text-zinc-600">Nickname: {{ $contact->nick_name }}</p>
                        @endif

                        @if ($contact->email)
                            <p class="mt-1 text-sm text-zinc-600">Email: {{ $contact->email }}</p>
                        @endif
                    </div>
                </div>
            @empty
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-zinc-500">
                        No contacts added yet.
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</x-app-layout>
