<?php

namespace App\Http\Controllers;

use App\Models\Content;
use App\Models\ShareableLink;
use Illuminate\Http\Request;

class ShareableEditorController extends Controller
{
    public function index(Request $request, $id) {
        $shareable = ShareableLink::find($id);
        if (!$shareable) {
            abort(404);
        }

        return view("shareableEditor.index", [
            'shareableId' => $id
        ]);
    }
}
