<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Selamat Datang, {{ auth()->user()->nama_depan }}!</h3>
                    <p class="mb-4">Anda login sebagai <span class="font-bold text-blue-600">Admin</span></p>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-6">
                        <div class="bg-blue-50 p-4 rounded-lg">
                            <h4 class="font-semibold text-blue-800">Menu Admin</h4>
                            <ul class="mt-2 space-y-2">
                                <li><a href="#" class="text-blue-600 hover:underline">Kelola Data Anggota</a></li>
                                <li><a href="#" class="text-blue-600 hover:underline">Kelola Komponen Gaji</a></li>
                                <li><a href="#" class="text-blue-600 hover:underline">Kelola Penggajian</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>