<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Admin: Pending Requests</h2>
    </x-slot>

    <div class="py-8 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow rounded-lg p-6">
            <table class="w-full text-sm">
                <thead><tr class="text-left border-b"><th class="py-2">Student</th><th class="py-2">Type</th><th class="py-2">Current Step</th><th class="py-2">Action</th></tr></thead>
                <tbody>
                    @foreach($requests as $req)
                        <tr class="border-b">
                            <td class="py-2">{{ $req->student->full_name }} ({{ $req->student->reg_no }})</td>
                            <td class="py-2 uppercase">{{ $req->type }}</td>
                            <td class="py-2"><span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded">{{ strtoupper($req->current_step) }}</span></td>
                            <td class="py-2 flex gap-2">
                                <form action="{{ route('admin.requests.process', $req) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="decision" value="approved">
                                    <button type="submit" class="bg-green-600 text-white px-3 py-1 rounded text-xs hover:bg-green-700">Approve Step</button>
                                </form>
                                <form action="{{ route('admin.requests.process', $req) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="decision" value="rejected">
                                    <button type="submit" class="bg-red-600 text-white px-3 py-1 rounded text-xs hover:bg-red-700">Reject</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>