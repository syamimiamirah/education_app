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
                    <form method="POST" action="{{ route('notes.update', $note->id) }}">
                        @csrf
                        @method('PATCH')
                        <div class="mb-4">
                            <!--<label for="title" class="block text-gray-700 dark:text-gray-300">Title</label>-->
                            <x-input-label for="title" :value="__('Title')" />
                            <input type="text" name="title" id="title" value="{{ $note->title }}" class="input-text block mt-1 w-full p-3 rounded-md">
                        </div>
                        <div class="mb-4">
                            <!--<label for="content" class="block text-gray-700 dark:text-gray-300">Content</label>-->
                            <x-input-label for="content" :value="__('Content')" />
                            <textarea name="content" id="content" class="lined-textarea dark-textarea block mt-1 w-full p-3 rounded-md">{{ $note->content }}</textarea>
                        </div>
                        <div class="flex justify-end">
                        <x-primary-button type="submit" class="px-4 py-2 mt-3">{{__("Update Note")}}</x-primary-button>
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
    </style>
</x-app-layout>