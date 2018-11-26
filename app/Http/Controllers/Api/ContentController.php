<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ContentResource;
use App\Models\Content;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContentController extends Controller
{
    public function index() {
        return ContentResource::collection(
            Content::whereUserId(Auth::id())
                ->orderBy('updated_at', 'desc')
                ->get()
        );
    }

    public function show($id) {
        return new ContentResource(Content::find($id));
    }

    public function store() {
        $content = Content::create([
            'user_id' => Auth::id(),
            'title' => 'My Markdown File',
            'unparsed_markdown' => ''
        ]);

        return redirect("editor/$content->id");
    }

    public function update(Request $request, $id) {
        $content = Content::find($id);
        $content->unparsed_markdown = $request->get('content') ?? '';
        $content->title = $request->get('title') ?? '[No Title]';
        $content->save();

        return new ContentResource($content);
    }

    public function destroy() {

    }
}
