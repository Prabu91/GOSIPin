@props(['messages'])

@if ($messages)
    <ul {{ $attributes->merge(['class' => 'text-sm list-none mb-0 mt-2 text-red-500']) }}>
        @foreach ((array) $messages as $message)
            <li>{{ $message }}</li>
        @endforeach
    </ul>
@endif

