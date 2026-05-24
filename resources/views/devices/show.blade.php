<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Network Devices
        </h2>
    </x-slot>
<div class="py-12">
    <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">

                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-800">Device Details</h2>
                    <div class="flex gap-3">
                        <a href="{{ route('devices.edit', $device) }}"
                           class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">
                            Edit
                        </a>
                        <form action="{{ route('devices.destroy', $device) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700"
                                    onclick="return confirm('Delete this device?')">
                                Delete
                            </button>
                        </form>
                    </div>
                </div>

                <table class="w-full text-left border-collapse">
                    <tbody>
                        <tr class="border-b">
                            <td class="py-3 pr-6 font-medium text-gray-600 w-1/3">Device Name</td>
                            <td class="py-3 text-gray-800">{{ $device->name }}</td>
                        </tr>
                        <tr class="border-b">
                            <td class="py-3 pr-6 font-medium text-gray-600">IP Address</td>
                            <td class="py-3 text-gray-800">{{ $device->ip_address }}</td>
                        </tr>
                        <tr class="border-b">
                            <td class="py-3 pr-6 font-medium text-gray-600">Device Type</td>
                            <td class="py-3 text-gray-800">{{ $device->device_type }}</td>
                        </tr>
                        <tr class="border-b">
                            <td class="py-3 pr-6 font-medium text-gray-600">Location</td>
                            <td class="py-3 text-gray-800">{{ $device->location }}</td>
                        </tr>
                        <tr class="border-b">
                            <td class="py-3 pr-6 font-medium text-gray-600">Status</td>
                            <td class="py-3 text-gray-800">{{ $device->status }}</td>
                        </tr>
                        <tr class="border-b">
                            <td class="py-3 pr-6 font-medium text-gray-600">Created At</td>
                            <td class="py-3 text-gray-800">{{ $device->created_at->format('d M Y, H:i') }}</td>
                        </tr>
                        <tr>
                            <td class="py-3 pr-6 font-medium text-gray-600">Last Updated</td>
                            <td class="py-3 text-gray-800">{{ $device->updated_at->format('d M Y, H:i') }}</td>
                        </tr>
                    </tbody>
                </table>

                <div class="mt-6">
                    <a href="{{ route('devices.index') }}" class="text-gray-600 hover:underline">
                        ← Back to Devices
                    </a>
                </div>

            </div>
        </div>
    </div>
</div>
</x-app-layout>