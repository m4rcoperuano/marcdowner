<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContentController extends Controller
{
    public function index() {
        return Auth::id();
    }

    public function show() {

    }

    public function create() {
        $id = null;
        return redirect("editor/$id");
    }

    public function destroy() {

    }

    public function update() {

    }
}
