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

                <h2 class="text-2xl font-bold text-gray-800 mb-6">Edit Device</h2>

                <form method="POST" action="{{ route('devices.update', $device) }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-1">Device Name</label>
                        <input type="text" name="name" value="{{ old('name', $device->name) }}"
                               class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-400">
                        @error('name')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-1">IP Address</label>
                        <input type="text" name="ip_address" value="{{ old('ip_address', $device->ip_address) }}"
                               class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-400">
                        @error('ip_address')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-1">Device Type</label>
                        <select name="device_type"
                                class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-400">
                            <option value="">-- Select Type --</option>
                            <option value="Router"   {{ old('device_type', $device->device_type) == 'Router'   ? 'selected' : '' }}>Router</option>
                            <option value="Switch"   {{ old('device_type', $device->device_type) == 'Switch'   ? 'selected' : '' }}>Switch</option>
                            <option value="AP"       {{ old('device_type', $device->device_type) == 'AP'       ? 'selected' : '' }}>Access Point</option>
                            <option value="Firewall" {{ old('device_type', $device->device_type) == 'Firewall' ? 'selected' : '' }}>Firewall</option>
                        </select>
                        @error('device_type')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-1">Location</label>
                        <input type="text" name="location" value="{{ old('location', $device->location) }}"
                               class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-400">
                        @error('location')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label class="block text-gray-700 font-medium mb-1">Status</label>
                        <select name="status"
                                class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-400">
                            <option value="">-- Select Status --</option>
                            <option value="Active"   {{ old('status', $device->status) == 'Active'   ? 'selected' : '' }}>Active</option>
                            <option value="Inactive" {{ old('status', $device->status) == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                        @error('status')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center gap-4">
                        <button type="submit"
                                class="bg-yellow-500 text-black px-6 py-2 rounded hover:bg-yellow-600">
                            Update Device
                        </button>
                        <a href="{{ route('devices.index') }}" class="text-gray-600 hover:underline">
                            Cancel
                        </a>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>
</x-app-layout>