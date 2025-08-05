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
        $this->authorize('viewAny', Task::class);
        $filter = $request->get('filter', 'all');
        $user = Auth::user();

        $tasksQuery = $user->tasks();

        if ($filter === 'completed') {
            $tasksQuery->where('completed', true);
        } elseif ($filter === 'pending') {
            $tasksQuery->where('completed', false);
        }

        // REKOMENDASI: Gunakan orderByRaw untuk menempatkan deadline NULL di akhir daftar.
        // Ini lebih intuitif bagi pengguna.
        $tasks = $tasksQuery->orderByRaw('deadline IS NULL, deadline ASC')->get();

        return view('dashboard', compact('tasks', 'filter'));
    }

    public function store(Request $request)
    {
        // REKOMENDASI: Tambahkan otorisasi untuk konsistensi.
        $this->authorize('create', Task::class);

        $request->validate([
            'title' => 'required|max:255',
            'deadline_date' => 'nullable|date|required_with:deadline_time',
            'deadline_time' => 'nullable|date_format:H:i|required_with:deadline_date',
            'priority' => 'required|in:Rendah,Sedang,Tinggi',
            'reminder_offset' => 'nullable|integer',
        ]);

        $deadline = null;
        if ($request->filled('deadline_date') && $request->filled('deadline_time')) {
            $deadline = Carbon::parse($request->deadline_date . ' ' . $request->deadline_time);
        }

        $task = Auth::user()->tasks()->create([
            'title' => $request->title,
            'priority' => $request->priority,
            'deadline' => $deadline,
            'reminder_offset' => $request->reminder_offset,
        ]);

        return redirect()->route('dashboard')->with('success', "Tugas '{$task->title}' berhasil ditambahkan!");
    }

    public function update(Request $request, Task $task)
    {
        $this->authorize('update', $task);

        $request->validate([
            'completed' => 'sometimes|boolean',
        ]);

        // PERBAIKAN KRITIS: Gunakan $request->boolean('completed')
        // $request->has('completed') akan selalu true karena adanya hidden input,
        // sehingga tugas tidak akan pernah bisa di-set sebagai 'pending' kembali.
        $task->update(['completed' => $request->boolean('completed')]);
        
        return redirect()->route('dashboard')->with('success', "Tugas '{$task->title}' berhasil diperbarui!");
    }

    public function destroy(Task $task)
    {
        $this->authorize('delete', $task);
        $taskTitle = $task->title;
        $task->delete();
        return redirect()->route('dashboard')->with('success', "Tugas '{$taskTitle}' berhasil dihapus!");
    }
}