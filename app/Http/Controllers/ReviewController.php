<?php

namespace App\Http\Controllers;

use App\Http\Requests\Review\ReviewStoreRequest;
use App\Http\Requests\Review\ReviewUpdateRequest;
use App\Http\Resources\ReviewResource;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:customer')->only('store');

        $this->middleware(['auth:customer', 'EnsureReviewOwner'])->only([
            'destroy',
            'update'
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(
            ReviewResource::collection(Review::paginate(12))->response()->getData(true)
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(ReviewStoreRequest $request)
    {
        if (Review::where('customer_id', auth()->id())->where('product_id', $request->product_id)->first()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Not allowed to make more than one review of the same product, you can update the old one.'
            ], 422);
        }

        $validated = $request->validated();

        $validated['customer_id'] = auth()->id();

        Review::create($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Recored has been added successfully.'
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Review $review
     * @return \Illuminate\Http\Response
     */
    public function show(Review $review)
    {
        return response()->json([
            'data' => new ReviewResource($review)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Models\Review $review
     * @return \Illuminate\Http\Response
     */
    public function update(ReviewUpdateRequest $request, Review $review)
    {
        $validated = $request->validated();

        $review->update($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Recored has been updated successfully.'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Review $review
     * @return \Illuminate\Http\Response
     */
    public function destroy(Review $review)
    {
        $review->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Recored has been deleted successfully.'
        ]);
    }
}
