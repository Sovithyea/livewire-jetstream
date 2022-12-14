<div class="p-6">
    <div class="flex items-center justify-end px-4 py-3 text-right sm:px-6">
        <x-jet-button wire:click="createShowModal">
            {{__('Create')}}
        </x-jet-button>
    </div>

    <table class="w-full divide-y divide-gray-200">
        <thead>
            <tr>
                <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">ID</th>
                <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Title</th>
                <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Link</th>
                <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Content</th>
                <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Actions</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @if ($data->count())
                @foreach ($data as $item)
                    <tr>
                        <td class="px-6 py-4 text-sm whitespace-nowrap">{{$item->id}}</td>
                        <td class="px-6 py-4 text-sm whitespace-nowrap">{{$item->title}}</td>
                        <td class="px-6 py-4 text-sm whitespace-nowrap">
                            <a
                                class="text-indigo-600 hover:text-indigo-900"
                                target="_blank"
                                href="{{URL::to('/'.$item->slug)}}"
                            >
                                {{$item->slug}}
                            </a>
                        </td>
                        <td class="px-6 py-4 text-sm whitespace-nowrap">{!!$item->content!!}</td>
                        <td class="px-6 py-4 text-sm text-right">
                            <x-jet-button wire:click="updateShowModal({{$item->id}})">
                                {{__('Update')}}
                            </x-jet-button>
                            <x-jet-danger-button wire:click="deleteShowModal({{$item->id}})">
                                {{__('Delete')}}
                            </x-jet-danger-button>
                        </td>
                    </tr>
                @endforeach
            @else
                    <tr>
                        <td class="px-6 py-4 text-sm whitespace-nowrap" colspan="4">No result found</td>
                    </tr>
            @endif

        </tbody>
    </table>
    {{$data->links()}}
    <x-jet-dialog-modal wire:model="modelFormVisible">
        <x-slot name="title">
            {{ __('Save Page') }} {{$modelId}}
        </x-slot>

        <x-slot name="content">
            Please Fills Below To Create Page...
            <div class="mt-4">
                <x-jet-label for="title" value="{{ __('Title') }}" />
                <x-jet-input id="title" class="block mt-1 w-full" type="text" wire:model.debounce.800ms="title" />
                @error('title')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>
            <div class="mt-4">
                <x-jet-label for="slug" value="{{ __('Slug') }}" />
                <div class="mt-1 flex rounded-md shadow-sm">
                    <span class="inline-flex items-center px-3 rounded-1-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">
                        http://localhost:8000/
                    </span>
                    <input type="text" placeholder="url-slug" wire:model="slug" class="form-input flex-1 block w-full rounded-none rounded-r-md transition duration-150 ease-in-out sm:text-sm sm:leading-5">
                </div>
                @error('slug')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>
            <div class="mt-4">
                <x-jet-label for="content" value="{{ __('Content') }}" />
                <div class="rounded-md shadow-sm">
                    <div class="mt-1 bg-white">
                        <div class="body-content" wire:ignore>
                            <trix-editor
                                class="trix-content"
                                x-ref="trix"
                                wire:model.debounce.100000ms='content'
                                wire:key="trix-content-unique-key"
                            ></trix-editor>
                        </div>
                    </div>
                </div>
                @error('content')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('modelFormVisible')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-jet-secondary-button>

            @if ($modelId)
                <x-jet-button class="ml-3" wire:click="update" wire:loading.attr="disabled">
                    {{ __('Update') }}
                </x-jet-button>
            @else
                <x-jet-button class="ml-3" wire:click="create" wire:loading.attr="disabled">
                    {{ __('Save') }}
                </x-jet-button>
            @endif

        </x-slot>
    </x-jet-dialog-modal>

    <x-jet-dialog-modal wire:model="modalConfirmDelete">
        <x-slot name="title">
            {{ __('Delete Page') }}
        </x-slot>

        <x-slot name="content">
            {{ __('Are you sure you want to delete your page? Once page is deleted.') }}
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('modalConfirmDelete')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-jet-secondary-button>

            <x-jet-danger-button class="ml-3" wire:click="delete({{$modelId}})" wire:loading.attr="disabled">
                {{ __('Delete') }}
            </x-jet-danger-button>
        </x-slot>
    </x-jet-dialog-modal>
</div>
