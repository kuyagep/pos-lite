@extends('layouts.admin')

@section('content')
    <!-- Page Heading -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800"><i class="fas fa-trophy"></i> Raffle Winners</h1>
        <button onclick="printSelected()" class="btn btn-deped">
            <i class="fas fa-print"></i> Print Selected
        </button>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <table class="table table-striped ">
                <thead class="bg-theme">
                    <tr>
                        <th><input type="checkbox" id="selectAll"></th>
                        <th>Prize</th>
                        <th>Winner Name</th>
                        <th>Employment Type</th>
                        <th>School / Office</th>
                        <th>Won At</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($winners as $winner)
                        <tr>
                            <td>
                                <input type="checkbox" class="rowCheckbox" value="{{ $winner->id }}"
                                    {{ in_array($winner->id, session('selected_winners', [])) ? 'checked' : '' }}>
                            </td>
                            <td>{{ $winner->prize->name }}</td>
                            <td>{{ $winner->participant->full_name }}</td>
                            <td>{{ $winner->participant->employment_type }}</td>
                            <td>{{ $winner->participant->school_office }}</td>
                            <td>{{ $winner->created_at->format('M d, Y h:i A') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        let selectedWinners = @json(session('selected_winners', []));

        // Checkbox toggle
        document.querySelectorAll(".rowCheckbox").forEach(cb => {
            cb.addEventListener("change", function() {
                let id = this.value;
                if (this.checked) {
                    if (!selectedWinners.includes(id)) {
                        selectedWinners.push(id);
                    }
                } else {
                    selectedWinners = selectedWinners.filter(w => w !== id);
                }

                // Store in session (AJAX)
                fetch("{{ route('admin.winners.updateSelection') }}", {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                        "Content-Type": "application/json",
                    },
                    body: JSON.stringify({
                        selected: selectedWinners
                    })
                });
            });
        });

        // Select All
        document.getElementById("selectAll").addEventListener("change", function() {
            document.querySelectorAll(".rowCheckbox").forEach(cb => {
                cb.checked = this.checked;
                cb.dispatchEvent(new Event("change"));
            });
        });

        function printSelected() {
            if (selectedWinners.length === 0) {
                Swal.fire("No Selection", "Please select at least one winner to print.", "warning");
                return;
            }

            // Redirect to print route with selected IDs
            let url = "{{ route('admin.winners.print') }}?ids=" + selectedWinners.join(",");
            window.open(url, "_blank");
        }

        // On page reload, force uncheck & clear session
        window.addEventListener("load", function() {
            fetch("{{ route('admin.winners.resetSelection') }}", {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    "Content-Type": "application/json"
                }
            }).then(() => {
                // Uncheck all
                document.querySelectorAll(".rowCheckbox").forEach(cb => cb.checked = false);
                let selectAll = document.getElementById("selectAll");
                if (selectAll) selectAll.checked = false;
                selectedWinners = [];
            });
        });
    </script>
@endpush
