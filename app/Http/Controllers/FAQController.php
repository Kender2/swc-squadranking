<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;

class FAQController extends Controller
{
    public function form(Request $request)
    {
        if ($request->has('question') && !$request->has('agreement'))
        {
            DB::table('faq')->insert(['ip' => $request->ip(), 'question' => $request->input('question'), 'created_at' => Carbon::now()]);
            $request->session()->flash('message', 'Your question has been saved. It may be answered in the future after an admin reviews it.');
            return redirect('faq');
        }
        return view('faq');
    }
}

