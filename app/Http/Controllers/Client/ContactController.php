<?php

declare(strict_types=1);

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreContactRequest;
use App\Models\Contact;
use Illuminate\Http\RedirectResponse;
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

    public function store(StoreContactRequest $request): RedirectResponse
    {
        Contact::create($request->validated() + [
            'user_id' => auth()->id(),
        ]);

        return redirect()
            ->route('contacts.index')
            ->with('status', 'Contact created.');
    }
}
