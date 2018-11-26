@extends('layouts.app')

@section('head')
    <script src="/js/prism.js" type="text/javascript"></script>
    <link href="/css/prism.css" type="text/css" rel="stylesheet" />
@endsection

@section('content')
    <markdown-viewer shareable-id="{{ $shareableId }}"></markdown-viewer>
@endsection
