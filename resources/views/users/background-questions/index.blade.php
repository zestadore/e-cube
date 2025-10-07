@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Background Questions</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        @php
                            // Decode saved answers (if exist)
                            $savedAnswers = $answers ? (is_array($answers->answers) ? $answers->answers : json_decode($answers->answers, true)) : [];
                        @endphp
                        <form action="{{ route('employee.save-background-question') }}" method="POST">@csrf
                            @foreach ($questions as $question)
                                @php
                                    $selectedAnswer = $savedAnswers[$question->id] ?? null;
                                @endphp
                                <div class="form-group">
                                    <label for="question-{{ $question->id }}">{{ $question->question }}</label>
                                    <select name="answers[{{ $question->id }}]" id="answers[{{ $question->id }}]" class="form-control form-select {{ $errors->has('answers.' . $question->id) ? ' is-invalid' : '' }}">
                                        <option value="Yes" {{ $selectedAnswer === 'Yes' ? 'selected' : '' }}>Yes</option>
                                        <option value="No" {{ $selectedAnswer === 'No' ? 'selected' : '' }}>No</option>
                                    </select>
                                </div>
                            @endforeach
                            <button type="submit" class="btn btn-primary" style="float: right;">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection