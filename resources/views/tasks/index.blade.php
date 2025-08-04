<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hyper-Productive To-Do List</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/dayjs@1/dayjs.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/dayjs@1/plugin/relativeTime.js"></script>
    <script>dayjs.extend(window.dayjs_plugin_relativeTime);</script>
    <style>
        @keyframes fadeIn { from { opacity: 0; transform: translateY(-10px); } to { opacity: 1; transform: translateY(0); } }
        .task-item { animation: fadeIn 0.3s ease-out forwards; }
        .filter-btn.active { background-color: #3b82f6; color: white; box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1); }
        .form-icon { position: absolute; left: 0.75rem; top: 50%; transform: translateY(-50%); color: #9ca3af; }
        .input-with-icon { position: relative; }
        .input-with-icon input, .input-with-icon select { padding-left: 2.5rem; }
    </style>
</head>
<body class="bg-gray-200 font-sans">
    <div class="container mx-auto my-10 p-4">
        <div class="max-w-3xl mx-auto bg-white rounded-2xl shadow-2xl p-8">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-4xl font-extrabold text-gray-800">Hyper-Productive Hub</h1>
                <nav>
                    @auth
                        <a href="{{ url('/dashboard') }}" class="text-blue-600 hover:text-blue-800 font-semibold mr-4">Dashboard</a>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="text-red-600 hover:text-red-800 font-semibold">Log Out</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-800 font-semibold mr-4">Log in</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="text-blue-600 hover:text-blue-800 font-semibold">Register</a>
                        @endif
                    @endauth
                </nav>
            </div>

            <!-- Form Tambah Tugas -->
            @auth
            <form action="{{ route('tasks.store') }}" method="POST" class="mb-8 p-5 bg-gray-50 rounded-xl shadow-inner">
                @csrf
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="sm:col-span-2 input-with-icon">
                        <svg class="form-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" width="20"><path d="M13.586 3.586a2 2 0 112.828 2.828l-11.213 11.213-4.243 1.414 1.414-4.243L13.586 3.586z"/></svg>
                        <input type="text" name="title" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition-shadow shadow-sm" placeholder="What needs to be done?" required>
                    </div>
                    <div class="input-with-icon">
                        <svg class="form-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" width="20"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/></svg>
                        <input type="date" name="deadline_date" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition-shadow shadow-sm">
                    </div>
                    <div class="input-with-icon">
                        <svg class="form-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" width="20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.414-1.414L11 10.586V6z" clip-rule="evenodd"/></svg>
                        <input type="time" name="deadline_time" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition-shadow shadow-sm">
                    </div>
                    <div class="input-with-icon">
                         <svg class="form-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" width="20"><path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/><path fill-rule="evenodd" d="M4 5a2 2 0 012-2h8a2 2 0 012 2v12a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h4a1 1 0 100-2H7zm0 4a1 1 0 100 2h4a1 1 0 100-2H7z" clip-rule="evenodd"/></svg>
                        <select name="priority" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition-shadow shadow-sm">
                            <option value="Rendah">Low</option>
                            <option value="Sedang" selected>Medium</option>
                            <option value="Tinggi">High</option>
                        </select>
                    </div>
                     <div class="input-with-icon">
                        <svg class="form-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" width="20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm.707-10.293a1 1 0 00-1.414-1.414l-3 3a1 1 0 001.414 1.414L10 9.414l.293.293a1 1 0 001.414-1.414l-1-1z" clip-rule="evenodd" /></svg>
                        <select name="reminder_offset" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition-shadow shadow-sm">
                            <option value="">No Reminder</option>
                            <option value="5">5 minutes before</option>
                            <option value="15">15 minutes before</option>
                            <option value="60">1 hour before</option>
                            <option value="1440">1 day before</option>
                        </select>
                    </div>
                    <div class="sm:col-span-2">
                        <button type="submit" class="w-full bg-blue-600 text-white font-bold px-6 py-3 rounded-lg hover:bg-blue-700 transform hover:scale-105 transition-all shadow-lg flex items-center justify-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" /></svg>
                            Add Task
                        </button>
                    </div>
                </div>
            </form>

            <!-- Tombol Filter -->
            <div class="flex justify-center gap-3 mb-8">
                <a href="{{ route('tasks.index', ['filter' => 'all']) }}" class="filter-btn px-5 py-2 rounded-full font-semibold transition-all {{ $filter == 'all' ? 'active' : 'bg-gray-200 text-gray-700' }}">All</a>
                <a href="{{ route('tasks.index', ['filter' => 'pending']) }}" class="filter-btn px-5 py-2 rounded-full font-semibold transition-all {{ $filter == 'pending' ? 'active' : 'bg-gray-200 text-gray-700' }}">Pending</a>
                <a href="{{ route('tasks.index', ['filter' => 'completed']) }}" class="filter-btn px-5 py-2 rounded-full font-semibold transition-all {{ $filter == 'completed' ? 'active' : 'bg-gray-200 text-gray-700' }}">Completed</a>
            </div>

            <!-- Daftar Tugas -->
            <div class="space-y-4">
                @php use Carbon\Carbon; @endphp
                @forelse ($tasks as $task)
                    @php
                        $isOverdue = !$task->completed && $task->deadline && Carbon::now()->isAfter($task->deadline);
                        $isNearDeadline = !$task->completed && $task->deadline && Carbon::now()->diffInHours($task->deadline, false) > 0 && Carbon::now()->diffInHours($task->deadline) < 24;
                        $priorityClasses = [
                            'Tinggi' => 'border-l-8 border-red-500',
                            'Sedang' => 'border-l-8 border-yellow-500',
                            'Rendah' => 'border-l-8 border-green-500',
                        ];
                        $cardClass = $task->completed ? 'bg-green-50' : ($isOverdue ? 'bg-red-50' : ($isNearDeadline ? 'bg-yellow-50' : 'bg-white'));
                    @endphp
                    <div class="task-item flex items-center justify-between p-4 rounded-xl shadow-md hover:shadow-lg transition-all {{ $cardClass }} {{ $priorityClasses[$task->priority] }}">
                        <div class="flex items-center">
                            <form action="{{ route('tasks.update', $task->id) }}" method="POST" class="mr-4">
                                @csrf @method('PATCH')
                                <input type="checkbox" name="completed" {{ $task->completed ? 'checked' : '' }} onchange="this.form.submit()" class="h-6 w-6 text-blue-600 focus:ring-blue-500 border-gray-300 rounded-full cursor-pointer">
                            </form>
                            <div>
                                <span class="font-medium text-lg {{ $task->completed ? 'line-through text-gray-400' : 'text-gray-800' }}">{{ $task->title }}</span>
                                @if ($task->deadline)
                                    <div class="text-sm text-gray-600 mt-1 flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.414-1.414L11 10.586V6z" clip-rule="evenodd" /></svg>
                                        <span class="font-semibold {{ $isOverdue ? 'text-red-600' : ($isNearDeadline ? 'text-yellow-700' : 'text-gray-600') }}" id="countdown-{{ $task->id }}"></span>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="px-3 py-1 rounded-full text-sm font-semibold {{ ['Tinggi' => 'bg-red-200 text-red-800', 'Sedang' => 'bg-yellow-200 text-yellow-800', 'Rendah' => 'bg-green-200 text-green-800'][$task->priority] }}">{{ $task->priority }}</span>
                            <form action="{{ route('tasks.destroy', $task->id) }}" method="POST">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-gray-400 hover:text-red-600 transition-colors"><svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg></button>
                            </form>
                        </div>
                    </div>
                    @if ($task->deadline)
                        <script>
                            (function() {
                                const countdownElement = document.getElementById('countdown-{{ $task->id }}');
                                if (!countdownElement) return;
                                function updateCountdown() {
                                    const deadline = dayjs('{{ $task->deadline->toISOString() }}');
                                    const now = dayjs();
                                    if (deadline.isBefore(now)) {
                                        countdownElement.textContent = 'Overdue';
                                    } else {
                                        countdownElement.textContent = `in ${dayjs().to(deadline, true)}`;
                                    }
                                }
                                updateCountdown();
                                setInterval(updateCountdown, 60000);
                            })();
                        </script>
                    @endif
                @empty
                    <div class="text-center py-10 px-6 bg-gray-50 rounded-xl">
                        <svg class="mx-auto w-1/2 h-auto text-gray-300" viewBox="0 0 512 512" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path d="M432 112V96a48.14 48.14 0 00-48-48H64A48.14 48.14 0 0016 96v320a48.14 48.14 0 0048 48h224a48.14 48.14 0 0048-48v-16a16 16 0 00-32 0v16a16 16 0 01-16 16H64a16 16 0 01-16-16V96a16 16 0 0116-16h320a16 16 0 0116 16zm-64-48a16 16 0 01-16 16H160a16 16 0 010-32h192a16 16 0 0116 16zm-32 256a16 16 0 01-16 16H160a16 16 0 010-32h160a16 16 0 0116 16zm0-80a16 16 0 01-16 16H160a16 16 0 010-32h160a16 16 0 0116 16zm0-80a16 16 0 01-16 16H160a16 16 0 010-32h160a16 16 0 0116 16z"/><path d="M480 208a112 112 0 10112 112 112.12 112.12 0 00-112-112zm54.63 80L448 374.63l-42.63-86.63a16 16 0 0122.62-22.62L448 306.75l61.37-61.38a16 16 0 0122.63 22.63z"/></svg>
                        <p class="mt-4 text-lg font-semibold text-gray-700">You're all caught up!</p>
                        <p class="text-gray-500">Looks like there's nothing on your to-do list.</p>
                    </div>
                @endforelse
            </div>
            @endauth
            @guest
                <div class="text-center py-10 px-6 bg-gray-50 rounded-xl">
                    <p class="mt-4 text-lg font-semibold text-gray-700">Please log in to manage your tasks.</p>
                    <a href="{{ route('login') }}" class="mt-4 inline-block bg-blue-600 text-white font-bold px-6 py-3 rounded-lg hover:bg-blue-700 transition-all">Log In</a>
                </div>
            @endguest
        </div>
    </div>

    @auth
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // 1. Minta Izin Notifikasi
            if ('Notification' in window && Notification.permission !== 'granted') {
                Notification.requestPermission();
            }

            // 2. Kumpulkan semua tugas yang memerlukan reminder
            const tasksWithReminders = [
                @foreach ($tasks as $task)
                    @if (!$task->completed && $task->deadline && $task->reminder_offset)
                        {
                            id: {{ $task->id }},
                            title: '{{ addslashes($task->title) }}',
                            deadline: '{{ $task->deadline->toISOString() }}',
                            reminderOffset: {{ $task->reminder_offset }},
                            notified: false
                        },
                    @endif
                @endforeach
            ];

            // 3. Notification Engine
            function checkReminders() {
                if (Notification.permission !== 'granted') return;

                const now = dayjs();

                tasksWithReminders.forEach(task => {
                    if (task.notified) return;

                    const deadline = dayjs(task.deadline);
                    const reminderTime = deadline.subtract(task.reminderOffset, 'minute');

                    if (now.isAfter(reminderTime) && now.isBefore(deadline)) {
                        new Notification('Task Reminder', {
                            body: `"${task.title}" is due soon!`,
                            icon: 'https://cdn-icons-png.flaticon.com/512/109/109622.png' // Ganti dengan ikon Anda
                        });
                        task.notified = true; // Tandai agar tidak dinotifikasi lagi
                    }
                });
            }

            // Jalankan pengecekan setiap 30 detik
            setInterval(checkReminders, 30000);
        });
    </script>
    @endauth
</body>
</html>