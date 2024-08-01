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

                    @if (session('success'))
                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                alert('{{ session('success') }}');
                            });
                        </script>
                    @endif
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
                                <li class="relative flex items-center justify-between mt-2 p-2 hover: cursor-pointer hover:bg-gray-200 dark:hover:bg-gray-700 hover: rounded-md text-white note-item" data-note-id="{{ $note->id }}">
                                    <span class="flex-1">{{ $note->title }}</span>
                                    <div class="relative">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 cursor-pointer" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" onclick="toggleDropdown(event)">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                        </svg>

                                        <div class="fixed right-0 mt-2 w-36 bg-white dark:bg-gray-900 border border-gray rounded-md shadow-lg z-30 hidden dropdown-menu">
                                            <a href="#" class="flex items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-200 dark:hover:bg-gray-700" onclick="deleteNote('{{ $note->id }}')">
                                                <!-- <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 pl-0 text-red-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#b91c1c">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                                </svg> -->
                                                <span class="" style="font-weight: 600; color: #b91c1c;">DELETE NOTE</span>
                                            </a>
                                        </div>
                                    </div>
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
                            <div class="flex justify-end mb-4">
                                <a href="{{ route('notes.edit', $selectedNote->id) }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-gray rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                                    {{ __("Edit Note") }}
                                </a>
                            </div>
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
            const noteItems = document.querySelectorAll('#note-list .note-item');
            
            // Add event listeners to note list items
            noteItems.forEach(item => {
                item.addEventListener('click', function() {
                    const noteId = this.getAttribute('data-note-id');
                    
                    // Remove 'active' class from all items
                    noteItems.forEach(i => i.classList.remove('bg-gray-300', 'dark:bg-gray-600', 'text-gray-900', 'dark:text-gray-100'));
                    
                    // Add 'active' class to the clicked item
                    this.classList.add('bg-gray-300', 'dark:bg-gray-600', 'text-gray-900', 'dark:text-gray-100');

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
                        document.getElementById('note-content').innerHTML = `<h3 class="font-semibold text-lg text-gray-800 dark:text-gray-200 leading-tight">Select a note to view</h3>`;
                    } else {
                        const editUrl = `{{ route('notes.edit', ':id') }}`.replace(':id', noteId);

                        document.getElementById('note-content').innerHTML = `
                            <div class="flex justify-end mb-4">
                                <a href="${editUrl}" class="inline-flex items-center px-4 py-2 bg-blue-500 border border-blue-600 rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-400 active:bg-blue-600 focus:outline-none focus:border-blue-700 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                                    Edit Note
                                </a>
                            </div>
                            <h3 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">${data.title}</h3>
                            <p class="mt-4 text-gray-600 dark:text-gray-400">${data.content}</p>
                        `;
                    }
                })
                .catch(error => console.error('Error fetching note:', error));
            }
        });

        function toggleDropdown(event) {
            event.stopPropagation();
            const dropdown = event.currentTarget.nextElementSibling;
            dropdown.classList.toggle('hidden');
        }

        function renameNote(noteId) {
            // Implement the rename note functionality
            console.log(`Rename note: ${noteId}`);
        }

        function deleteNote(noteId) {
            if (confirm('Are you sure you want to delete this note?')) {
                fetch(`/notes/${noteId}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                    // Remove the note from the UI
                    document.querySelector(`.note-item[data-note-id="${noteId}"]`).remove();
                    
                    // Clear the note content display area
                    //document.getElementById('note-content').innerHTML = `<p class="text-gray-600 dark:text-gray-400">Note has been deleted. Please select another note.</p>`;
                    
                    alert(data.success);
                } else {
                    alert('Error deleting note');
                }
                    })
                .catch(error => console.error('Error deleting note:', error));
            }
        }


        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            document.querySelectorAll('.dropdown-menu').forEach(menu => {
                if (!menu.classList.contains('hidden')) {
                    menu.classList.add('hidden');
                }
            });
        });
    </script>
</x-app-layout>
