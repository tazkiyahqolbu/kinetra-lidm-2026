<div class="bg-white rounded-xl shadow-lg overflow-hidden">
    <table class="w-full">
        <thead class="bg-gradient-to-r from-blue-600 to-blue-800 text-white">
            <tr>
                {{ $header }}
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            {{ $slot }}
        </tbody>
    </table>
</div>
