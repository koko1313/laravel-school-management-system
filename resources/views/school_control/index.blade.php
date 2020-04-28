@extends('layout.layout')

@section('title', 'Управление на училището')

@section('heading1', 'Управление на училището')

@section('content')

    <div class="container">

        @include('layout.messages')

        <h2>Управление на учебната година</h2>
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <form method="post">
                    <div class="form-group">
                        <label>Текущ учебен срок</label>
                        <select name="term_id" class="form-control">
                        @foreach($terms as $term)
                            <option value="{{$term->id}}" {{$term->now == 1 ? 'selected' : ''}}>{{$term->term_label}}</option>
                        @endforeach
                        </select>
                    </div>
                    <button class="btn btn-primary" name="change_school_term_button">Смени срока</button>
                    {{csrf_field()}}
                </form>
                <br>
                <a class="btn btn-primary" href="{{route('next_school_year')}}" onclick="return confirm('Преминаване в следваща учебна година?')">Премини на следваща учебна година</a>
            </div>
        </div>

        <h2>Управление на училището</h2>
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <form method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label>Име на училището</label>
                        <input type="text" name="school_name" class="form-control" value="{{$school_info->school_name}}">
                    </div>

                    <div class="form-group">
                        <div style="float: left">
                            <label>Снимка <span class="glyphicon glyphicon-picture"></span></label>
                            <input type="file" class="form-control-file" name="image">
                            <small class="form-text text-muted">Снимката трябва да е в JPG формат.</small>
                        </div>
                        <image src="images/school_picture.jpg" width="100px" style="display: block;"/>
                    </div>

                    <div class="form-group">
                        <label>Описание на училището</label>
                        <textarea name="school_description" class="form-control" rows="10">{{$school_info->description}}</textarea>
                    </div>

                    <button class="btn btn-primary" name="change_school_details_button">Промени</button>
                    {{csrf_field()}}
                </form>
            </div>
        </div>

    </div>

@endsection