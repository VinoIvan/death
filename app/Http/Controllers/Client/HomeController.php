<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\Review;
use App\Models\Setting;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Отображение главной страницы
     */
    public function index()
    {
        $services = Service::orderBy('sort_order')
            ->take(6)
            ->get();

        $reviews = Review::approved()
            ->with('user')
            ->latest()
            ->take(6)
            ->get();

        $siteName = Setting::get('site_name', 'VCM Laser');

        return view('client.home.index', compact('services', 'reviews', 'siteName'));
    }
}