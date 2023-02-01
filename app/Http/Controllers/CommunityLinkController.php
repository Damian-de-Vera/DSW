<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommunityLinkForm;
use App\Models\Channel;
use App\Models\CommunityLink;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommunityLinkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function index(Channel $channel = null)
    {

        $channels = Channel::orderBy('title', 'asc')->get();
        if ($channel) {
            $links = CommunityLink::join('channels', 'community_links.channel_id', '=', 'channels.id')
                ->where('approved', true)->where("channels.slug", $channel["slug"])->latest('community_links.updated_at')
                ->paginate(25);
            return view('community/index', compact('links', 'channels'));
        } else {

            $links = CommunityLink::where('approved', true)->latest('updated_at')->paginate(25);
            return view('community/index', compact('links', 'channels'));
        }
    }





    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)

    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CommunityLinkForm $request)
    {

        $approved = Auth::user()->trusted ? true : false;
        $request->merge(['user_id' => Auth::id(), 'approved' => $approved]);



        if ($approved) {

            $link = new CommunityLink();
            $link->user_id = Auth::id();
            $linkSubmitted = $link->hasAlreadyBeenSubmitted($request->link);

            if ($linkSubmitted) {
                return back()->with('success', 'Se ha actualizado correctamente!');
            } else {

                CommunityLink::create($request->all());
                return back()->with('success', 'Se ha añadido correctamente!');
            }
        } else {
            return redirect()->route('community')
                ->with('warning', "Para subir el link tienes que estar verificado");
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CommunityLink  $communityLink
     * @return \Illuminate\Http\Response
     */
    public function show(CommunityLink $communityLink)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CommunityLink  $communityLink
     * @return \Illuminate\Http\Response
     */
    public function edit(CommunityLink $communityLink)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CommunityLink  $communityLink
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CommunityLink $communityLink)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CommunityLink  $communityLink
     * @return \Illuminate\Http\Response
     */
    public function destroy(CommunityLink $communityLink)
    {
        //
    }
}