@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="my-4">Contacts</h1>

    <form action="{{ route('contacts.index') }}" method="GET" class="mb-4">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Search by name or email" value="{{ request('search') }}">
            <button class="btn btn-primary" type="submit">Search</button>
        </div>
    </form>

    <table class="table table-striped table-hover">
        <thead class="table-dark">
            <tr>
                <th><a href="{{ route('contacts.index', ['sort' => 'name']) }}" class="text-light">Name</a></th>
                <th><a href="{{ route('contacts.index', ['sort' => 'email']) }}" class="text-light">Email</a></th>
                <th><a href="{{ route('contacts.index', ['sort' => 'created_at']) }}" class="text-light">Date</a></th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($contacts as $contact)
                <tr>
                    <td>{{ $contact->name }}</td>
                    <td>{{ $contact->email }}</td>
                    <td>{{ $contact->created_at }}</td>
                    <td>
                        <a href="{{ route('contacts.show', $contact->id) }}" class="btn btn-info btn-sm">View</a>
                        <a href="{{ route('contacts.edit', $contact->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('contacts.destroy', $contact->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $contacts->links() }} <!-- This will be styled by Bootstrap pagination -->
</div>
@endsection
