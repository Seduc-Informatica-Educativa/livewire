<div class="max-w-6xl mx-auto">
    <div class="flex justify-end p-2 m-2">
        <x-button wire:click="showPostModal">Create</x-button>
    </div>
    <div class="p-2 m-2">
        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                <div class="overflow-hidden border-b border-gray-200 shadow sm:rounded-lg">
                    <table class="w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50 dark:bg-gray-600 dark:text-gray-200">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-200">Id</th>
                                <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-200">Title</th>
                                <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-200">Image</th>
                                <th scope="col" class="relative px-6 py-3">Edit</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200 dark:divide-gray-700 dark:bg-gray-800">
                            <tr></tr>
                            @foreach ($posts as $post)                            
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $post->id }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $post->title }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <img src="{{ Storage::url($post->image)}}" alt="image" class="w-8 h-8 rounded-md">
                                </td>
                                <td class="px-6 py-4 text-sm text-rigth">
                                    <div class="flex space-x-2">
                                        <x-button wire:click="showEditPostModal({{$post->id}})">Edit</x-button>
                                        <x-button wire:click="deletePost({{$post->id}})" class="bg-red-400 hover:bg-red-600">Delete</x-button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="p-2 m-2">
                        Pagination
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div>
        <x-dialog-modal wire:model="showingPostModal">
            @if($isEditMode)
                <x-slot name="title">Update post</x-slot>
            @else
                <x-slot name="title">Create post</x-slot>
            @endif
            <x-slot name="content">
                <div class="w-full mt-10 space-y-8 divide-y divide-gray-200">
                    <form enctype="multipart/form-data">
                        <div class="sm:col-span-6">
                            <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                            <div class="mt-1">
                                <x-input type="text" id="title" wire:model.lazy="title" class="block w-full transition duration-150 ease-in-out bg-white border border-gray-400 appearance-none"/>
                            </div>
                            @error('title')<span class"text-red-400">{{ $message }}</span>@enderror
                        </div>
                        <div class="sm:col-span-6">
                            @if($oldImage)
                            <label for="title" class="block text-sm font-medium text-gray-700">Imagem Anterior</label>
                                <img src="{{ Storage::url($oldImage) }}" alt="image" class="w-20 h-20 rounded-md">
                            @endif
                            @if($newImage)
                            <label for="title" class="block text-sm font-medium text-gray-700">Imagem</label>
                                <img src="{{ $newImage->temporaryUrl() }}" alt="image" class="w-20 h-20 rounded-md">
                            @endif
                            <div class="mt-4">
                                <x-input type="file" id="title" wire:model="newImage" class="block w-full transition duration-150 ease-in-out bg-white border border-gray-400 appearance-none" />
                            </div>
                            @error('newImage')<span class"text-red-400">{{ $message }}</span>@enderror
                        </div>
                        <div class="sm:col-span-6">
                            <label for="title" class="block text-sm font-medium text-gray-700">Body</label>
                            <div class="mt-1">
                                <textarea id="body"  rows="3" wire:model.lazy="body" class="w-full bg-white border border-gray-400 shadow-sm appearance-none focus:ring-indigo-500" autocomplete="body"></textarea>
                            </div>
                            @error('body')<span class"text-red-400">{{ $message }}</span>@enderror
                        </div>
                    </form>
                </div>
            </x-slot>            
            <x-slot name="footer">
                @if($isEditMode)
                    <x-button wire:click="updatePost">Update</x-button>
                @else
                    <x-button wire:click="storePost">Create</x-button>
                @endif
            </x-slot>
        </x-dialog-modal>
    </div>
</div>
