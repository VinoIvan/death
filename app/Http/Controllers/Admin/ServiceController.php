<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Http\Requests\Admin\StoreServiceRequest;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    /**
     * Отображение списка услуг
     */
    public function index()
    {
        $services = Service::withCount(['appointments', 'schedules'])
            ->orderBy('sort_order')
            ->orderBy('name')
            ->paginate(15);
        
        return view('admin.services.index', compact('services'));
    }

    /**
     * Показ формы создания новой услуги
     */
    public function create()
    {
        return view('admin.services.create');
    }

    /**
     * Сохранение новой услуги
     */
    public function store(StoreServiceRequest $request)
    {
        Service::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'duration' => $request->duration,
            'sort_order' => $request->sort_order ?? 0,
        ]);

        return redirect()->route('admin.services.index')
            ->with('success', 'Услуга успешно создана!');
    }

    /**
     * Показ формы редактирования услуги
     */
    public function edit(Service $service)
    {
        return view('admin.services.edit', compact('service'));
    }

    /**
     * Обновление услуги
     */
    public function update(StoreServiceRequest $request, Service $service)
    {
        $service->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'duration' => $request->duration,
            'sort_order' => $request->sort_order ?? 0,
        ]);

        return redirect()->route('admin.services.index')
            ->with('success', 'Услуга успешно обновлена!');
    }

    /**
     * Удаление услуги
     */
    public function destroy(Service $service)
    {
        if ($service->appointments()->exists()) {
            return back()->with('error', 'Нельзя удалить услугу, на которую есть записи!');
        }

        $service->delete();

        return redirect()->route('admin.services.index')
            ->with('success', 'Услуга успешно удалена!');
    }
}