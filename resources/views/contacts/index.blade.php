@extends('layout')

@section('content')
    <a href="{{ route('contacts.create') }}" class="btn btn-primary mb-3">Add Contact</a>

    @if($contacts->count())
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Name</th><th>Email</th><th>Phone</th><th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($contacts as $contact)
                    <tr>
                        <td>{{ $contact->name }}</td>
                        <td>{{ $contact->email }}</td>
                        <td>{{ $contact->phone }}</td>
                        <td>
                            <a href="{{ route('contacts.edit', $contact) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('contacts.destroy', $contact) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this contact?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No contacts found.</p>
    @endif
@endsection
