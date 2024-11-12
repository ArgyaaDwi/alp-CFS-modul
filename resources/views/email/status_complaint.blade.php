<!DOCTYPE html>
<html>
<head>
    <title>Laporan Feedback Baru</title>
</head>
<body>
    <table width="100%" cellpadding="0" cellspacing="0" border="0">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0" border="0">
                    <tr>
                        <td align="center" style="padding: 20px;">
                            <img src="https://res.cloudinary.com/dpr1oftgx/image/upload/v1729562619/upload/logoalp_bmdpec.jpg"
                                height="100" alt="logo ALP">
                        </td>
                    </tr>
                    <tr>
                        <td align="center"
                            style="padding-top:-10px; padding-bottom: 10px; font-size: 20px; color: black;">
                            <strong>ALP Insight</strong>
                        </td>
                    </tr>
                    <tr>
                        <td align="center" style="padding: 10px; font-size: 18px;">
                            Pemberitahuan
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
                            <span style="color: black"> Salam,<br>PT. ALP Petro Industry</span>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
