<!DOCTYPE html>
<html>
<head>
    <title>Laporan Perubahan Status</title>
</head>

<body>
    <table width="100%" cellpadding="0" cellspacing="0" border="0"
        style="background-color: #ffffff; padding: 20px 0;">
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
                            <strong>Pemberitahuan</strong>
                        </td>
                    </tr>
                    <tr>
                        <td align="left" style="padding: 10px; font-size: 14px;">
                            <strong>CFS Ticket: {{ $complaint->complaint_ticket }}</strong><br>
                            <span style="color: black">Distributor terkait:
                                {{ $complaint->distributor->company_name }}</span><br><br>

                            <span style="color: black">Yth. {{ $complaint->user->name }}</span><br>
                            <span style="color: black">Kami informasikan bahwa aduan yang Anda sampaikan dengan nomor
                                tiket {{ $complaint->complaint_ticket }} telah mengalami perubahan
                                status.</span><br><br>

                            <span style="color: black">Status sekarang: <span
                                    style="color: black; font-weight: bold">{{ $complaint->currentStatus->status_name }}</span></span>
                            <br> <br><span style="color: black">Untuk informasi lebih detail, Anda dapat masuk ke ALP
                                Insight
                                dan login ke akun Anda. <br>Sekian yang dapat kami sampaikan. Terima kasih.</span><br>
                            <br>
                            Status aduan feedback diperbarui pada:
                            <em>{{ Carbon\Carbon::parse($latestInteraction->created_at)->locale('id')->translatedFormat('l, j F Y H:i:s') }}</em>
                            <br> oleh {{ $latestInteraction->user->name }}<br><br>
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
