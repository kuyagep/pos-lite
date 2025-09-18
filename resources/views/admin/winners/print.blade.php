<!DOCTYPE html>
<html>

<head>
    <title>Raffle Winners</title>
    <style>
        @page {
            size: A4 landscape;
            margin: 15mm;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 11pt;
            padding: 0;
            margin: 0;
        }

        h3 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 14pt;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            page-break-inside: auto;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 6px;
            text-align: left;
        }

        th {
            background: #f8f9fa;
        }

        tr {
            page-break-inside: avoid;
            page-break-after: auto;
        }

        /* Page header/footer */
        @media print {
            body {
                -webkit-print-color-adjust: exact;
            }

            thead {
                display: table-header-group;
            }

            tfoot {
                display: table-footer-group;
            }

            /* Page numbering */
            @page {
                @bottom-right {
                    content: "Page " counter(page) " of " counter(pages);
                    font-size: 10pt;
                    font-family: Arial, sans-serif;
                }
            }
        }
    </style>
</head>

<body onload="window.print()">
    <h3>Raffle Winners</h3>
    <table>
        <thead>
            <tr>
                <th>Participant</th>
                <th>Prize</th>
                <th>Drawn At</th>
                <th>Signature</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($winners as $winner)
                <tr>
                    <td>{{ $winner->participant->full_name }}</td>
                    <td>{{ $winner->prize->name }}</td>
                    <td>{{ $winner->created_at->format('M d, Y h:i A') }}</td>
                    <td></td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <script>
        // Redirect back to winners index after printing
        // window.onafterprint = function() {
        //     window.location.href = "{{ route('admin.winners.index') }}";
        // };

        // Close the tab after printing or canceling print
         window.onafterprint = function() {
            if (window.opener) {
                // Call parent window function if available
                window.opener.postMessage({ action: "unselectCheckboxes" }, "*");
            }
            window.close();
        };
    </script>
</body>

</html>
