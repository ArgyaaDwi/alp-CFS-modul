<!DOCTYPE html>
<html>

<head>
    <title>Laporan Feedback Baru</title>
</head>

<body>
    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color: #ffffff; padding: 20px 0;">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0" border="0"
                    style="background-color: #ffffff; border-radius: 8px; overflow: hidden; border: 1px solid rgba(0, 0, 0, 0.1);">
                    <tr>
                        <td align="center" style="background-color: #0d427c; color: #fff7b0; padding: 20px;">
                            <img src="https://res.cloudinary.com/dpr1oftgx/image/upload/v1732590742/upload/p6qftzlbhvgsvufukwdc.png"
                                alt="logo ALP" style="height: 80px;">
                            <h1 style="margin: 10px 0 0; font-size: 20px;">ALP Insight</h1>
                        </td>
                    </tr>
                    <tr>
                        <td align="center" style="padding: 10px; font-size: 28px;">
                            <strong>Feedback Baru</strong>
                        </td>
                    </tr>
                    <tr>
                        <td align="left" style="padding: 10px; font-size: 14px;">
                            <strong>CFS Ticket: {{ $complaint->complaint_ticket }}</strong><br>
                            <span style="color: black"> Batch Number: {{ $complaint->batch_number }}</span><br>
                            <span style="color: black">Distributor terkait:
                                {{ $complaint->distributor->company_name }}</span><br><br>
                            <span style="color: black"> Laporan feedback telah dibuat oleh {{ $user->name }} /
                                {{ $complaint->mainDistributor->distributor_name }}<br><br>
                            </span>
                            <span style="font-weight: bold;font-size: 17px; color: black">Judul:
                                {{ $complaint->complaint_title }}<br></span><br>
                            <span style="color: black">Deskripsi:</span> <br> <span
                                style="color: black">{{ $complaint->complaint_description }}
                            </span><br><br>
                            <span style="color:black"></span> Harapan: <br><span style="color: black">
                                {{ $complaint->complaint_hopeful_solution }}
                            </span> <br><br>
                            Aduan dibuat pada:
                            <em>{{ Carbon\Carbon::parse($complaint->created_at)->locale('id')->translatedFormat('l, j F Y H:i:s') }}</em><br><br>
                            <p style="color: black">Salam,<br><strong>PT. ALP Petro Industry</strong></p>
                        </td>
                    </tr>
                    <tr>
                        <td align="center"
                            style="background-color: #f3f3f3; padding: 10px 20px; font-size: 14px; color: #000000;">
                            &copy; 2024 PT. ALP Petro Industry. All rights reserved.
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>
