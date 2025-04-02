<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::all();
        return view('services.index', compact('services'));
    }

    public function create()
    {
        return view('services.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'service_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'service_type' => 'required|string',
            'price' => 'required|numeric|min:0',
        ]);

        Service::create($request->all());

        return redirect()->route('services.index')->with('success', 'Dịch vụ đã được thêm.');
    }

    public function show(Service $service)
    {
        return view('services.show', compact('service'));
    }

    public function edit(Service $service)
    {
        return view('services.edit', compact('service'));
    }

    public function update(Request $request, Service $service)
    {
        $request->validate([
            'service_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'service_type' => 'required|string',
            'price' => 'required|numeric|min:0',
        ]);

        $service->update($request->all());

        return redirect()->route('services.index')->with('success', 'Dịch vụ đã được cập nhật.');
    }

    public function destroy(Service $service)
    {
        $service->delete();
        return redirect()->route('services.index')->with('success', 'Dịch vụ đã bị xóa.');
    }
}
