@props([
    'headers' => []
])

<div class="overflow-x-auto rounded-xl border border-slate-200 shadow-sm bg-white">
    <table {{ $attributes->merge(['class' => 'min-w-full divide-y divide-slate-200']) }}>
        <thead class="bg-slate-50">
            <tr>
                @foreach($headers as $header)
                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">
                        {{ $header }}
                    </th>
                @endforeach
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-slate-100">
            {{ $slot }}
        </tbody>
    </table>
</div>
