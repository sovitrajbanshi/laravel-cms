@extends('layouts.app')
@section('content')
    <div class="div d-flex justify-content-end mb-2">
        <a href="{{route('categories.create')}}" class="btn btn-success ">Add categories</a>
    </div>

    <div class="card card-default">
        <div class="card-header">categories</div>
        <div class="card-body">
            @if($categories->count()>0)
            <table class="table">
                <thead>
                <th>Name</th>
                <th>Post count</th>
                <th></th>
                </thead>
                <tbody>
                @foreach ($categories as $category)
                    <tr>
                        <td>
                            {{$category->name}}
                        </td>
                        <td>
                            {{$category->posts->count()}}
                        </td>
                        <td>
                            <a href="{{route('categories.edit',$category->id)}}" class="btn btn-info btn-sm">Edit</a>
                            <button class="btn btn-danger btn-sm" onclick="handleDelete({{$category->id}})">Delete</button>
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
                    <form action="" method="POST" id="deletecategoryForm">
                        @csrf
                        @method('DELETE')

                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="deletemodalLabel">Delete category</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p class="text-center text-bold">
                                   are u sure do you want to delete this  category?
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

            var form=document.getElementById('deletecategoryForm')
            form.action='/categories/'+id

            $('#deletemodal').modal('show')
        }
    </script>

@endsection