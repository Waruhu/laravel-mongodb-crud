<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Member;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;
use App\Transformer\MemberTransformer;
use League\Fractal\Resource\Item as Item;
use Leaque\Fractal;

use League\Fractal\Manager;
use Response;


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
        $membersTransform =  fractal()
                ->collection($members)
                ->transformWith(new MemberTransformer())
                ->includeCharacters()
                ->toArray();
        return response()->json([
            $membersTransform,
        ], 200);
        // return view('members.memberindex', compact('members'));           
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('members.memberadd');
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
        $member = new Member;
        $member->first_name = $request->input('first_name');
        $member->last_name  = $request->input('last_name');
        $member->gender     = $request->input('gender');
        $member->address    = $request->input('address');
        $member->status     = $request->input('status');
        if ($member->save()) {
            return response()->json([
                'message' => 'article created Successfully',
                'data' => fractal()->item($member, new MemberTransformer),
            ], 200);
        }
        throw new HttpException(400, "Invalid data"); 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $member = Member::find($id);
        $dataMember = fractal()->item($member, new MemberTransformer);
        return response()->json([
            $dataMember,
        ], 200);
    }

    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $member = Member::find($id);
      return view('members.memberedit', compact('member'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $member = Member::find($id);
        $member->first_name = $request->input('first_name');
        $member->last_name  = $request->input('last_name');
        $member->gender     = $request->input('gender');
        $member->address    = $request->input('address');
        $member->status     = $request->input('status');
        $member->save();
        return response()->json([
            'message' => 'Member Updated Succesfully',
            'data' => fractal()->item($member, new MemberTransformer),
        ], 200); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $member = Member::find($id)->delete();
        return response()->json("Member Deleted Successfully",200);
    }
}
