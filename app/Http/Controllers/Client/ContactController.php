<?php

declare(strict_types=1);

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreContactRequest;
use App\Models\Contact;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

final class ContactController extends Controller
{
    public function index(): View
    {
        $contacts = Contact::query()
            ->whereBelongsTo(auth()->user())
            ->orderBy('given_name')
            ->orderBy('family_name')
            ->get();

        return view('client.contacts.index')
            ->with('contacts', $contacts);
    }

    public function edit(Contact $contact): View
    {
        abort_unless($contact->user_id === auth()->id(), 404);

        return view('client.contacts.edit')
            ->with('contact', $contact);
    }

    public function delete(Contact $contact): View
    {
        abort_unless($contact->user_id === auth()->id(), 404);

        return view('client.contacts.delete')
            ->with('contact', $contact);
    }

    public function store(StoreContactRequest $request): RedirectResponse
    {
        Contact::create($request->validated() + [
            'user_id' => auth()->id(),
        ]);

        return redirect()
            ->route('contacts.index')
            ->with('status', 'Contact created.');
    }

    public function update(StoreContactRequest $request, Contact $contact): RedirectResponse
    {
        abort_unless($contact->user_id === auth()->id(), 404);

        $contact->update($request->validated());

        return redirect()
            ->route('contacts.index')
            ->with('status', 'Contact updated.');
    }

    public function destroy(Request $request, Contact $contact): RedirectResponse
    {
        abort_unless($contact->user_id === auth()->id(), 404);

        $contact->delete();

        return redirect()
            ->route('contacts.index')
            ->with('status', 'Contact deleted.');
    }
}
