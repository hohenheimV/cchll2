<?php
use App\Model\Activity;
use App\Model\Hardscape;
use App\Model\Softscape;
use App\Model\Article;
use App\Model\Feedback;
use App\Model\Page;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


if (!function_exists('app_dashboard_total_activiti')) {

    function app_dashboard_total_activiti(){
        return Activity::count();
    }
}
if (!function_exists('app_dashboard_total_aduan')) {

    function app_dashboard_total_aduan(){
        return Feedback::count();
    }
}

if (!function_exists('app_dashboard_total_hardscape')) {

    function app_dashboard_total_hardscape(){
        return Hardscape::count();
    }
}

if (!function_exists('app_dashboard_total_softscape')) {

    function app_dashboard_total_softscape(){
        return Softscape::count();
    }
}

if (!function_exists('app_dashboard_total_pages')) {

    function app_dashboard_total_pages(){
        return Page::count();
    }
}

if (!function_exists('app_dashboard_total_articles')) {

    function app_dashboard_total_articles(){
        return Article::count();
    }
}	

if (!function_exists('app_dashboard_total_feedback')) {

    function app_dashboard_total_feedback(){
        return Feedback::count();
    }
}

if (!function_exists('app_dashboard_total_activity')) {

    function app_dashboard_total_activity(){
        return Activity::count();
    }
}
