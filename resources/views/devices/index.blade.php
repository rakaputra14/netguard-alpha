<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Network Devices
        </h2>
    </x-slot>
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">

                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-800">Devices Tables</h2>
                    <a href="{{ route('devices.create') }}"
                       class="bg-blue-600 text-black px-4 py-2 rounded hover:bg-blue-700">
                        + Add Device
                    </a>
                </div>

                @if(session('success'))
                    <div class="bg-green-100 text-green-800 px-4 py-3 rounded mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="p-3 border">Name</th>
                            <th class="p-3 border">IP Address</th>
                            <th class="p-3 border">Type</th>
                            <th class="p-3 border">Location</th>
                            <th class="p-3 border">Status</th>
                            <th class="p-3 border">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($devices as $device)
                        <tr class="hover:bg-gray-50">
                            <td class="p-3 border">{{ $device->name }}</td>
                            <td class="p-3 border">{{ $device->ip_address }}</td>
                            <td class="p-3 border">{{ $device->device_type }}</td>
                            <td class="p-3 border">{{ $device->location }}</td>
                            <td class="p-3 border">{{ $device->status }}</td>
                            <td class="p-3 border flex justify-center items-center">
                                <a href="{{ route('devices.edit', $device) }}"
                                   class="text-yellow-600 hover:underline mr-2">Edit</a>
                                <form action="{{ route('devices.destroy', $device) }}"
                                      method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="text-red-600 hover:underline"
                                            onclick="return confirm('Delete this device?')">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="p-3 text-center text-gray-500">
                                No devices found. Add one above.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>
</x-app-layout>