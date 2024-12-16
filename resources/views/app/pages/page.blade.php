@extends('app.layouts.master.master-one-col')

@section('head-tag')
    <title>{{ $page->title }}</title>
@endsection

@section('content')

    {!! $page->body !!}

@endsection

@section('script')
    @php $data = ['className' => "delete"] @endphp
@endsection
