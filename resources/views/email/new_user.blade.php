<!DOCTYPE html>
<html>

<head>
    <title>Informasi Pengguna Baru</title>
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
                        <td align="left" style="padding: 20px; font-size: 16px; line-height: 1.6; color: #333333;">
                            <p style="color: black"><strong>Yth. Admin,</strong></p>
                            <p style="color: black">Kami informasikan bahwa terdapat pengguna baru yang segera
                                diperlukan verifikasi lebih
                                lanjut. Silahkan segera masuk ke sistem dan melakukan verifikasi user terkait.</p>
                            <span style="color: black">Nama Pengguna: {{ $user->name }}</span><br>
                            <span style="color: black">Main Distributor:
                                {{ $user->distributor->distributor_name }}</span>
                            <p style="color: black">Pengguna bergabung pada:
                                <em>{{ Carbon\Carbon::parse($user->created_at)->locale('id')->translatedFormat('l, j F Y H:i:s') }}</em>
                            </p>
                            <p style="color: black">Sekian yang dapat kami sampaikan. Terima kasih.</p>
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
