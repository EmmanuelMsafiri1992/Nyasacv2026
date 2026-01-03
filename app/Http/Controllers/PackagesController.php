<?php

namespace App\Http\Controllers;

use App\Models\Package;
use Illuminate\Http\Request;

class PackagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Package::paginate(10);

        return view('packages.index', compact(
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
        return view('packages.create');
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
            'title'                   => 'required',
            'price'                   => 'required',
            'interval'                => 'required',
            'interval_number'         => 'required',
        ]);
        $settings = [
            "export_pdf" => 0,
            "template_premium" => 0,
        ];

        $settings["export_pdf"] = $request->input('settings.export_pdf') ? 1 : 0;
        
        $settings["template_premium"] = $request->input('settings.template_premium') ? 1 : 0;
        
        $is_featured = $request->input('is_featured') ? true : false;

        $item = Package::create([
            'title' => $request->title,
            'price'     => $request->price,
            'interval'    => $request->interval,
            'interval_number' => $request->interval_number,
            'is_featured' => $is_featured,
            'settings' =>$settings
        ]);
        

        return redirect()->route('settings.packages.index')
            ->with('success', __('Created successfully'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function edit(Package $package)
    {
        return view('packages.edit', compact(
            'package'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Package $package)
    {
        $request->validate([
            'title'                   => 'required',
            'price'                   => 'required',
            'interval'                => 'required',
            'interval_number'         => 'required',
        ]);

        if (!$request->filled('is_featured')) {
            $request->request->add([
                'is_featured' => false,
            ]);
        } else {
            $request->request->add([
                'is_featured' => true,
            ]);
        }
        $settings = [
            "export_pdf" => 0,
            "template_premium" => 0,
        ];

        $settings["export_pdf"] = $request->input('settings.export_pdf') ? 1 : 0;
        
        $settings["template_premium"] = $request->input('settings.template_premium') ? 1 : 0;
        
        $is_featured = $request->input('is_featured') ? true : false;


        $package->update([
            
            'title' => $request->title,
            'price'     => $request->price,
            'interval'    => $request->interval,
            'interval_number' => $request->interval_number,
            'is_featured' => $is_featured,
            'settings' =>$settings
        ]);

        return redirect()->route('settings.packages.edit', $package)
            ->with('success', __('Updated successfully'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function destroy(Package $package)
    {
        $package->delete();

        // Should we remove post from the Instagram as well?

        return redirect()->route('settings.packages.index')
            ->with('success', __('Deleted successfully'));
    }
}
