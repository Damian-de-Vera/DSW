<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommunityLinkForm;
use App\Models\Channel;
use App\Models\CommunityLink;
use App\Models\CommunityLinkUser;
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
            $token = 1;

            /* $links = CommunityLink::join('channels', 'community_links.channel_id', '=', 'channels.id')
                ->where('approved', true)->where("channels.slug", $channel["slug"])->latest('community_links.updated_at')
                ->paginate(25);*/
            if (request()->exists('popular')) {

                $links = $channel->communitylinks()->where('approved', true)->withCount('users')->orderBy('users_count', 'desc')->paginate(25);

                return view('community/index', compact('links', 'channels', 'token'));
            } else {

                $links = $channel->communitylinks()->where('approved', true)->latest('community_links.updated_at')
                    ->paginate(25);
                return view('community/index', compact('links', 'channels', 'token'));
            }
        } else {
            $token = 0;
            if (request()->exists('popular')) {

                $links = CommunityLink::where('approved', true)->withCount('users')->orderBy('users_count', 'desc')->paginate(25);

                return view('community/index', compact('links', 'channels', 'token'));
            } else {
                $links = CommunityLink::where('approved', true)->latest('updated_at')->paginate(25);

                return view('community/index', compact('links', 'channels', 'token'));
            }
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
            CommunityLink::create($request->all());
            return redirect()->route('community')
                ->with('warning', "Hsta que no estes verificado no puedes ver el link");
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
