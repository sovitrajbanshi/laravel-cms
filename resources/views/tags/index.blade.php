@extends('layouts.app')
@section('content')
    <div class="div d-flex justify-content-end mb-2">
        <a href="{{route('tags.create')}}" class="btn btn-success ">Add tags</a>
    </div>

    <div class="card card-default">
        <div class="card-header">tags</div>
        <div class="card-body">
            @if($tags->count()>0)
                <table class="table">
                    <thead>
                    <th>Name</th>
                    <th>Post count</th>
                    <th></th>
                    </thead>
                    <tbody>
                    @foreach ($tags as $tag)
                        <tr>
                            <td>
                                {{$tag->name}}
                            </td>
                            <td>
                            {{$tag->posts->count()}}
                            </td>
                            <td>
                                <a href="{{route('tags.edit',$tag->id)}}" class="btn btn-info btn-sm">Edit</a>
                                <button class="btn btn-danger btn-sm" onclick="handleDelete({{$tag->id}})">Delete</button>
                            </td>

                        </tr>

                    @endforeach
                    </tbody>

                </table>
            @else
                <h3 class="text-center">No post yet</h3>
            @endif
            <div class="modal fade" id="deletemodal" tabindex="-1" role="dialog" aria-labelledby="deletemodalLabel"
                 aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <form action="" method="POST" id="deletetagForm">
                        @csrf
                        @method('DELETE')

                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="deletemodalLabel">Delete tag</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p class="text-center text-bold">
                                    are u sure do you want to delete this  tag?
                                </p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">No Goback</button>
                                <button type="submit" class="btn btn-danger">Yes, delete</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        function handleDelete(id){

            var form=document.getElementById('deletetagForm')
            form.action='/tags/'+id

            $('#deletemodal').modal('show')
        }
    </script>

@tags