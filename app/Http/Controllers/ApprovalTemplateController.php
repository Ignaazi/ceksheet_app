<?php

namespace App\Http\Controllers;

use App\Models\ApprovalTemplate;
use Illuminate\Http\Request;

class ApprovalTemplateController extends Controller
{
    /**
     * Menampilkan daftar semua template approval.
     */
    public function index()
    {
        $templates = ApprovalTemplate::latest()->get();
        
        // Memanggil file resources/views/approval/approvalTemplate.blade.php
        return view('approval.approvalTemplate', compact('templates'));
    }

    /**
     * Menyimpan template baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'code'        => 'required|unique:approval_templates,code|max:50',
            'name'        => 'required|string|max:255',
            'blade_view'  => 'required|string|max:100',
            'category'    => 'nullable|string|max:100',
            'description' => 'nullable|string',
            'icon'        => 'nullable|string|max:100',
            'color'       => 'nullable|string|max:20',
        ]);

        $validated['icon'] = $request->filled('icon') ? $request->icon : 'fa-solid fa-file-invoice';
        $validated['color'] = $request->filled('color') ? $request->color : '#0984e3';

        ApprovalTemplate::create($validated);

        return redirect()->route('approval-templates.index')
                         ->with('success', 'Template approval berhasil ditambahkan!');
    }

    /**
     * Menampilkan detail template.
     */
    public function show($id)
    {
        $template = ApprovalTemplate::findOrFail($id);
        
        return view('approval.approvalTemplate', [
            'templates' => ApprovalTemplate::latest()->get(),
            'activeTemplate' => $template
        ]);
    }

    /**
     * Preview Blade Template yang di-extends ke approvalCanvas.blade.php
     */
    public function preview($id)
    {
        $template = ApprovalTemplate::findOrFail($id);

        // Path mengarah ke folder: resources/views/approval/approval-template/
        $viewPath = 'approval.approval-template.' . ($template->blade_view ?? 'template_printer');

        // Fallback jika file blade belum dibuat
        if (!view()->exists($viewPath)) {
            $viewPath = 'approval.approval-template.template_printer';
        }

        return view($viewPath, compact('template'));
    }

    /**
     * Memperbarui data template approval.
     */
    public function update(Request $request, $id)
    {
        $template = ApprovalTemplate::findOrFail($id);

        $validated = $request->validate([
            'code'        => 'required|max:50|unique:approval_templates,code,' . $id,
            'name'        => 'required|string|max:255',
            'blade_view'  => 'required|string|max:100',
            'category'    => 'nullable|string|max:100',
            'description' => 'nullable|string',
            'icon'        => 'nullable|string|max:100',
            'color'       => 'nullable|string|max:20',
            'is_active'   => 'nullable|boolean',
        ]);

        $template->update($validated);

        return redirect()->route('approval-templates.index')
                         ->with('success', 'Template approval berhasil diperbarui!');
    }

    /**
     * Menghapus template.
     */
    public function destroy($id)
    {
        $template = ApprovalTemplate::findOrFail($id);
        $template->delete();

        return redirect()->route('approval-templates.index')
                         ->with('success', 'Template approval berhasil dihapus!');
    }
}