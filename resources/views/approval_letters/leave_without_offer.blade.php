<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">

    <style>
        @page {
            margin: 25mm 25mm 25mm 25mm;
        }

        body {
            font-family: 'iskoolapota';
            font-size: 12pt;
            line-height: 1.8;
        }

        .reference {
            text-align: left;
        }

        .subject {
            font-weight: bold;
            text-decoration: underline;
            margin-top: 35px;
            margin-bottom: 25px;
        }

        .content {
            text-align: justify;
        }

        .signature {
            margin-top: 50px;
        }

        .copies {
            margin-top: 35px;
        }
    </style>
</head>

<body>

    <p class="reference">
        CSS/2/16/1/FL {{ $date }}
    </p>

    <p>
        ලේකම්,<br>
        දකුණු පළාත් ප්‍රධාන ලේකම් කාර්යාලය,<br>
        දකුණු පළාත.
    </p>

    <p class="subject">
        වැටුප් සහිත විදේශ නිවාඩු සඳහා අනුමැතිය ලබා ගැනීම.
    </p>

    <p class="content">
        අයදුම්පත් අංක {{ $application_no }} සහ
        {{ $submitted_date }} දිනැති අයදුම්පත සම්බන්ධයෙන්...
    </p>

    <p class="content">
        {{ $name }} මහතා/මහත්මිය වෙත
        {{ $country }} වෙත විදේශගත වීම සඳහා
        {{ $leave_from }} සිට {{ $leave_to }} දක්වා
        විදේශ නිවාඩු ලබා දීමට අනුමැතිය ලබා දෙමි.
    </p>

    <div class="signature">
        <p>
            චන්දිම සී. මුහන්දිරම්ගේ,<br>
            ප්‍රධාන ලේකම්,<br>
            දකුණු පළාත.
        </p>
    </div>

</body>
</html>