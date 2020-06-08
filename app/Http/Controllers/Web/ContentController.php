<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Content;
use App\Models\Gender;
use App\Http\Requests\ContentRequest;
use DB;

class ContentController extends Controller
{
    public function index()
    {
        return view('content.index');
    }

    public function search(Request $request)
    {

        if ($request->ajax()) {

            $query = $request->get('query');

            if($query != '')
            {
                $data = Content::where('name', 'like', '%'.$query.'%')->get();
            }
            else
            {
                $data = Content::get();

            }
          $gender = Gender::all()->toArray();
          $total_row = $data->count();
          $output = '';
          if($total_row > 0)
          {
           foreach($data as $row)
           {
            $output .= '
            <tr class="tr' . $row->id . '">
             <td>'.$row->id.'</td>
             <td>'.$row->name.'</td>
             <td>'.$row->age.'</td>
             <td> <img src="' . $row->image . '" class="img-rounded" width="75px"></td>
             <td>'.$row->gender->name.'</td>
             <td>
                <a href="' . route('content.edit', $row->id) . '" class="btn btn-success btn-xs"><i class="fa fa-edit"></i>Edit</a>
             </td>

             <td>
                <a href="" row_id="' . $row->id . '" class="delete_btn btn btn-danger btn-xs"><i class="fa fa-trash-o"></i></a></td> 
            </td>
            </tr>
            ';
            
           }


          }
          else
          {
           $output = '
           <tr class="alert alert-danger">
            <td align="center" colspan="5">No Data Found</td>
           </tr>
           ';
          }
          $data = array(
           'table_data'  => $output,
          );

          echo json_encode($data);
         }
        }

    public function create()
    {
    	return view('content.create');
    }

    public function store(ContentRequest $request)
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
                'status' => true,
                'msg' => 'Saved',
            ]);

        else
            return response()->json([
                'status' => false,
                'msg' => 'Failed',
            ]);
    }

    public function delete(Request $request){

        $content = Content::find($request->id);   // Offer::where('id','$offer_id') -> first();;
        if (!$content)
            return redirect()->back()->with(['error' => 'error']);

        $content->delete();

        return response()->json([
            'status' => true,
            'msg' => 'Deleted',
            'id' =>  $request->id
        ]);

    }

    public function edit(Request $request)
    {
    	$content = Content::find($request->row_id);  // search in given table id only
        if (!$content)
            return response()->json([
                'status' => false,
                'msg' => 'Failed',
            ]);

        $content = Content::select('id', 'name', 'age', 'gender_id')->find($request->row_id);

        return view('content.edit', compact('content'));
    }

    public function update(ContentRequest $request)
    {
    	$content = Content::find($request->id);
        if (!$content)
            return response()->json([
                'status' => false,
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
            'status' => true,
            'msg' => 'Saved',
        ]);
    }
}
