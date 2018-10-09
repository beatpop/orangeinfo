@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                @if(isset($files) && !empty($files) && count($files))
                    <ul style="list-style: none;">
                        @foreach($files as $file)
                            <li style="list-style: none; margin-bottom: 10px;">
                                <img src="{{ url('file/show/' . $file->id) }}" width="100%" class="center-block">
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>

        <div class="row justify-content-start">
            <div class="col-md-10" style="margin-top: 50px">
                <br>
                <a href="{{ url('/file/upload') }}" target="_self"><span>返回重新上传</span></a>
            </div>
        </div>
    </div>
@endsection