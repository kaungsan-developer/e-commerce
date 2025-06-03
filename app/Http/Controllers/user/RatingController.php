<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Http\Requests\user\RatingStoreRequest;
use App\Models\Rate;
use Illuminate\Support\Facades\Auth;
class RatingController extends Controller
{
    public function store(RatingStoreRequest $request)
    {   
        $this->authorize('create', Rate::class);
        $rate = Rate::updateOrCreate([
            'user_id' => Auth::user()->id,
            'product_id' => $request->product_id,
        ], [
            'star' => $request->star,
            'feedback' => $request->feedback,
        ]);
        return redirect()->back();
    }

    public function destroy(Rate $rate)
    {
        $this->authorize('delete', $rate);
        $rate->delete();
        return redirect()->back();
    }
}
