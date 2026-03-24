@extends('layouts.app')

@section('title', 'ប្រភេទ')

@section('content')
<div class="container">
    <h1>បញ្ជីប្រភេទ</h1>
    <ul>
        @foreach($categories as $category)
            <li>
                <a href="{{ route('category.show', $category->id) }}">{{ $category->name }}</a>
            </li>
        @endforeach
    </ul>
</div>
@endsection
