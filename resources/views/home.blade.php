@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Dashboard') }}</div>


                    @if (Session::has('success'))
                        <div class="col-12 alert alert-success justify-content-center d-flex">
                            <p class="text-center"> {{ Session::get('success') }}</p>
                        </div>
                    @endif
                    @if (isset($posts) && $posts->count() > 0)
                        @foreach ($posts as $post)
                            <div class="card-body">
                                @if (session('status'))
                                    <div class="alert alert-success" role="alert">
                                        {{ session('status') }}
                                    </div>
                                @endif

                                @if (Auth::id() == $post->user->id)

                                    <h2 class="text-danger"> {{ $post->user->name }} : {{ $post->title }}</h2>
                                @else
                                    <h2 class="">{{ $post->user->name }} : {{ $post->title }}</h2>
                                @endif

                                <br>
                                {{ $post->body }}
                                <br>
                                <br>
                                <h5>Comments</h5>
                                @if ($post->comments()->count() > 0)
                                    @foreach ($post->comments as $_comment)
                                        <p>{{ $_comment->comment }}</p>
                                    @endforeach
                                @endif
                                <br><br>

                            </div>
                            <form method="POST" action="{{ route('add_comment') }}" enctype="multipart/form-data">
                                @csrf

                                <input type="hidden" name="post_id" value="{{ $post->id }}">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="comment">
                                    @error('name_ar')
                                        <small class="form-text text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <button type="submit" class="btn btn-primary">add comments</button>

                            </form>
                        @endforeach
                        <br><br>

                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
