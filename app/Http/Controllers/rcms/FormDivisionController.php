<?php

namespace App\Http\Controllers\rcms;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SetDivision;
use Illuminate\Support\Facades\Auth;
class FormDivisionController extends Controller
{
    public function formDivision(Request $request)
    {
        $request->session()->forget('division');
        $request->session()->put('division', $request->division_id);
        if ($request->process_name == "Field Visit") {
            return redirect('field_visit');
        } 
        elseif ($request->process_name == "New Document") {

            $new = new SetDivision;
            $new->division_id = $request->division_id;
            $new->process_id = $request->process_id;
            $new->user_id = Auth::user()->id;
            $new->save();

            return redirect('documents/create');
        }
    }
}
