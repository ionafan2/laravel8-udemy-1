<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUser;
use App\Models\Image;
use App\Models\User;
use App\Services\Counter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    private Counter $counter;

    public function __construct(Counter $counter)
    {
        $this->middleware('auth');
        $this->authorizeResource(User::class, 'user');
        $this->counter = $counter;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $counter = $this->counter->increment("user-{$user->id}", ['user']);

        return view('users.show', ['user' => $user, 'counter' => $counter]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('users.edit', ['user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUser $request, User $user)
    {
        if ($request->hasFile('avatar')) {

            $path = $request->file('avatar')->store('avatar');

            if ($user->image) {
                Storage::delete($user->image->path);
                $user->image->path = $path;
                $user->image->save();
            } else {
                $user->image()->save(Image::make(['path' => $path]));
            }
        }

        $user->locale = $request->get('locale');
        $user->save();

        $user->save();

        return redirect()->back()->with('status', 'Updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}
