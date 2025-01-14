

<section>
    <header>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            List postingan
        </h2>
    </header>

    <div class="mt-6 bg-white shadow-sm rounded-lg divide-y">
        @foreach ($postingan as $postingans)
            <div class="p-6 flex space-x-2 ">  
                <div class="flex-1">
                    <div class="flex justify-between items-center">
                        <div>
                            <small class="ml-2 text-sm text-gray-600">{{ $postingans->created_at }}</small>
                        </div>
                        @if ($postingans->deskripsi)
                            <x-dropdown>
                                <x-slot name="trigger">
                                    <button>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                        </svg>
                                    </button>
                                </x-slot>
                                <x-slot name="content">
                                    <form method="POST" action="{{ route('posting.editView') }}">
                                        <x-text-input type="hidden" value="{{ $postingans->id }}" name="posting_id"></x-text-input>
                                        <x-text-input type="hidden" value="{{ $proker->id }}" name="proker_id"></x-text-input>
                                        {{ csrf_field() }}
                                        <x-dropdown-link onclick="event.preventDefault(); this.closest('form').submit();">
                                            {{ __('Edit') }}
                                        </x-dropdown-link>  
                                    </form>
                                    <form method="POST" action="{{ route('posting.delete') }}">
                                        <x-text-input type="hidden" value="{{ $postingans->id }}" name="posting_id"></x-text-input>
                                        <x-text-input type="hidden" value="{{ $proker->id }}" name="proker_id"></x-text-input>
                                        {{ csrf_field() }}
                                        @method('delete')
                                        <x-dropdown-link onclick="event.preventDefault(); this.closest('form').submit();">
                                            {{ __('Delete') }}
                                        </x-dropdown-link>
                                    </form>
                                </x-slot>
                            </x-dropdown>
                        @endif
                    </div>
                    <p>{{ __($postingans->deskripsi) }}</p>
                </div>
            </div>
        @endforeach
    </div>
</section>