@extends('layout')

@section('content')
    <h2>Add Contact</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>@foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach</ul>
        </div>
    @endif

    <form method="POST" action="{{ route('contacts.store') }}">
        @csrf
        <div class="form-group">
            <label>Name</label>
            <input name="name" value="{{ old('name') }}" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Email</label>
            <input name="email" value="{{ old('email') }}" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Phone</label>
            <input name="phone" value="{{ old('phone') }}" class="form-control" required>
        </div>
        <button class="btn btn-success">Save Contact</button>
        <a href="{{ route('contacts.index') }}" class="btn btn-secondary">Back</a>
    </form>
@endsection

