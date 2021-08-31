<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $members = Member::all();
        return response()->json([
            "success" => true,
            "message" => "members list",
            "data" => $members
        ], 200);
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'contact' => 'required',
           // 'user.name'=> 'required',
           // 'user.email'=> 'required|unique:users,email'

        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        $password = Hash::make('1234');
        $user = User::create(array_merge($request->get('user'), ['password'=> $password, 'type'=>0]));
        $member = Member::create(array_merge ($request->only(['name', 'contact']), ['user_id'=> $user->id]));
        $member->load(['user']);

        return response()->json([
            'success' => true,
            'message' => 'member added successfully',
            'data' => $member

        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $member = Member::find($id);
        if (is_null($member)) {
            return response()->json([
                'message' => 'member not found'
            ]);
        }

        return response()->json([

            'data' => $member
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function edit(Member $member)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Member $member)
    {
        //
        $input = $request->all();
        $validator = Validator::make($input, [
            'name' => 'required',
            'contact' => 'required'
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        $member->name = $input['name'];
        $member->contact = $input['contact'];
        $member->save();

        return response()->json([
            'success' => true,
            'message' => 'member updated successfully',
            'member' => $member
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function destroy(Member $member)
    {
        //
        $member->delete();
        return response()->json([
            'message' => 'member deleted successfully.'
        ]);
    }
}
