<x-layouts.admin title="Users">
    <table class="h-max w-full bg-white">
        <thead class="bg-black text-white">
            <tr class="text-left *:py-3">
                <th class="text-center">No.</th>
                <th>Nama</th>
                <th>E-Mail</th>
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
                        <td>{{ $user->email }}</td>
                        <td class="capitalize">{{ $user->role }}</td>
                        <td class="capitalize"><div class="{{ $user->status_akun !== 'inactive' ? 'text-green-500' : 'text-red-500' }} flex items-center justify-center font-semibold">{{ $user->status_akun }}</div></td>
                        <td class="flex flex-col">
                            <a href="{{ route('users.activate', ['id' => $user->id]) }}" class="text-green-500">Aktifkan</a>
                            <a href="{{ route('users.deactivate', ['id' => $user->id]) }}" class="text-red-500">Nonaktifkan</a>
                        </td>
                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>
</x-layouts.admin>
