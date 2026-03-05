<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    /**
     * Отображение списка услуг с сортировкой
     */
    public function index(Request $request)
    {
        $query = Service::query();
        
        // Сортировка по выбранному параметру
        switch ($request->get('sort')) {
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            case 'duration':
                $query->orderBy('duration');
                break;
            default:
                $query->orderBy('sort_order')->orderBy('name');
        }
        
        $services = $query->paginate(10);
        
        return view('client.services.index', compact('services'));
    }
}