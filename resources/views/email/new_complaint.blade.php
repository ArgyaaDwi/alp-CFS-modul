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
                        <td align="center" style="padding-top:-10px; padding-bottom: 10px; font-size: 20px; color: black;">
                            <strong>ALP Insight</strong>
                        </td>
                    </tr>
                    <tr>
                        <td align="center" style="padding: 10px; font-size: 18px;">
                            Feedback Baru
                        </td>
                    </tr>
                    <tr>
                        <td align="left" style="padding: 10px; font-size: 14px;">
                            <strong>CFS Ticket: {{ $complaint->complaint_ticket }}</strong><br>
                            <span style="color: black">Distributor terkait:
                                {{ $complaint->distributor->company_name }}</span><br><br>
                            <span style="color: black"> Laporan feedback telah dibuat oleh {{ $user->name }} /
                                {{ $complaint->mainDistributor->distributor_name }}<br><br>
                            </span>
                            <span style="font-weight: bold;font-size: 18px; color: black">Judul:
                                {{ $complaint->complaint_title }}<br></span>
                            <span style="color: black"> Batch Number: {{ $complaint->batch_number }}</span><br>
                            <span style="color: black">Deskripsi:</span> <br> <span
                                style="color: black">{{ $complaint->complaint_description }}</span><br>
                            <span style="color:black"></span> Harapan: <br><span
                                style="color: black">{{ $complaint->complaint_hopeful_solution }}</span> <br>
                            Aduan dibuat pada:
                            <em>{{ Carbon\Carbon::parse($complaint->created_at)->locale('id')->translatedFormat('l, j F Y H:i:s') }}</em><br><br>
                            <span style="color: black"> Salam,<br>PT. ALP Petro Industry</span>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
