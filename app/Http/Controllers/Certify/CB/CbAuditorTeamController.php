<?php

namespace App\Http\Controllers\Certify\CB;

use Illuminate\Http\Request;
use App\Certify\CbAuditorTeam;
use App\Http\Controllers\Controller;

class CbAuditorTeamController extends Controller
{
    public function index(Request $request)
    {
        $model = str_slug('setting-team-cb','-');
        if(auth()->user()->can('view-'.$model)) {
            $cbAuditorTeams = CbAuditorTeam::paginate(15);
            // dd($cbAuditorTeams);
            return view('certify.cb.auditor_setting.index',[
                'cbAuditorTeams' => $cbAuditorTeams
            ]);
        }
        abort(403);

    }

}
