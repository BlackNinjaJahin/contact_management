<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    // Show all contacts
    public function index(Request $request)
    {
        $query = Contact::query();

        // Search functionality
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('name', 'like', "%$search%")
                  ->orWhere('email', 'like', "%$search%");
        }

        // Sorting functionality
        if ($request->has('sort')) {
            $sort = $request->input('sort');
            $query->orderBy($sort, 'asc');
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $contacts = $query->paginate(10); // Adjust pagination as needed

        return view('contacts.index', compact('contacts'));
    }

    // Show the form to create a new contact
    public function create()
    {
        return view('contacts.create');
    }

    // Store a new contact
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:contacts',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
        ]);

        Contact::create($validatedData);

        return redirect()->route('contacts.index')->with('success', 'Contact created successfully.');
    }

    // Show a specific contact
    public function show($id)
    {
        $contact = Contact::findOrFail($id);

        return view('contacts.show', compact('contact'));
    }

    // Show the form to edit a contact
    public function edit($id)
    {
        $contact = Contact::findOrFail($id);

        return view('contacts.edit', compact('contact'));
    }

    // Update a contact
    public function update(Request $request, $id)
    {
        $contact = Contact::findOrFail($id);

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:contacts,email,' . $contact->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
        ]);

        $contact->update($validatedData);

        return redirect()->route('contacts.index')->with('success', 'Contact updated successfully.');
    }

    // Delete a contact
    public function destroy($id)
    {
        $contact = Contact::findOrFail($id);
        $contact->delete();

        return redirect()->route('contacts.index')->with('success', 'Contact deleted successfully.');
    }
}
