<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ShareableLinkResource;
use App\Models\ShareableLink;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\Resource;

class ShareableController extends Controller
{
    public function index() {

    }

    public function show(Request $request, $id) {
        $shareable = ShareableLink::whereContentId($id)->first();
        if (!$shareable) {
            abort(404);
        }

        return new ShareableLinkResource($shareable);
    }

    public function store(Request $request) {
        $shareable = ShareableLink::whereContentId( $request->get('contentId') )
            ->first();

        if (!$shareable) {
            $shareable = ShareableLink::create([
                'content_id' => $request->get('contentId')
            ]);
        }

        return new ShareableLinkResource($shareable);
    }

    public function update(Request $request, $id) {

    }

    public function destroy(Request $request, $id) {
        ShareableLink::destroy($id);
        return Resource::make([]);
    }
}
