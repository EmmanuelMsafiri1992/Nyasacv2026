<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use App\Library\Helper;

use App\Models\Resume;
use App\Models\ResumeCategories;
use App\Models\ResumeTemplate;

use App\User;
use Illuminate\Http\Request;

class ResumeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function index(Request $request)
    {
        
        $data = Resume::where('user_id', $request->user()->id);

        if($request->user()->can('admin')){
            $data = Resume::withCount(['user']);
        }
       
        
        if ($request->filled('search')) {
            $data->where('name', 'like', '%' . $request->search . '%');
        }

        $data->orderBy('created_at', 'DESC');

        $data = $data->paginate(5);

        return view('resume.index', compact(
            'data'
        ));
    }
    
    
    
 
    public function getAllTemplate($id = "") {
      // Get templates
      
      $data = "";

      $categories = ResumeCategories::all();

      if ($id) {
          $data = ResumeTemplate::where('category_id', $id);
          $data->where('active', true);
      }
      else{
         $data = ResumeTemplate::where('active', true);
      }
      

      // if ($request->filled('search')) {
      //       $data->where('name', 'like', '%' . $request->search . '%');
      // }

      $data->orderBy('created_at', 'DESC');
        
      $data = $data->paginate(9);

      return view('resume.template', compact('data','categories'));

    }
    public function getCreateResume($template,Request $request) {
        
        $action = "create";
        $data = ResumeTemplate::find($template);
        
        $path_img = url('image_templates');
        $data->content = strtr($data->content, array('{$path_img}' => $path_img));

        return view('resume.formresume', compact('action','data'));
        
    }
    

    public function postCreateResume(Request $request)
    {

        $validator = Validator::make($request->all(), 
            [
            'name' => 'required|unique:resumes|max:255',
            'style' => 'required',
            'content' => 'required',
            ]
        );

        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()->all()]);
        }
        else{
            // export PDF
            $item = Resume::create([
                'user_id'  => $request->user()->id,
                'name' => $request->input('name'),
                'style'  => $request->input('style'),
                'content' => $request->input('content')
            ]);

        }
        //return redirect()->route('resume.exportpdf', $item->id)->with('success', __('Add successfully'));

        return response()->json(['success'=>__('Created successfully')." ".$item->name,'id'=> $item->id]);
    }
    
    public function getEditResume($id,Request $request){
        
        if (is_numeric($id)) {

            $data = Resume::where('user_id', $request->user()->id);

            if($request->user()->can('admin')){
                $data = Resume::all();
            }

            $data = $data->find($id);

            $config = array("type" => $data->thumb);

            if($data){
                $action = "update";
                $style = $data->style;
                $content = $data->content;
                $name = $data->name;
                $id = $data->id;
                return view('resume.formresume', compact('action','id', 'name','style', 'content', 'config','data'));
            }
            
        }
        abort(404);
    }
    
    public function postEditResume(Request $request)
    {
        if (is_numeric($request->id)) {
            
            $item = Resume::find($request->id);

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

    public function delete($id,Request $request)
    {
        if (is_numeric($id)) {
            
            $data = Resume::where('user_id', $request->user()->id);

            if($request->user()->can('admin')){
                $data = Resume::all();
            }

            $item = $data->find($id);

            if($item){
                $item->delete();
                return redirect()->route('resume.index')->with('success', __('Deleted successfully'));
            }
        }
        abort(404);
    }

    public function exportPDF($id,Request $request){

        if (is_numeric($id)) {
            
            $data = Resume::where('user_id', $request->user()->id);

            if($request->user()->can('admin')){
                $data = Resume::all();
            }

            $item = $data->find($id);

            if($item){

                $style = $item->style;
                $content = $item->content;
                $name = $item->name;
                return view('resume.viewpdf', compact('style', 'content', 'name'));
            }
        }
        abort(404);

    }
    
}
