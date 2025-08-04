<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->get('filter', 'all');
        $user = Auth::user();

        $tasksQuery = $user->tasks();

        if ($filter === 'completed') {
            $tasksQuery->where('completed', true);
        } elseif ($filter === 'pending') {
            $tasksQuery->where('completed', false);
        }

        $tasks = $tasksQuery->orderBy('deadline', 'asc')->get();

        return view('tasks.index', compact('tasks', 'filter'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'deadline_date' => 'nullable|date',
            'deadline_time' => 'nullable|date_format:H:i',
            'priority' => 'required|in:Rendah,Sedang,Tinggi',
            'reminder_offset' => 'nullable|integer',
        ]);

        // Pastikan jika salah satu deadline diisi, keduanya harus diisi
        if ($request->filled('deadline_date') xor $request->filled('deadline_time')) {
            return redirect()->back()->withErrors(['deadline' => 'Tanggal dan waktu deadline harus diisi bersamaan.'])->withInput();
        }

        $deadline = null;
        if ($request->filled('deadline_date') && $request->filled('deadline_time')) {
            $deadline = Carbon::parse($request->deadline_date . ' ' . $request->deadline_time);
        }

        Auth::user()->tasks()->create([
            'title' => $request->title,
            'priority' => $request->priority,
            'deadline' => $deadline,
            'reminder_offset' => $request->reminder_offset,
        ]);

        return redirect()->route('tasks.index')->with('success', 'Tugas berhasil ditambahkan!');
    }

    public function update(Request $request, Task $task)
    {
        $this->authorize('update', $task);

        $request->validate([
            'completed' => 'sometimes|boolean',
        ]);

        $task->update(['completed' => $request->has('completed')]);
        return redirect()->route('tasks.index')->with('success', 'Tugas berhasil diperbarui!');
    }

    public function destroy(Task $task)
    {
        $this->authorize('delete', $task);

        $task->delete();
        return redirect()->route('tasks.index');
    }
}