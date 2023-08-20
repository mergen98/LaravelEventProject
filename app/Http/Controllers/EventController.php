<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Models\Country;
use App\Models\Event;
use App\Models\Tag;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $events = Event::with('country', 'tags')->get();
        return view('events.index',compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $countries = Country::all();
        $tags = Tag::all();
        return view('events.create', compact('countries', 'tags'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateEventRequest $request)
    {
//        if ($request->hasFile('image')) {
//            $data = $request->validated();
//            dd($data);
//            $data['image'] = Storage::putFile('events', $request->file('image'));
//            $data['user_id'] = auth()->id();
//            $data['slug'] = Str::slug($data['title']);
//            Event::create($data);
//            return to_route('events.index');
//        }else{
//            return redirect()->back();
//        }
        
        if ($request->hasFile('image')) {
            $data = array_merge($request->validated(), [
                'image' => $request->file('image')->store('events'),
                'user_id' => auth()->id(),
                'slug' => Str::slug($request->input('title')),
            ]);
           $event = Event::create($data);
            $event->tags()->attach($request->tags);
            return redirect()->route('events.index');
        } else {
            return redirect()->back();
        }
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
    public function edit(Event $event)
    {
        $countries = Country::all();
        $tags = Tag::all();
        return view('events.edit', compact('countries', 'tags','event'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Event $event, UpdateEventRequest $request)
    {
        $data = $request->validated();
        if ($request->hasFile('image')) {
            Storage::delete($event->image);
            $data['image'] = $request->file('image')->store('events');
        }
        $data['slug'] = Str::slug($request->title );
        $event->update($data);
        $event->tags()->sync($request->tags);
        return redirect()->route('events.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        Storage::delete($event->image);
        $event->tags()->detach();
        $event->delete();
        return to_route('events.index');
    }
}
