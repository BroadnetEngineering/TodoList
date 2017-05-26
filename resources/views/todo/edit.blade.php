@extends('layouts.app')

@section('page-content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Edit Todo</h3>
                    </div>
                    <form class="panel-body" method="post" action="{{ route('todo.update', $todo->id) }}">
                        {{ method_field('PUT') }}
                        @include('todo.partials.form')
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection