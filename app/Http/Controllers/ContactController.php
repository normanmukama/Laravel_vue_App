<?php
namespace App\Http\Controllers;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:contacts,email',
            'contact' => 'required|string|max:15',
        ]);

        $contact = Contact::create($validatedData);

        return response()->json(['message' => 'Contact saved successfully', 'contact' => $contact], 201);
    }

    // public function index()
    // {
    //     Fetch data using the singleton registered in DataServiceProvider
    //     $contacts = app('app.data')['contacts'];
    //     return response()->json($contacts);
    // }

    public function index()
    {
        $contacts = Contact::all(); // Fetch all contacts from the database
        return response()->json($contacts); // Return data as JSON
    }

    public function update(Request $request, $id)
    {
        // Validate incoming request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'contact' => 'required|string|max:20', // Adjust validation rules as needed
        ]);

        // Find the contact by ID
        $contact = Contact::find($id);

        if (!$contact) {
            return response()->json(['message' => 'Contact not found'], 404);
        }

        // Update contact data
        $contact->name = $validatedData['name'];
        $contact->email = $validatedData['email'];
        $contact->contact = $validatedData['contact'];
        $contact->save();

        // Return updated contact
        return response()->json($contact);
    }
}

