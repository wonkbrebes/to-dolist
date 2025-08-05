<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tasks') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8">
                {{-- Task Creation Form --}}
                <form action="{{ route('tasks.store') }}" method="POST" class="mb-8 p-5 bg-gray-50 rounded-xl shadow-inner">
                    @csrf
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="sm:col-span-2 input-with-icon">
                            <svg class="form-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" width="20"><path d="M13.586 3.586a2 2 0 112.828 2.828l-11.213 11.213-4.243 1.414 1.414-4.243L13.586 3.586z"/></svg>
                            <input type="text" name="title" value="{{ old('title') }}" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition-shadow shadow-sm" placeholder="What needs to be done?" required>
                        </div>
                        <div class="input-with-icon">
                            <svg class="form-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" width="20"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/></svg>
                            <input type="date" name="deadline_date" value="{{ old('deadline_date') }}" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition-shadow shadow-sm">
                        </div>
                        <div class="input-with-icon">
                            <svg class="form-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" width="20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.414-1.414L11 10.586V6z" clip-rule="evenodd"/></svg>
                            <input type="time" name="deadline_time" value="{{ old('deadline_time') }}" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition-shadow shadow-sm">
                        </div>
                        <div class="input-with-icon">
                            <svg class="form-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" width="20"><path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/><path fill-rule="evenodd" d="M4 5a2 2 0 012-2h8a2 2 0 012 2v12a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h4a1 1 0 100-2H7zm0 4a1 1 0 100 2h4a1 1 0 100-2H7z" clip-rule="evenodd"/></svg>
                            <select name="priority" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition-shadow shadow-sm">
                                <option value="Rendah" @selected(old('priority', 'Sedang') == 'Rendah')>Low</option>
                                <option value="Sedang" @selected(old('priority', 'Sedang') == 'Sedang')>Medium</option>
                                <option value="Tinggi" @selected(old('priority', 'Sedang') == 'Tinggi')>High</option>
                            </select>
                        </div>
                        <div class="input-with-icon">
                            <svg class="form-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" width="20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm.707-10.293a1 1 0 00-1.414-1.414l-3 3a1 1 0 001.414 1.414L10 9.414l.293.293a1 1 0 001.414-1.414l-1-1z" clip-rule="evenodd" /></svg>
                            <select name="reminder_offset" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition-shadow shadow-sm">
                                <option value="">No Reminder</option>
                                <option value="5" @selected(old('reminder_offset') == '5')>5 minutes before</option>
                                <option value="15" @selected(old('reminder_offset') == '15')>15 minutes before</option>
                                <option value="60" @selected(old('reminder_offset') == '60')>1 hour before</option>
                                <option value="1440" @selected(old('reminder_offset') == '1440')>1 day before</option>
                            </select>
                        </div>
                        <div class="sm:col-span-2">
                            <button type="submit" class="w-full bg-blue-600 text-white font-bold px-6 py-3 rounded-lg hover:bg-blue-700 transform hover:scale-105 transition-all shadow-lg flex items-center justify-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" /></svg>
                                Add Task
                            </button>
                        </div>
                    </div>
                    @if ($errors->any())
                        <div class="mt-4 text-red-600">
                            <ul class="list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </form>

                {{-- Filter Buttons --}}
                <div class="flex justify-center gap-3 mb-8">
                    <a href="{{ route('tasks.index', ['filter' => 'all']) }}" class="filter-btn px-5 py-2 rounded-full font-semibold transition-all {{ $filter == 'all' ? 'active' : 'bg-gray-200 text-gray-700' }}">All</a>
                    <a href="{{ route('tasks.index', ['filter' => 'pending']) }}" class="filter-btn px-5 py-2 rounded-full font-semibold transition-all {{ $filter == 'pending' ? 'active' : 'bg-gray-200 text-gray-700' }}">Pending</a>
                    <a href="{{ route('tasks.index', ['filter' => 'completed']) }}" class="filter-btn px-5 py-2 rounded-full font-semibold transition-all {{ $filter == 'completed' ? 'active' : 'bg-gray-200 text-gray-700' }}">Completed</a>
                </div>

                {{-- Task List --}}
                <div class="space-y-4">
                    @forelse ($tasks as $task)
                        <div class="task-item flex items-center justify-between p-4 rounded-xl shadow-md hover:shadow-lg transition-all {{ $task->card_class }} {{ $task->priority_class }}">
                            <div class="flex items-center flex-grow">
                                {{-- Checkbox Form for Completion --}}
                                <form action="{{ route('tasks.update', $task->id) }}" method="POST" class="mr-4">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="completed" value="0">
                                    <input type="checkbox" name="completed" value="1" {{ $task->completed ? 'checked' : '' }} onchange="this.form.submit()" class="h-6 w-6 text-blue-600 focus:ring-blue-500 border-gray-300 rounded-full cursor-pointer">
                                </form>
                                
                                {{-- Task Title and Deadline --}}
                                <div class="flex-grow">
                                    <span class="font-medium text-lg {{ $task->completed ? 'line-through text-gray-400' : 'text-gray-800' }}">{{ $task->title }}</span>
                                    @if ($task->deadline)
                                        <div class="text-sm text-gray-600 mt-1 flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.414-1.414L11 10.586V6z" clip-rule="evenodd" /></svg>
                                            <span class="font-semibold {{ $task->is_overdue ? 'text-red-600' : ($task->is_near_deadline ? 'text-yellow-700' : 'text-gray-600') }}" 
                                                  data-deadline="{{ $task->deadline->toISOString() }}">
                                                {{-- JS will populate this --}}
                                            </span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            
                            {{-- Priority Badge and Delete Button --}}
                            <div class="flex items-center gap-3 flex-shrink-0">
                                <span class="px-3 py-1 rounded-full text-sm font-semibold {{ $task->priority_badge_class }}">{{ $task->priority }}</span>
                                <form action="{{ route('tasks.destroy', $task->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-gray-400 hover:text-red-600 transition-colors" aria-label="Delete task">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-10 px-6 bg-gray-50 rounded-xl">
                            <svg class="mx-auto h-24 w-24 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path vector-effect="non-scaling-stroke" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <p class="mt-4 text-lg font-semibold text-gray-700">You're all caught up!</p>
                            <p class="text-gray-500">Looks like there's nothing on your to-do list.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    @auth
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            
            // --- Countdown Timer Engine ---
            function updateCountdowns() {
                document.querySelectorAll('[data-deadline]').forEach(element => {
                    const deadline = dayjs(element.dataset.deadline);
                    const now = dayjs();
                    if (deadline.isBefore(now)) {
                        element.textContent = 'Overdue';
                    } else {
                        element.textContent = dayjs().to(deadline);
                    }
                });
            }
            updateCountdowns();
            setInterval(updateCountdowns, 60000);

            // --- Notification Engine ---
            if ('Notification' in window) {
                const tasksWithReminders = {!! 
                    json_encode(
                        $tasks->where('completed', false)
                              ->whereNotNull('deadline')
                              ->whereNotNull('reminder_offset')
                              ->map(function($task) {
                                  return [
                                      'id' => $task->id,
                                      'title' => $task->title,
                                      'deadline' => $task->deadline ? $task->deadline->toISOString() : null,
                                      'reminderOffset' => $task->reminder_offset,
                                      'notified' => false
                                  ];
                              })
                              ->values()
                    ) 
                !!};

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
                                icon: 'https://cdn-icons-png.flaticon.com/512/109/109622.png'
                            });
                            task.notified = true;
                        }
                    });
                }

                if (Notification.permission !== 'denied') {
                    Notification.requestPermission();
                }

                setInterval(checkReminders, 30000);
            }
        });
    </script>
    @endauth
</x-app-layout>