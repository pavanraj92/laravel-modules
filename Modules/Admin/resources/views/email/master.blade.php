<!DOCTYPE >
<html >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
</head>

<body style="background:#f6f6f6; padding:0px; margin:0px;">
<div>
  <table width="600" cellpadding="0" cellspacing="0" align="center" bgcolor="#ffffff" style="border:1px solid #dddddd;">
    <tr>
      <td>
        <table width="100%" cellpadding="0" cellspacing="0" style="background:#fff; border-bottom:solid 3px #0b5aa4; padding:20px; text-align:center;">
          <tr>
            <td align="center"><a href="{{ url('/') }}"><img src="{{ asset('images/logo.png') }}"/></a></td>
          </tr>
        </table>
     </td>
    </tr>
    <table width="100%" cellpadding="0" cellspacing="0" style="background:#fff; padding:20px;">
    <tr>
      <td style="font-family:Arial, Helvetica, sans-serif; font-size:18px; color:#4a5a5a; padding-bottom: 15px;">
        @isset($template)
        {!! $template !!}
        @endisset
      </td>
    </tr>
    </table>
    <tr>
      <td>
       <table width="100%" cellpadding="0" cellspacing="0">
        <tr>
         <td align="center" style="background-color:#e5ebeb; color:#4a5a5a; font-size:12px; font-family:Arial, Helvetica, sans-serif; text-align:center; padding:10px;">
          Powered by <a href="{{ url('/') }}">{{ env('APP_NAME','Dotsquares') }}</a>.
         </td>
        </tr>
       </table>
      </td>
    </tr>
  </table>
</div>
</body>
</html>
