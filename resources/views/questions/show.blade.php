@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title">
                            <div class="d-flex align-items-center">
                                <h1>{{ $question->title }}</h1>
                                <div class="ml-auto">
                                    <a href="{{ route('question.index') }}" class="btn btn-outline-secondary">Back to all questions</a>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="media">

                            <div class="d-flex flex-column vote-controls">
                                <a href="" title="This $name is useful" class="vote-up {{ Auth::guest() ? 'off' : '' }}"
                                   onclick="event.preventDefault(); document.getElementById('up-vote-question-{{ $question->id }}').submit()">
                                    <i class="fas fa-caret-up fa-3x"></i>
                                </a>
                                <form action="/questions/{{ $question->slug }}/vote" method="post" id="up-vote-question-{{ $question->id }}" style="display: none;">
                                    @csrf
                                    <input type="hidden" name="vote" value="1">
                                </form>


                                <span class="votes-count">
                                        {{ $question->votes_count }}
                                </span>

                                <a href="" title="This $name is not useful" class="vote-down {{ Auth::guest() ? 'off' : '' }}"
                                   onclick="event.preventDefault(); document.getElementById('down-vote-question-{{ $question->id }}').submit()">
                                    <i class="fas fa-caret-down fa-3x"></i>
                                </a>
                                <form action="/questions/{{ $question->slug }}/vote" method="post" id="down-vote-question-{{ $question->id }}" style="display: none;">
                                    @csrf
                                    <input type="hidden" name="vote" value="-1">
                                </form>
                            </div>
                            <div class="media-body">
                                {{ $question->body }}
                                <div class="row">
                                    <div class="col-4"></div>
                                    <div class="col-4"></div>
                                    <div class="col-4">
                                        <div>
                                            <span class="text-muted">
                                                {{ $question->created_date }}
                                            </span>
                                            <div class="media mt-2">
                                                <a href="{{ route('profile.show', $question->user->id) }}" class="pr-2"><img style="width: 250px; height: 250px" src="{{ $question->user->avatar }}" alt=""></a>
                                                <div class="media-body mt-1">
                                                    <a href="{{ route('profile.show', $question->user->id) }}">{{ $question->user->username }}</a>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if($question->answers->count() > 0)
            <div class="row mt-4">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title">
                                <h2>{{ $question->answers->count()." ".Str::plural('Answer',$question->answers->count()) }}</h2>
                            </div>
                            <hr>

                            @foreach ($question->answers as $answer)

                                <div class="media post">
                                    <div class="d-flex flex-column vote-controls">
                                        <a href="" title="This $name is useful" class="vote-up {{ Auth::guest() ? 'off' : '' }}"
                                           onclick="event.preventDefault(); document.getElementById('up-vote-answer-{{ $answer->id }}').submit()">
                                            <i class="fas fa-caret-up fa-3x"></i>
                                        </a>
                                        <form action="/answers/{{ $answer->id }}/vote" method="post" id="up-vote-answer-{{ $answer->id }}" style="display: none;">
                                            @csrf
                                            <input type="hidden" name="vote" value="1">
                                        </form>


                                        <span class="votes-count">
                                        {{ $answer->votes_count }}
                                </span>

                                        <a href="" title="This $name is not useful" class="vote-down {{ Auth::guest() ? 'off' : '' }}"
                                           onclick="event.preventDefault(); document.getElementById('down-vote-answer-{{ $answer->id }}').submit()">
                                            <i class="fas fa-caret-down fa-3x"></i>
                                        </a>
                                        <form action="/answers/{{ $answer->id }}/vote" method="post" id="down-vote-answer-{{ $answer->id }}" style="display: none;">
                                            @csrf
                                            <input type="hidden" name="vote" value="-1">
                                        </form>

                                    </div>

                                    <div class="media-body">
                                        {!! $answer->body !!}
                                        <div class="row">
                                            <div class="col-4">
                                                <div class="ml-auto">
                                                    @can('update', $answer)
                                                        <a href="{{ route('question.answers.edit', [$question->slug,$answer->id]) }}" class="btn btn-sm btn-outline-info">Edit</a>
                                                    @endcan
                                                    @can('delete', $answer)
                                                        <form class="form-delete" action="{{ route('answers.destroy', [$answer->id]) }}" method="POST">
                                                            @method('DELETE')
                                                            @csrf
                                                            <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                                                        </form>
                                                    @endcan
                                                </div>
                                            </div>
                                            <div class="col-4"></div>
                                            <div class="col-4">

                                                <div>
                                            <span class="text-muted">
                                                {{ $answer->created_date }}
                                            </span>
                                                    <div class="media mt-2">
                                                        <a href="{{ route('profile.show', $answer->user->id) }}" class="pr-2"><img style="width: 250px; height: 250px" src="{{ $answer->user->avatar }}" alt=""></a>
                                                        <div class="media-body mt-1">
                                                            <a href="{{ route('profile.show', $answer->user->id) }}">{{ $answer->user->username }}</a>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                    </div>
                                </div>

                            @endforeach

                        </div>
                    </div>
                </div>
            </div>
        @endif
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title">
                            <h3>Your Answer</h3>
                        </div>
                        <hr>
                        @auth
                        <form action="{{ route('question.answers.store', $question->slug) }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <textarea name="body" id="" cols="30" rows="7" class="form-control {{ $errors->has('body')?'is-invalid':'' }}"></textarea>
                                @if($errors->has('body'))
                                    <div class="invalid-feedback">
                                        <strong>{{ $errors->first('body') }}</strong>
                                    </div>
                                @endif

                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-lg btn-outline-primary">Submit</button>
                            </div>
                        </form>
                        @endauth
                        @guest
                            <div class="alert alert-warning">
                                To send a answer you need <a href="{{ route('login') }}">Login</a>
                            </div>
                        @endguest
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
