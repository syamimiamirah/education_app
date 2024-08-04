<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Calendar') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                <form method="POST" action="{{ route('calendar.store') }}">
                @csrf
                    <div class="form-group">
                        <x-input-label for="title" :value="__('Title')" /> 
                        <input id="title" class="input-text block mt-1 w-full p-3 rounded-md" type="title" name="title" required autofocus/>
                    </div>
                    <div class="form-group mt-4">
                        <x-input-label for="description" :value="__('Description')" />
                        <textarea class="lined-textarea dark-textarea block mt-1 w-full p-3 rounded-md" id="description" name="description" required></textarea>
                    </div>
                    <div class="form-group mt-4">
                        <x-input-label for="start_date" :value="__('Start Date')" />
                        <input id="start_date" type="datetime-local" name="start_date" class="input-text block mt-1 w-full p-3 rounded-md" required />
                    </div>
                    <div class="form-group mt-4">
                        <x-input-label for="end_date" :value="__('End Date')" />
                        <input id="end_date" type="datetime-local" name="end_date" class="input-text block mt-1 w-full p-3 rounded-md" required />
                    </div>
                    <div class="form-group mt-4 relative">
                    <x-input-label for="status" :value="__('Status')" />
                    <button id="dropdownDefaultButton" type="button" class="flex items-center justify-between input-text text-white block mt-1 w-full p-3 rounded-md bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        <span id="statusLabel">Choose Status</span> <!-- Make sure this ID matches -->
                        <svg class="ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6" style="height: 8px; width: 8px;">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                        </svg>
                    </button>
                    <input type="hidden" id="status" name="status" value="">
                    <div id="dropdown" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700">
                        <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownDefaultButton">
                            <li>
                                <a href="#" data-value="Pending" class="dropdown block px-4 py-2 hover:bg-gray-600 dark:hover:bg-gray-600 dark:hover:text-white">Pending</a>
                            </li>
                            <!-- <li>
                                <a href="#" data-value="Completed" class="dropdown block px-4 py-2 hover:bg-gray-600 dark:hover:bg-gray-600 dark:hover:text-white">Completed</a>
                            </li> -->
                            <!-- Add more status options as needed -->
                        </ul>
                    </div>
                </div>

                    <div class="flex justify-end">
                        <x-primary-button type="submit" class="px-4 py-2 mt-3">{{__("Create Task")}}</x-primary-button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <style>
        .input-text{
            border: 1px solid #ccc;
            padding: 10px;
            width: 100%;
            background: #2d3748; /* Tailwind dark background color */
            color: white; /* White font color */
            border-radius: 0.375rem;
            font-family: 'Inter', sans-serif; /* Match the font family used by Tailwind */
            font-size: 1rem;
        }
        .lined-textarea {
            border: 1px solid #ccc;
            padding: 10px;
            width: 100%;
            height: 300px;
            font-family: 'Inter', sans-serif; /* Match the font family used by Tailwind */
            font-size: 1rem; /* Match the font size */
            background: repeating-linear-gradient(
                #2d3748, /* Tailwind dark background color */
                #2d3748 24px,
                #4a5568 27px /* Tailwind dark border color */
            );
            color: white; /* White font color */
            border-radius: 0.375rem; /* Border radius same as text input */
        }
        .dark-textarea {
            background-color: #2d3748; /* Tailwind dark background color */
            color: white;
            border-color: #4a5568; /* Tailwind dark border color */
        }
        .dropdown{
            padding: 10px;
            width: 100%;
            background: #2d3748; /* Tailwind dark background color */
            color: white; /* White font color */
            border-radius: 0.375rem;
            font-family: 'Inter', sans-serif; /* Match the font family used by Tailwind */
            font-size: 1rem;
        }
        </style>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
            const dropdownButton = document.getElementById('dropdownDefaultButton');
            const dropdown = document.getElementById('dropdown');
            const statusInput = document.getElementById('status');
            const statusLabel = document.getElementById('statusLabel'); // Ensure this ID matches

            if (!statusLabel) {
                console.error('Element with id "statusLabel" not found');
                return; // Stop further execution if statusLabel is not found
            }

            // Toggle dropdown visibility
            dropdownButton.addEventListener('click', function () {
                dropdown.classList.toggle('hidden');
            });

            // Handle dropdown item clicks
            dropdown.querySelectorAll('a').forEach(function (item) {
                item.addEventListener('click', function (e) {
                    e.preventDefault();
                    const selectedValue = this.getAttribute('data-value');
                    const selectedText = this.textContent;

                    // Update button text and hidden input value
                    statusLabel.textContent = selectedText;
                    statusInput.value = selectedValue;

                    // Hide the dropdown
                    dropdown.classList.add('hidden');
                });
            });

            // Hide the dropdown if clicking outside of it
            document.addEventListener('click', function (e) {
                if (!dropdownButton.contains(e.target) && !dropdown.contains(e.target)) {
                    dropdown.classList.add('hidden');
                }
            });
        });

        </script>

</x-app-layout>

