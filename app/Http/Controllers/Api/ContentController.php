<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Content;
use App\Http\Requests\ContentRequest;

class ContentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contents = Content::paginate(10);

        return response()->json([
            'status' => 1,
            'message'=>'success',
            'data'=>$contents
        ]);
    }

    public function showOne(Request $request)
    {
        $content = Content::find($request->id);

        return response()->json([
            'status' => 1,
            'message'=>'success',
            'data'=>$content
        ]);
    }

    public function create(ContentRequest $request)
    {
        $content = Content::create($request->all());
        if ( $request->hasFile('image')  ) {
           $image = $request->image;
           $image_new_name = time() . $image->getClientOriginalName();
           $image->move('uploads/content', $image_new_name);
           $content->image = 'uploads/content/'.$image_new_name;
           $content->save();
        }

        if ($content)
            return response()->json([
            'status' => 1,
            'message'=>'success',
            'data'=>$content
        ]);

        else
            return response()->json([
                'status' => 0,
                'msg' => 'Failed',
            ]);
    }

    public function delete(Request $request){

        $content = Content::find($request->id);   // Offer::where('id','$offer_id') -> first();;
        if (!$content)
            return response()->json([
                'status' => 0,
                'msg' => 'Failed',
            ]);
        $content->delete();

        return response()->json([
            'status' => 1,
            'msg' => 'Deleted',
            'id' =>  $request->id
        ]);

    }

    public function edit(ContentRequest $request)
    {
        $content = Content::find($request->id);
        if (!$content)
            return response()->json([
                'status' => 0,
                'msg' => 'Failed',
            ]);

        //update data

        $content->update($request->except('image'));

        if ( $request->hasFile('image')  ) {
           $image = $request->image;
           $image_new_name = time() . $image->getClientOriginalName();
           $image->move('uploads/content', $image_new_name);
           $content->image = 'uploads/content/'.$image_new_name;
           $content->save();
        }

        return response()->json([
            'status' => 1,
            'msg' => 'Updated',
            'data'=>$content
        ]);
    }
}