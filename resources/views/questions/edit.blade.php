@extends('layouts/app')

@section('content')
    <div class="container">
        <h1>Ask a Question</h1>
        <hr />
        <form action="{{ route('questions.update', $question->id) }}" method="POST">
            {{ csrf_field() }}
            {{ method_field("PUT") }}
            <label for="title">Question:</label>
            <input type="text" name="title" id="title" class="form-control" value="{{ $question->title }}"/>

            <label for="description">More Information:</label>
            <textarea class="form-control" name="description" id="description" rows="4">{{ $question->description }}</textarea>
            <br>
            <input type="submit" class="btn btn-primary" value="Update Question" />
        </form>
    </div>
@endsection
