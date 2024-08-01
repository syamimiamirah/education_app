<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Pomodoro') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">

                    <!-- Task Management Section -->
                    <div class="mb-8">
                        <h3 class="text-2xl font-semibold text-gray-800 dark:text-gray-200 mb-4">Today's Tasks</h3>
                        <form id="task-form" class="mb-6">
                            <div class="flex space-x-4">
                                <input id="task-name" type="text" placeholder="Task Name" class="flex-1 p-3 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm" required>
                                <input id="task-pomodoros" type="number" placeholder="Pomodoros" class="w-32 p-3 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm" min="1" required>
                                <x-primary-button type="button" onclick="addTask()">Add Task</x-primary-button>
                            </div>
                        </form>
                        <div id="task-list" class="space-y-4">
                            <!-- Tasks will be appended here -->
                        </div>
                    </div>

                    <!-- Timer Section -->
                    <div class="text-center mb-8">
                        <h3 class="text-4xl font-bold text-gray-800 dark:text-gray-200 mb-6" id="timer">25:00</h3>
                        <div class="flex justify-center mb-4">
                            <x-primary-button type="button" onclick="startTimer()" class="mr-4">Start</x-primary-button>
                            <x-secondary-button type="button" onclick="resetTimer()">Reset</x-secondary-button>
                        </div>
                    </div>

                    <!-- Breaks Section -->
                    <div class="text-center">
                        <h4 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4">Break Time</h4>
                        <div class="flex justify-center">
                            <x-primary-button type="button" onclick="setShortBreak()" class="mr-4">Short Break (5 mins)</x-primary-button>
                            <x-primary-button type="button" onclick="setLongBreak()">Long Break (15 mins)</x-primary-button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script>
        let timerInterval;
        let timeLeft = 25 * 60;
        let isBreak = false;

        function formatTime(seconds) {
            const minutes = Math.floor(seconds / 60);
            const secs = seconds % 60;
            return `${minutes.toString().padStart(2, '0')}:${secs.toString().padStart(2, '0')}`;
        }

        function updateTimerDisplay() {
            document.getElementById('timer').innerText = formatTime(timeLeft);
        }

        function startTimer() {
            if (timerInterval) clearInterval(timerInterval);
            timerInterval = setInterval(() => {
                timeLeft--;
                updateTimerDisplay();
                if (timeLeft <= 0) {
                    clearInterval(timerInterval);
                    alert('Time is up!');
                }
            }, 1000);
        }

        function resetTimer() {
            if (timerInterval) clearInterval(timerInterval);
            timeLeft = 25 * 60;
            updateTimerDisplay();
        }

        function setShortBreak() {
            if (timerInterval) clearInterval(timerInterval);
            timeLeft = 5 * 60;
            isBreak = true;
            updateTimerDisplay();
            startTimer();
        }

        function setLongBreak() {
            if (timerInterval) clearInterval(timerInterval);
            timeLeft = 15 * 60;
            isBreak = true;
            updateTimerDisplay();
            startTimer();
        }

        function addTask() {
            const taskName = document.getElementById('task-name').value;
            const taskPomodoros = document.getElementById('task-pomodoros').value;

            if (taskName && taskPomodoros > 0) {
                const taskList = document.getElementById('task-list');
                const listItem = document.createElement('div');
                listItem.classList.add('bg-gray-100', 'dark:bg-gray-700', 'p-4', 'rounded-md', 'shadow-lg', 'flex', 'items-center', 'justify-between');
                listItem.innerHTML = `
                    <div>
                        <h4 class="text-lg font-semibold text-gray-800 dark:text-gray-200">${taskName}</h4>
                        <p class="text-sm text-gray-600 dark:text-gray-400">${taskPomodoros} Pomodoros</p>
                    </div>
                    <button onclick="removeTask(this)" class="text-red-500 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12H9m6 0a1.5 1.5 0 0 1-1.5 1.5A1.5 1.5 0 0 1 12 12a1.5 1.5 0 0 1 1.5-1.5A1.5 1.5 0 0 1 15 12zM15 12a1.5 1.5 0 0 1-1.5 1.5A1.5 1.5 0 0 1 12 12a1.5 1.5 0 0 1 1.5-1.5A1.5 1.5 0 0 1 15 12zM12 15a1.5 1.5 0 0 1 1.5 1.5A1.5 1.5 0 0 1 12 18a1.5 1.5 0 0 1-1.5-1.5A1.5 1.5 0 0 1 12 15zM12 15a1.5 1.5 0 0 1 1.5 1.5A1.5 1.5 0 0 1 12 18a1.5 1.5 0 0 1-1.5-1.5A1.5 1.5 0 0 1 12 15z" />
                        </svg>
                    </button>
                `;
                taskList.appendChild(listItem);

                document.getElementById('task-form').reset();
            } else {
                alert('Please enter a valid task and pomodoros count.');
            }
        }

        function removeTask(button) {
            button.parentElement.remove();
        }

        document.addEventListener('DOMContentLoaded', () => {
            updateTimerDisplay();
        });
    </script>
</x-app-layout>
