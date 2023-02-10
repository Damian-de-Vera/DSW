<?php

namespace App\Queries;

use App\Models\Channel;
use App\Models\CommunityLink;

class CommunityLinksQuery
{
    public function getByChannel(Channel $channel)
    {
        $result = $channel->communitylinks()->where('approved', true)->latest('community_links.updated_at')
            ->paginate(25);
        return $result;
    }
    public function getByChannelAndMostPopular(Channel $channel)
    {
        $result = $channel->communitylinks()->where('approved', true)->withCount('users')->orderBy('users_count', 'desc')->paginate(25);
        return $result;
    }

    public function getAll()
    {
        $result = CommunityLink::where('approved', true)->latest('updated_at')->paginate(25);
        return $result;
    }

    public function getMostPopular()
    {
        $result = CommunityLink::withCount('users')->orderBy('users_count', 'desc')->paginate(25);
        return $result;
    }
}
