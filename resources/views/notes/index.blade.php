<x-app-layout>
<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Notes') }}
    </h2>
</x-slot>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="flex justify-between">
            <!-- Sidebar -->
            <div class="w-1/4 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex justify-start mb-4">
                        <a href="{{ route('notes.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-gray rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                            {{ __("Create New Note") }}
                        </a>
                    </div>
                    <h3 class="font-semibold text-lg text-gray-800 dark:text-gray-200 leading-tight mb-4">Your Notes</h3>
                    <ul id="note-list">
                        @foreach ($groupedNotes as $category => $notes)
                            <li class="font-bold text-sm text-gray-500 mb-4">{{ $category }}</li>
                            @foreach ($notes as $note)
                                <li class="mb-2 p-2 hover:bg-gray-200 dark:hover:bg-gray-700 rounded-md text-white" data-note-id="{{ $note->id }}">
                                    {{ $note->title }}
                                </li>
                            @endforeach
                        @endforeach
                    </ul>
                </div>
            </div>

            <!-- Main Content -->
            <div class="w-3/4 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg ml-4">
                <div id="note-content" class="p-6 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                    @isset($selectedNote)
                        <h3 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">{{ $selectedNote->title }}</h3>
                        <p class="mt-4 text-gray-600 dark:text-gray-400">{{ $selectedNote->content }}</p>
                    @else
                        <h3 class="font-semibold text-lg text-gray-800 dark:text-gray-200 leading-tight">Select a note to view</h3>
                    @endisset
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Add event listeners to note list items
        document.querySelectorAll('#note-list li').forEach(item => {
            item.addEventListener('click', function() {
                const noteId = this.getAttribute('data-note-id');
                fetchNoteContent(noteId);
            });
        });

        function fetchNoteContent(noteId) {
            fetch('{{ route('notes.show') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                body: JSON.stringify({ note_id: noteId }),
            })
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    document.getElementById('note-content').innerHTML = `<p class="text-red-500">${data.error}</p>`;
                } else {
                    document.getElementById('note-content').innerHTML = `
                        <h3 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">${data.title}</h3>
                        <p class="mt-4 text-gray-600 dark:text-gray-400">${data.content}</p>
                    `;
                }
            })
            .catch(error => console.error('Error fetching note:', error));
        }
    });
</script>
</x-app-layout>
