<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>{{ config('app.name') }}</title>
</head>
<body style="margin:0;padding:0;background:#F4F8FF;font-family:-apple-system,Segoe UI,Helvetica,Arial,sans-serif;">
<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#F4F8FF;padding:32px 0;">
<tr>
<td align="center">
<table role="presentation" width="560" cellpadding="0" cellspacing="0" style="background:#FFFFFF;border-radius:12px;overflow:hidden;border:1px solid #E1E7F1;">
<tr>
<td style="background:#14264F;padding:20px 28px;">
<span style="color:#FFFFFF;font-size:18px;font-weight:700;">{{ \App\Models\Setting::get('company_name', config('app.name')) }}</span>
</td>
</tr>
<tr>
<td style="padding:28px;color:#14264F;font-size:15px;line-height:1.6;">
{!! $bodyHtml !!}
</td>
</tr>
<tr>
<td style="padding:16px 28px;background:#F8FAFD;border-top:1px solid #E1E7F1;color:#4A5875;font-size:12px;">
{{ \App\Models\Setting::get('company_legal', 'Unite Systems LLC') }} &middot; {{ \App\Models\Setting::get('company_hq', 'Kentucky, USA') }}
</td>
</tr>
</table>
</td>
</tr>
</table>
</body>
</html>
