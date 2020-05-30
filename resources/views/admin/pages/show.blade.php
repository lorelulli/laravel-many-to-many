@extends('layouts.app')
@section('content')

<div class="container">
    <div class="row">
        <div class="col-12">
            <h2>{{$page->title}}</h2>
            <h3>{{$page->category->name}}</h3>
            <small>{{$page->user->name}}</small>
            <small>{{$page->updated_at}}</small>

        </div>
        @if ($page->tags->count() > 0)
            <div class="">
                <h4>Tags</h4>
                <ul>
                    @foreach ($page->tags as $tag)
                        <li>{{$tag->name}}</li>

                    @endforeach
                </ul>

            </div>

        @endif

    </div>

</div>
