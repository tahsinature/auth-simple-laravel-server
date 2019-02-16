<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Quote;
use App\User;


class QuoteController extends Controller
{
    public function getQuotes(Request $request) {
        $user = User::find($request->user->id);
        return response()->json($user->quotes);
    }

    public function newQuote(Request $request) {
        $quote = new Quote;
        $quote->text = $request->text;
        $quote->user_id = $request->user->id;
        $quote->save();
        return response()->json($quote, 201);
    }

    public function deleteQuote(Request $request, $id) {
        $quote = Quote::find($id);
        if (!$quote) return response("Quote not found", 404);
        $quote->delete();
        return response()->json($quote, 200);
    }

}
