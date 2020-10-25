@extends('layouts/app')

@section('content')
    <div class="container">
        <h1>{{ $question->title }}</h1>
        <p class="lead">
            {{ $question->description }}
        </p>
        <p>
            Submitted By: {{ $question->user->name }},   {{ $question->created_at->diffForHumans() }}
        </p>
        @if ($question->user->id == Auth::id())
            <a href="{{ route('questions.edit', $question->id) }}" class="btn btn-primary" >Edit</a>

            <form action="{{ route('questions.destroy',$question->id) }}" method="POST" style="display: inline">
                {{ csrf_field() }}
                {{ method_field("DELETE") }}
                <button class="btn btn-danger" type="submit" >
                    Delete
                </button>
            </form>
        @endif
        <hr />

        {{--        <!-- display all of the answers for this question -->--}}
        @if ($question->answers->count() > 0)
            @foreach ($question->answers as $answer)
                <div class="card" style="@if (@isset($style)){{ $style }} @endif">
                    <div class="card-header">
                        Answer
                    </div>
                    <div class="card-body">
                        <p class="card-text">{{ $answer->ans }}</p>
                    </div>
                    <div class="card-footer text-muted">
                        Answered By: {{ $answer->user->name }},  {{ $answer->created_at->diffForHumans() }}
                        @if ($answer->user->id == Auth::id() || $question->user->id == Auth::id())
                            <a href="{{ route('answers.edit', $answer->id) }}" class="btn btn-primary float-right" id="editbtn">Edit</a>
                            <form action="{{ route('answers.destroy',$answer->id) }}" method="POST" style="display: inline">
                                {{ csrf_field() }}
                                {{ method_field("DELETE") }}
                                <button class="btn btn-danger float-right" type="submit" >
                                    Delete
                                </button>
                            </form>
                        @endif
                    </div>
                </div><br>

            @endforeach
        @else
            <div class="card">
                <div class="card-body">
                    <p>
                        There are no answers for this question yet. Please consider submitting one below!
                    </p>
                </div>
            </div>
            <br>
        @endif

        @if (Auth::id())

            <!-- display the form, to submit a new answer -->

            <form action="{{ route('answers.update',$answer->id) }}" method="POST">
                {{ csrf_field() }}
                {{ method_field("PUT") }}
                <h4>Update Your Own Answer:</h4>
                <textarea class="form-control" name="ans" rows="4">{{ $answer->ans }}</textarea>
                <input type="hidden" value="{{ $question->id }}" name="question_id" />
                <br>
                <button class="btn btn-primary">Update Answer</button>
            </form>

        @else

            <div class="alert alert-info">
                If you provide any answer, Please login first.

            </div>

        @endif

    </div>

@endsection


