@extends('layout')

@section('content')
    <h2>Edit Contact</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>@foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach</ul>
        </div>
    @endif

    <form method="POST" action="{{ route('contacts.update', $contact) }}">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label>Name</label>
            <input name="name" value="{{ old('name', $contact->name) }}" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Email</label>
            <input name="email" value="{{ old('email', $contact->email) }}" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Phone</label>
            <input name="phone" value="{{ old('phone', $contact->phone) }}" class="form-control" required>
        </div>
        <button class="btn btn-primary">Update</button>
        <a href="{{ route('contacts.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
@endsection
