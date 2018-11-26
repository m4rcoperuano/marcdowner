@extends('layouts.app')

@section('head')
    <script src="/js/prism.js" type="text/javascript"></script>
@endsection

@section('content')
    <markdown-editor content-id="{{ $contentId }}"></markdown-editor>
@endsection
