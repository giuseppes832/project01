<?php

namespace App\Utilities;

use App\Models\Invite;
use App\Models\Nodes\HtmlList;
use App\Models\Nodes\HtmlSelect;
use App\Models\Nodes\HtmlSharingSelect;
use App\Models\Row;
use App\Models\Sharing;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Request;

class CommonService
{

    public function getSharing() {

        $sharing_id = Cookie::get("sharing_id");


        $sharing = null;
        if ($sharing_id) {

            $sharing = Sharing::whereHasMorph(
                'sharingType',
                [Invite::class],
                function($query) {

                    $query->where('email', Auth::user()->email);
                }
            )->where("id", $sharing_id)->first();

        }

        return $sharing;
    }



    public function isFilteringRowVerified($parentRowId, $sharingId) {

        $htmlLists = HtmlList::query()->whereHas("binding", function($query) use ($parentRowId) {
            $query->whereHas("rows", function ($query) use ($parentRowId) {
                $query->where("rows.id", $parentRowId);
            });
        })->get();

        if ($htmlLists->count() > 0) {

            foreach ($htmlLists as $htmlList) {

                $filteringNode = $htmlList->defaultFilterBinding;

                $parentRow = Row::find($parentRowId);

                // Parent row foreign key
                $fkValue = $filteringNode->html->binding->values($parentRow)->first();

                if ($filteringNode->html_type === HtmlSharingSelect::class) {

                    if ($sharingId === $fkValue->withValue->value) {
                        return true;
                    } else {
                        return "ERROR_403";
                    }

                } else {

                    // Pointing row = current parent row
                    //$row = $filteringNode->html->formBinding->row($fkValue->withValue->value)->first();

                    return $this->isFilteringRowVerified($fkValue->withValue->value, $sharingId);
                }

            }

        } else {
            return "ERROR_404";
        }

    }



    public function getFilteringValue($filteringNode) {

        $defaultFilterValue = null;

        if ($filteringNode->html_type === HtmlSharingSelect::class) {

            if (Auth::user()->isInvitedUser()) {
                $sharing = $this->getSharing();
                if (!$sharing) {
                    abort(403);
                } else {
                    $defaultFilterValue = $sharing->id;
                }
            }

        } else if ($filteringNode->html_type === HtmlSelect::class) {

            if (Auth::user()->isInvitedUser()) {
                $sharing = $this->getSharing();
                if (!$sharing) {
                    abort(403);
                }

                $parentRowId = Request::query("parent_row_id");
                $ok = $this->isFilteringRowVerified($parentRowId, $sharing->id);
                if (!(true === $ok)) {
                    if ("ERROR_403" === $ok) {
                        abort(403);
                    } elseif ("ERROR_404" === $ok) {
                        abort(404);
                    }
                } else {
                    $defaultFilterValue = $parentRowId;
                }
            } else {
                $defaultFilterValue = Request::query("parent_row_id");
            }

        }

        return $defaultFilterValue;

    }

}
