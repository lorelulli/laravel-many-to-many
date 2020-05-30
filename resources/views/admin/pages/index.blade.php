@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <table>
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Titolo</th>
                            <th>Categoria</th>
                            <th>Tags</th>
                            <th>Data Creazione</th>
                            <th>Data Update</th>
                            <th colspan="3"> Azioni</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pages as $page)
                            <td>{{$page->id}}</td>
                            <td>{{$page->title}}</td>
                            <td>{{$page->category->name}}</td>
                            @foreach ($page->tags as $tag)
                                <td>{{$tag->name}}</td> <br>

                            @endforeach
                            <td>{{$page->created_at}}</td>
                            <td>{{$page->updated_at}}</td>
                            <td><a class="btn btn-primary" href="{{route('admin.pages.show',$page->id)}}">Visualizza</a> </td>
                            <td><a class="btn btn-primary" href="{{route('admin.pages.edit',$page->id)}}">Modifica</a> </td> 
                            <td>Elimina</td>

                        @endforeach

                    </tbody>
                </table>

            </div>

        </div>

    </div>

@endsection
