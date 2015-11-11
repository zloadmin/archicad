@extends('layouts.master')

@section('title', 'Добавить файл')


@section('content')

    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {!! Form::open(array('action' => 'FilesController@store', 'role' => 'form', 'enctype' => 'multipart/form-data')) !!}

        <div class="form-group">
            {!! Form::label('name', 'Название файла*') !!}
            {!! Form::text('name', '', array('class' => 'form-control', 'required' => 'required', 'style' => 'width: 30%;')) !!}
        </div>

        <div class="form-group">Срок действия</div>

        <div class="radio">
            <label>
                {!! Form::radio('type', '1', true) !!}
                До даты
            </label>
        </div>

        <div class="form-group">
            {!! Form::text('date', '', ['id' => 'date', 'class' => 'form-control', 'style' => 'width: 160px;']) !!}
        </div>

        <div class="radio">
            <label>
                {!! Form::radio('type', '2') !!}
                Обновлять каждые
            </label>
        </div>

        <div class="form-group">
            {!! Form::select('period', array('86400' => 'День', '2592000' => 'Месяц', '5184000' => '2 Месяца', '31104000' => 'Год')) !!}
        </div>

        <div class="form-group">
            {!! Form::label('file', 'Файл') !!}
            {!! Form::file('file', array('required' => 'required')) !!}
            <p class="help-block">Файл расширения *.gsm</p>
        </div>
        <button type="submit" class="btn btn-default">Создать</button>
    {!! Form::close() !!}
@endsection