<x-app-layout>
<x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Notes') }}
        </h2>
</x-slot>

<div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                    <form method="POST" action="{{ route('notes.store') }}">
                        @csrf
                        <div class="form-group">
                        <x-input-label for="title" :value="__('Title')" />
                        <input id="title" class="input-text block mt-1 w-full p-3 rounded-md" type="title" name="title" required autofocus/>
                        </div>
                        <div class="form-group mt-4">
                        <x-input-label for="content" :value="__('Content')" />
                        <textarea class="lined-textarea dark-textarea block mt-1 w-full p-3 rounded-md" id="content" name="content" required></textarea>
                        </div>
                        <div class="flex justify-end">
                        <x-primary-button type="submit" class="px-4 py-2 mt-3">{{__("Create Note")}}</x-primary-button>
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
                #4a5568 25px /* Tailwind dark border color */
            );
            color: white; /* White font color */
            border-radius: 0.375rem; /* Border radius same as text input */
        }
        .dark-textarea {
            background-color: #2d3748; /* Tailwind dark background color */
            color: white;
            border-color: #4a5568; /* Tailwind dark border color */
        }
    </style>

</x-app-layout>

