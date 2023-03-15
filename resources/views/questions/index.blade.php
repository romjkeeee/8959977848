@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h2>All Questions</h2>
                            <div class="ml-auto">
                                <a href="{{ route('question.create') }}" class="btn btn-outline-secondary">Ask Question</a>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        @forelse ($questions as $question)
                            <div class="media post">
                                <div class="d-flex flex-column counters">

                                    <div class="status {{ $question->status }}">
                                        <strong>
                                            {{ $question->votes_count ?? 0 }}
                                        </strong>
                                        {{ $question->answers->count() }} answer
                                    </div>
                                    <div class="view">
                                        {{ $question->views }} views
                                    </div>
                                </div>
                                <div class="media-body">
                                    <div class="d-flex align-items-center">
                                        <h3 class="mt-0"><a href="question/{{ $question->slug }}">{{ $question->title }}</a></h3>
                                        <div class="ml-auto">
                                            @can('update-question', $question)
                                                <a href="{{ route('question.edit', $question->slug) }}" class="btn btn-sm btn-outline-info">Edit</a>
                                            @endcan
                                            @can('delete-question', $question)
                                                <form class="form-delete" action="{{ route('question.destroy', $question->slug) }}" method="POST">
                                                    @method('DELETE')
                                                    @csrf
                                                    <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                                                </form>
                                            @endcan
                                        </div>
                                    </div>
                                    <p class="lead">
                                        Asked by <a href="{{ route('profile.show', $question->user->id) }}">{{ $question->user->name }}</a>
                                        <small class="text-muted">{{ $question->created_date }}</small>
                                    </p>
                                    <div class="excerpt">{{ $question->excerpt }}</div>
                                </div>
                            </div>
                        @empty
                            <div class="alert alert-warning">
                                <strong>Ooops !</strong> Looks like the questions are over, create one ;)
                            </div>
                        @endforelse
                        {{ $questions->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
