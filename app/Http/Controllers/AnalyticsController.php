<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Analytics\Facades\Analytics;
use Spatie\Analytics\Period;
use Spatie\Analytics\OrderBy;
use Carbon\Carbon;

class AnalyticsController extends Controller
{
    public function analyticsData(){
        //retrieve visitors and page view data for the current day and the last seven days
        $analyticsData = Analytics::fetchVisitorsAndPageViews(Period::days(7));
    
        //retrieve visitors and page views since the 6 months ago
        $analyticsData = Analytics::fetchVisitorsAndPageViews(Period::months(6));
        $fetchTopCountries = Analytics::fetchTopCountries(Period::months(6));
        dd($analyticsData,$fetchTopCountries);
    }
}
