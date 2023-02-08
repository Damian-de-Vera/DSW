<?php

namespace App\Http\Controllers;

use App\Models\CommunityLink;
use App\Models\CommunityLinkUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommunityLinkUserController extends Controller
{

    public function store(CommunityLink $link)
    {

        $vote =  CommunityLinkUser::firstOrNew([
            'user_id' => Auth::id(),
            'community_link_id' => $link->id
        ]);
        $this->toggle($vote);

        return back();
    }

    public function toggle($vote)
    {
        if ($vote->id) {
            $vote->delete();
        } else {
            $vote->save();
        }
    }
}
