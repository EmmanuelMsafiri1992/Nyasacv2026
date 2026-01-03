<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\ResumeTemplate;
use App\Models\ResumeCategories;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ResumetemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = ResumeTemplate::query();

        if ($request->filled('search')) {
            $data->where('name', 'like', '%' . $request->search . '%');
        }

        $data = $data->paginate(10);

        return view('resumetemplates.index', compact(
            'data'
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        $categories = ResumeCategories::select("id", "name")->get();


        return view('resumetemplates.create', compact(
            'categories'
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


        $request->validate([
            'category_id'            => 'required|integer',
            'name'    =>  'required',
            'content'    =>  'required',
            'style'    =>  'required',
            'thumb'         =>  'required|image|max:2048',
        ]);
       
        if (!$request->filled('is_premium')) {
            $request->request->add([
                'is_premium' => false,
            ]);
        } else {
            $request->request->add([
                'is_premium' => true,
            ]);
        }
        if (!$request->filled('active')) {
            $request->request->add([
                'active' => false,
            ]);
        } else {
            $request->request->add([
                'active' => true,
            ]);
        }

        $image = $request->file('thumb');

        $new_name = rand() . '.' . $image->getClientOriginalExtension();

        $image->move(public_path('images'), $new_name);
        
        $form_data = array(
            'category_id'       =>   $request->category_id,
            'name'        =>   $request->name,
            'content'       =>   $request->content,
            'style'        =>   $request->style,
            'is_premium'       =>   $request->is_premium,
            'active'        =>   $request->active,
            'thumb'            =>   $new_name
        );


        $user = ResumeTemplate::create($form_data);

        return redirect()->route('settings.resumetemplate.index')
            ->with('success', __('Created successfully'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $resumeTemplate = ResumeTemplate::findorFail($id);

        $categories = ResumeCategories::select("id", "name")->get();
        return view('resumetemplates.edit', compact(
            'resumeTemplate','categories'
        ));
    }
    public function liveEdit($id)
    {
        $data = ResumeTemplate::findorFail($id);

        $path_img = url('image_templates');

        $data->content = strtr($data->content, array('{$path_img}' => $path_img));


        if($data){
                $style = $data->style;
                $content = $data->content;
                $name = $data->name;
                $id = $data->id;
                return view('resumetemplates.live_edit', compact('data'));
        }
        abort(404);
        
    }
 
    public function postLiveEdit(Request $request)
    {

        if (is_numeric($request->id)) {
            
            $item = ResumeTemplate::find($request->id);

            if ($request->filled('name')) {
                $item->name = $request->name;
            }
            if ($request->filled('style')) {
                $item->style = $request->style;
            }
            if ($request->filled('content')) {
                $item->content = $request->content;
            }
            if($item->save()){

                return response()->json(['success'=>__("Updated successfully")." ".$item->name,'id'=> $item->id]);
            }
        }
        return response()->json(['error'=>__("Updated failed")]);
    }
    public function postAsNewTemplate(Request $request)
    {
        if (is_numeric($request->id)) {
            
            $itemOld = ResumeTemplate::find($request->id);

            // new template
            $item = ResumeTemplate::create([
                'category_id'  => $itemOld->id,
                'thumb'  => $itemOld->thumb,
                'is_premium'  => $itemOld->is_premium,
                'active' => 0,
                'name' => $request->name,
                'style'  => $request->style,
                'content' => $request->content
            ]);

            if($item->save()){

                return response()->json(['success'=>__("Created successfully")." ".$item->name,'id'=> $item->id]);
            }
        }
        return response()->json(['error'=>__("Created failed")]);
    }

    public function exportPDF($id,Request $request){

        if (is_numeric($id)) {
            
            $data = ResumeTemplate::find($id);

            $path_img = url('image_templates');

            $data->content = strtr($data->content, array('{$path_img}' => $path_img));

            if($data){

                $style = $data->style;
                $content = $data->content;
                $name = $data->name;
                return view('resumetemplates.viewpdf', compact('style', 'content', 'name'));
            }
        }
        abort(404);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $image_name = $request->hidden_image;
        
        $image = $request->file('thumb');
        
        if($image != '')
        {
            $request->validate([
                'category_id'            => 'required|integer',
                'name'    =>  'required',
                'content'    =>  'required',
                'style'    =>  'required',
                'thumb'         =>  'required|image|max:2048',
            ]);

            $image_name = rand() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $image_name);
        }
        else
        {
            $request->validate([
                'category_id'            => 'required|integer',
                'name'    =>  'required',
                'content'    =>  'required',
                'style'    =>  'required',
            ]);
        }
  
        if (!$request->filled('is_premium')) {
            $request->request->add([
                'is_premium' => false,
            ]);
        } else {
            $request->request->add([
                'is_premium' => true,
            ]);
        }
        if (!$request->filled('active')) {
            $request->request->add([
                'active' => false,
            ]);
        } else {
            $request->request->add([
                'active' => true,
            ]);
        }

                
        $form_data = array(
            'category_id'       =>   $request->category_id,
            'name'        =>   $request->name,
            'content'       =>   $request->content,
            'style'        =>   $request->style,
            'is_premium'       =>   $request->is_premium,
            'active'        =>   $request->active,
            'thumb'            =>   $image_name
        );
        
        ResumeTemplate::whereId($id)->update($form_data);

        return redirect()->route('settings.resumetemplate.index')
            ->with('success', __('Updated successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $item = ResumeTemplate::find($id);
        try {
            $item->delete();

        } catch (Exception $e) {
            
            var_dump($e); die;
        }
        

        return redirect()->route('settings.resumetemplate.index')
            ->with('success', __('Deleted successfully'));
    }

}
