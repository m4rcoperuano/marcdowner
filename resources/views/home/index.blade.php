@extends('layouts.app')

@section('content')
    <div class="py-2 pl-3 pr-3">
        <div class="container">
            <div class="row mt-2">
                <div class="col-md-12">
                    <h1> Create your first Markdown file below</h1>
                    <p> This app does 2 things: </p>
                    <ol>
                        <li> Has an editor for Markdown docs</li>
                        <li> Allows you to share those docs</li>
                    </ol>

                    <p>That's all for now :)</p>
                    <p>Any questions? Email me at <a href="mailto:marco.j.ledesma@gmail.com">marco.j.ledesma@gmail.com</a></p>

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
    </div>
@endsection
