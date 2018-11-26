@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row mt-2">
            <div class="col-md-12">
                <h1> Hello. This App Does 2 Things...</h1>
                <ol>
                    <li> Has an editor for Markdown docs </li>
                    <li> Allows you to share said docs </li>
                </ol>
                <p>That's all for now :)</p>

                <form method="post" action="{{ route('content-create')  }}">
                    {{ csrf_field()  }}
                    <button class="btn btn-primary btn-lg">
                        <span class="fa fa-plus-circle"></span> Create Markdown Doc
                    </button>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <h3 class="mt-4">Your Markdown Docs</h3>
                <hr/>
                <document-list></document-list>
            </div>
        </div>
    </div>
@endsection
