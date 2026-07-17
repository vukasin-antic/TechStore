<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Verify Your Account</title>
</head>
<body style="margin:0;padding:0;background-color:#f8f9fa;font-family:Arial,Helvetica,sans-serif;">
<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="padding:30px 0;">
    <tr>
        <td align="center">
            <table role="presentation" width="480" cellpadding="0" cellspacing="0"
                   style="background-color:#ffffff;border-radius:8px;padding:30px;">
                <tr>
                    <td align="center" style="padding-bottom:20px;">
                        <h1 style="margin:0;color:#ff6f00;font-size:24px;">TechStore</h1>
                    </td>
                </tr>
                <tr>
                    <td style="color:#212529;font-size:15px;line-height:1.6;">
                        <p style="margin:0 0 10px;">Hello {{ $user->first_name }},</p>
                        <p style="margin:0 0 20px;">
                            Thank you for registering at TechStore! Use the verification code below
                            to activate your account:
                        </p>
                    </td>
                </tr>
                <tr>
                    <td align="center" style="padding-bottom:20px;">
                        <div style="display:inline-block;background-color:#f8f9fa;border:1px dashed #ff6f00;
                                    border-radius:8px;padding:12px 30px;font-size:28px;font-weight:bold;
                                    letter-spacing:8px;color:#212529;">
                            {{ $user->verification_code }}
                        </div>
                    </td>
                </tr>
                <tr>
                    <td style="color:#6c757d;font-size:13px;line-height:1.6;">
                        <p style="margin:0;">
                            If you did not create an account, you can safely ignore this email.
                        </p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>
