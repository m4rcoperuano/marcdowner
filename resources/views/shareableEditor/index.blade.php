@extends('layouts.app')

@section('head')
    <script src="/js/prism.js" type="text/javascript"></script>
@endsection

@section('content')
    <markdown-viewer shareable-id="{{ $shareableId }}"></markdown-viewer>
@endsection
