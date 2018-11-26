@extends('layouts.app')

@section('head')
    <script src="/js/prism.js" type="text/javascript"></script>
    <link href="/css/prism.css" type="text/css" rel="stylesheet" />
@endsection

@section('content')
    <markdown-editor content-id="{{ $contentId }}"></markdown-editor>
@endsection
