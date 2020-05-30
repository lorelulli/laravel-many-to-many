@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                @foreach ($errors->all() as $message)
                    {{$message}}

                @endforeach
                <form  action="{{route('admin.pages.update', $page->id)}}" method="post">
                    @csrf
                    @method('PATCH')
                    <div class="form-group">
                        <label for="title">Titolo</label>
                        <input type="text" name="title" class="form-control" value=" {{old('title') ?? $page->title}}">


                    </div>
                    <div class="form-group">
                        <label for="summary">Sommario</label>
                        <input type="text" name="summary" class="form-control" value=" {{old('summary') ?? $page->summary}}">


                    </div>
                    <div class="form-group">
                        <label for="body">Testo</label>
                        <textarea name="body" rows="10" cols="30" class="form-control">{{old('body') ?? $page->body}}</textarea>

                    </div>
                    <div class="form-group">
                        <label for="category_id">Categoria</label>
                        <select  name="category_id">
                            @foreach ($categories as $category)
                                <option value="{{$category->id}}" {{(!empty(old('category_id')) ||  $category->id == $page->category->id) ? "selected" : ''}} >{{$category->name}}</option>

                            @endforeach

                        </select>
                    </div>
                    <div class="tags">
                        <h3>Tags</h3>
                        @foreach ($tags as $key => $tag)
                            <label for="tags-{{$tag->id}}">{{$tag->name}}</label>
                            <input type="checkbox" name="tags[]" value="{{$tag->id}}"{{(!empty(old('tags.' . $key))) ? "checked" : ''}} id="tags-{{$tag->id}}" >

                        @endforeach

                    </div>
                    <div class="photos">
                        <h3>Photos</h3>
                        @foreach ($photos as $key => $photo)
                            <label for="photos-{{$photo->id}}">{{$photo->name}}</label>
                            <input type="checkbox" name="photos[]" value="{{$photo->id}}"{{(!empty(old('photos.' . $key))) ? "checked" : ''}} id="photos-{{$photo->id}}" >

                        @endforeach

                    </div>
                    <input type="submit" class="btn btn-primary" value="salva">

                </form>

            </div>

        </div>

    </div>
