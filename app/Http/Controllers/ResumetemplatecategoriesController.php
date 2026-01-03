<?php

namespace App\Http\Controllers;

use App\Models\ResumeCategories;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ResumetemplatecategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = ResumeCategories::query();

        if ($request->filled('search')) {
            $data->where('name', 'like', '%' . $request->search . '%');
        }

        $data = $data->paginate(10);

        return view('resumetemplatecategories.index', compact(
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

        return view('resumetemplatecategories.create');
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
            'name'    =>  'required',
            'thumb'         =>  'required|image|max:2048',
        ]);
       

        $image = $request->file('thumb');

        $new_name = rand() . '.' . $image->getClientOriginalExtension();

        $image->move(public_path('images/categories'), $new_name);
        
        $form_data = array(
            'name'        =>   $request->name,
            'thumb'            =>   $new_name
        );


        $user = ResumeCategories::create($form_data);

        return redirect()->route('settings.resumetemplatecategories.index')
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
        $category = ResumeCategories::findorFail($id);

        return view('resumetemplatecategories.edit', compact(
            'category'
        ));
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
                'name'    =>  'required',
                'thumb'         =>  'required|image|max:2048',
            ]);

            $image_name = rand() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/categories'), $image_name);
        }
        else
        {
            $request->validate([
                'name'    =>  'required',
            ]);
        }
  


                
        $form_data = array(
            'name'        =>   $request->name,
            'thumb'            =>   $image_name
        );
        
        ResumeCategories::whereId($id)->update($form_data);

        return redirect()->route('settings.resumetemplatecategories.index')
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
        $item = ResumeCategories::find($id);
        try {
            $item->delete();

        } catch (Exception $e) {
            
            var_dump($e); die;
        }
        

        return redirect()->route('settings.resumetemplatecategories.index')
            ->with('success', __('Deleted successfully'));
    }

}
