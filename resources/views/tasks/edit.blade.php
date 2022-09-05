@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col">Update Task</div>
                            <div class="col-auto">
                                <form action="{{ route('tasks.destroy', ['id' => $task->id]) }}" method="POST"
                                    class="delete">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('tasks.update', ['id' => $task->id]) }}">
                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                <label>Name</label>
                                <input class="form-control" type="text" name="name" value="{{ $task->name }}"
                                    required>
                            </div>

                            <button type="submit" class="btn btn-success">Update</button>
                            <a href="{{ route('tasks.index') }}" class="btn btn-warning">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('form.delete').on('submit', function() {
                if (!confirm("Do you really want to detele this task?"))
                    return false;
            });
        });
    </script>
@endsection
