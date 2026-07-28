<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-zinc-800 leading-tight">
            {{ __('Delete Contact') }}
        </h2>
    </x-slot>

    <div class="py-8 max-w-3xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-zinc-900">
                <h3 class="text-lg font-semibold">
                    {{ trim(collect([$contact->title, $contact->given_name, $contact->family_name])->filter()->implode(' ')) }}
                </h3>

                <p class="mt-3 text-sm text-zinc-600">
                    This action will permanently remove the contact.
                </p>

                <form method="POST" action="{{ route('contacts.destroy', $contact) }}" class="mt-6 flex items-center gap-4">
                    @csrf
                    @method('DELETE')

                    <x-primary-button class="bg-red-700 hover:bg-red-600 focus:bg-red-600 active:bg-red-800">
                        Delete Contact
                    </x-primary-button>

                    <a href="{{ route('contacts.index') }}" class="text-sm text-zinc-600 hover:text-zinc-900">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
