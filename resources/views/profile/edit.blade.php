{{-- resources/views/profile/edit.blade.php --}}
@extends('layouts.admin')

@section('content')
<div class="container">
    <h1 class="mb-4">Edit Profile</h1>
    @include('profile.partials.update-profile-information-form')
</div>
@endsection
