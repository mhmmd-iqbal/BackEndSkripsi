<?php

namespace App\Http\Controllers;

use App\Models\Major;
use Illuminate\Http\Request;

class MajorController extends Controller
{
    public function index()
    {
        $data = Major::get();

        return $this->apiRespond('ok', $data);
    }
}
