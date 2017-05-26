@extends('layouts.app')

@section('page-content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Todos @if(count($todos)) ({{count($todos)}} Remaining) @endif</h3>
                    </div>
                    <div class="panel-body">
                        <ul class="list-group" id="todo-list">
                            @if(count($todos))
                                @foreach($todos as $todo)
                                    <li class="list-group-item @if($todo->complete) list-group-item-success @endif">
                                        {{ $todo->text }}
                                        <div class="pull-right">
                                            <form class="btn-group btn-group-xs" method="post" action="{{ route('todo.update', $todo->id) }}">
                                                @if ($todo->complete)
                                                    <button type="submit" class="btn btn-warning">
                                                        <i class="glyphicon glyphicon-remove"></i>
                                                    </button>
                                                @else
                                                    <button type="submit" class="btn btn-success">
                                                        <i class="glyphicon glyphicon-ok"></i>
                                                    </button>
                                                @endif
                                                {{ method_field('PUT') }}
                                                {{ csrf_field() }}
                                                <a href="{{ route('todo.edit', $todo->id) }}" class="btn btn-primary">
                                                    <i class="glyphicon glyphicon-pencil"></i>
                                                </a>
                                                <input type="hidden" name="complete" value="{{ $todo->complete ? 0 : 1 }}" class="btn"> {{-- this has a btn class on it to trick bootstrap --}}
                                            </form>
                                            <form class="btn-group btn-group-xs" method="post" action="{{ route('todo.destroy', $todo->id) }}">
                                                {{ method_field('DELETE') }}
                                                {{ csrf_field() }}
                                                <button type="submit" class="btn btn-danger"><i class="glyphicon glyphicon-trash"></i></button>
                                            </form>
                                        </div>
                                    </li>
                                @endforeach
                            @else
                                <li class="list-group-item">Nothing to do!</li>
                            @endif
                        </ul>
                        <a href="{{ route('todo.create') }}" class="btn btn-primary">+ Add Todo</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection