<?php

namespace App\Http\Controllers;

use App\Models\Gallary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() : View
    {
        $galleries = auth()->user()->galleries;
        return view('galleries.index',compact('galleries'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
        return view('galleries.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'caption' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif,max:2048',
        ]);
        if ($request->hasFile('image')) {
            auth()->user()->galleries()->create([
                'caption' => $request->input('caption'),
                'image' => $request->file('image')->store('galleries', 'public'),
            ]);
            
            return to_route('galleries.index');
        }
        
        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Gallary $gallery)
    {
        return view('galleries.edit', compact('gallery'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Gallary $gallery)
    {
        $validationRules = [
            'caption' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
        
        $request->validate($validationRules);
        
        $imageFile = $request->file('image');
        $path = $gallery->image;
        
        if ($imageFile) {
            Storage::delete($path);
            $path = $imageFile->store('galleries', 'public');
        }
        
        $gallery->update([
            'caption' => $request->input('caption'),
            'image' => $path,
        ]);
        
        return redirect()->route('galleries.index');
    }
    
    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Gallary $gallery): \Illuminate\Http\RedirectResponse
    {
        Storage::delete($gallery->image);
        $gallery->delete();
        return back();
    }
}
