@extends('layouts.master')

@section('title', 'Список файлов')


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
    <table class="table table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Название файла</th>
                <th>Оригинальное название</th>
                <th>Дата добавления</th>
                <th>Срок обновления</th>
                <th>Установиться дата</th>
                <th>Просмотр</th>
                <th>Удалить</th>
            </tr>
        </thead>
        <tbody>
        @foreach($files as $file)
            <tr>
                <td>{{ $file->id }}</td>
                <td>{{ $file->name }}</td>
                <td>{{ $file->original_name }}</td>
                <td>{{ $file->created_at }}</td>
                @if($file->type=="1")
                    <td>До: {{ $file->last_date }}</td>
                @else
                    <td>Обновлять каждые: {{ $file->reload / 86400 }} дней.</td>
                @endif
                <td>{{ $file->last }}</td>
                <td><a href="/show/{{ $file->id }}" class="btn btn-success">Просмотр</a></td>
                <td>
                    {!! Form::open(array('url' => 'delete_file/'.$file->id, 'method' => 'delete')) !!}

                    {!! Form::submit('Удалить', array('class' => 'btn btn-danger')) !!}

                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection