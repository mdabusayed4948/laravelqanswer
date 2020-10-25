@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Contact Us</h1>
        <hr />
        <form action="{{ route('contact') }}" method="POST">
            {{ csrf_field() }}

            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" name="name" id="name" class="form-control" />
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" name="email" id="email" class="form-control" />
            </div>
            <div class="form-group">
                <label for="subject">Subject:</label>
                <input type="text" name="subject" id="subject" class="form-control" />
            </div>
            <div class="form-group">
                <label for="message">Message:</label>
                <textarea class="form-control" name="message" id="message" rows="5"></textarea>
            </div>

            <br>
            <input type="submit" class="btn btn-primary" value="Send Email" />
        </form>
    </div>
@endsection
