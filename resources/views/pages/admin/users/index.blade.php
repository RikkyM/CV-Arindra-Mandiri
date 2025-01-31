<x-layouts.admin title="Users">
    <a href="{{ route('add-user') }}" class="my-5 block w-max rounded-sm bg-green-500 p-2 font-bold text-white">Tambah
        User</a>
    <table class="h-max w-full bg-white">
        <thead class="bg-black text-white">
            <tr class="text-left *:py-3">
                <th class="text-center">No.</th>
                <th>Nama</th>
                <th>Role</th>
                <th class="text-center">Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                @if ($user->role !== 'admin')
                    <tr class="text-left *:py-2">
                        <td class="text-center">{{ $loop->index }}</td>
                        <td>{{ $user->name }}</td>
                        <td class="capitalize">{{ $user->role }}</td>
                        <td class="capitalize">
                            <div
                                class="{{ $user->status_akun !== 'inactive' ? 'text-green-500' : 'text-red-500' }} flex items-center justify-center font-semibold">
                                {{ $user->status_akun }}</div>
                        </td>
                        <td class="flex flex-col">
                            @if ($user->status_akun === 'inactive')
                                <a href="{{ route('change_status_user', ['id' => $user->id]) }}"
                                    class="text-blue-500">Aktifkan</a>
                            @else
                                <a href="{{ route('change_status_user', ['id' => $user->id]) }}"
                                    class="text-blue-500">Nonaktifkan</a>
                            @endif
                        </td>
                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>
</x-layouts.admin>
