@extends('layouts.app')

@section('styles')
    <style>

    </style>
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col">Tasks</div>
                            <div class="col-auto">
                                <a class="dropdown-item" href="{{ route('tasks.create') }}">Create Task</a>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        @if ($tasks->count() > 0)
                            <ul class="list-group tasks" id="sortable">
                                @foreach ($tasks as $task)
                                    <li class="list-group-item" data-task-id="{{ $task->id }}">
                                        <div class="row">
                                            <div class="col" style="cursor: move;">{{ $task->name }}</div>

                                            <div class="col-auto"><a class="btn btn-info text-white"
                                                    href="{{ route('tasks.edit', ['id' => $task->id]) }}">Edit</a></div>
                                            <div class="col-auto">
                                                <form action="{{ route('tasks.destroy', ['id' => $task->id]) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">
                                                        Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p>There is no tasks yet, <a href="{{ route('tasks.create') }}">Create the first one.</a></p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $("#sortable").sortable({
            stop: function(event, ui) {
                var $e = $(ui.item);
                var $prevItem = $e.prev();
                var $nextItem = $e.next();

                $.ajax({
                    url: "{{ route('tasks.setPriority') }}",
                    method: 'POST',
                    dataType: 'json',
                    data: {
                        _token: '{{ csrf_token() }}',
                        task_id: $e.data('task-id'),
                        prev_id: $prevItem ? $prevItem.data('task-id') : null,
                        next_id: $nextItem ? $nextItem.data('task-id') : null
                    }
                });
            }
        });
    </script>
@endsection
