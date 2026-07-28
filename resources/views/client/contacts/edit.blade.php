<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-zinc-800 leading-tight">
            {{ __('Edit Contact') }}
        </h2>
    </x-slot>

    <div class="py-8 max-w-3xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-zinc-900">
                <form method="POST" action="{{ route('contacts.update', $contact) }}" class="grid grid-cols-1 gap-4 md:grid-cols-2">
                    @csrf
                    @method('PATCH')

                    <div>
                        <x-input-label for="title" value="Title" />
                        <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" :value="old('title', $contact->title)" />
                        <x-input-error :messages="$errors->get('title')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="given_name" value="Given name" />
                        <x-text-input id="given_name" name="given_name" type="text" class="mt-1 block w-full" :value="old('given_name', $contact->given_name)" required />
                        <x-input-error :messages="$errors->get('given_name')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="family_name" value="Family name" />
                        <x-text-input id="family_name" name="family_name" type="text" class="mt-1 block w-full" :value="old('family_name', $contact->family_name)" />
                        <x-input-error :messages="$errors->get('family_name')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="nick_name" value="Nickname" />
                        <x-text-input id="nick_name" name="nick_name" type="text" class="mt-1 block w-full" :value="old('nick_name', $contact->nick_name)" />
                        <x-input-error :messages="$errors->get('nick_name')" class="mt-2" />
                    </div>

                    <div class="md:col-span-2">
                        <x-input-label for="email" value="Email" />
                        <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $contact->email)" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div class="md:col-span-2 flex items-center gap-4">
                        <x-primary-button>Save Changes</x-primary-button>
                        <a href="{{ route('contacts.index') }}" class="text-sm text-zinc-600 hover:text-zinc-900">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
