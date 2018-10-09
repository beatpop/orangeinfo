@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="row">
                    @if(isset($files) && !empty($files) && count($files))
                        @for($i = 0; $i < count($files); $i++)
                            <div class="col-lg-4 col-md-4">
                                <div class="thumbnail">
                                    <img src="{{ url('file/show/' . $files[$i]->id) }}" alt="{{ $files[$i]->name }}" width="100%">
                                    <div class="caption">
                                        <p>&nbsp;</p>
                                        <h3>{{ $files[$i]->name }}</h3>
                                        <p><a href="{{ url('file/show/' . $files[$i]->id) }}" class="btn btn-primary" target="_blank">查看大图</a></p>
                                        @if(\Illuminate\Support\Facades\Auth::check())
                                            <p><a href="{{ url('file/delete/' . $files[$i]->id) }}" class="btn btn-primary">删除图片</a></p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endfor
                    @else
                        <div class="col-md-10 text-center">
                            <h3> 无图片 </h3>
                        </div>
                    @endif
                </div>
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