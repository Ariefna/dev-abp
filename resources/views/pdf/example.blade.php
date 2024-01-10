<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ms" lang="ms">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Penawaran Harga {{ $data1['nama_customer'] }}</title>
    <meta name="author" content="ABP" />
    <style type="text/css">
        * {
            margin: 0;
            padding: 0;
            text-indent: 0;
        }

        .s1 {
            color: black;
            font-family: "Times New Roman", serif;
            font-style: normal;
            font-weight: normal;
            text-decoration: none;
            font-size: 13pt;
        }

        .p,
        p {
            color: black;
            font-family: "Times New Roman", serif;
            font-style: normal;
            font-weight: normal;
            text-decoration: none;
            font-size: 11pt;
            margin: 0pt;
        }

        .s2 {
            color: black;
            font-family: Calibri, sans-serif;
            font-style: normal;
            font-weight: bold;
            text-decoration: none;
            font-size: 11pt;
        }

        .s3 {
            color: black;
            font-family: Calibri, sans-serif;
            font-style: normal;
            font-weight: normal;
            text-decoration: none;
            font-size: 11pt;
        }

        .s5 {
            color: black;
            font-family: "Times New Roman", serif;
            font-style: normal;
            font-weight: normal;
            text-decoration: underline;
            font-size: 11pt;
        }

        li {
            display: block;
        }

        #l1 {
            padding-left: 0pt;
            counter-reset: c1 1;
        }

        #l1>li>*:first-child:before {
            counter-increment: c1;
            content: counter(c1, decimal)". ";
            color: black;
            font-family: "Times New Roman", serif;
            font-style: normal;
            font-weight: normal;
            text-decoration: none;
            font-size: 11pt;
        }

        #l1>li:first-child>*:first-child:before {
            counter-increment: c1 0;
        }

        #bg-image {
            background-image: url('logo-abp.jpg');
            background-size: 100%;
            background-repeat: no-repeat;
            margin: 0px;
            padding: 0;
            height: 100%;
        }

        table,
        tbody {
            vertical-align: top;
            overflow: visible;
        }
    </style>
</head>

<body id="bg-image">
    <table>
        <table border="0" cellspacing="0" cellpadding="0" style="margin-top: 24%;">
            <tr>
            </tr>
        </table>
        <?php
        $updated_at = $data1['created_at']; // Gantilah ini dengan nilai tanggal yang sesuai

        $timestamp = strtotime($updated_at);

        if ($timestamp === false) {
            echo "Format tanggal tidak valid.";
        } else {
            $formatted_date = date('d F Y', $timestamp);
        }
        ?>
        <p class="s1" style="padding-top: 11pt;padding-left: 365pt;text-indent: 0pt;text-align: left;">Surabaya, {{ $formatted_date }}</p>
        <p style="padding-top: 9pt;padding-left: 41pt;text-indent: 0pt;text-align: left;">Kepada :</p>
        <p style="padding-top: 9pt;padding-left: 41pt;text-indent: 0pt;text-align: left;">Bp {{ $data1['nama_pic'] }}</p>
        <p style="padding-top: 9pt;padding-left: 41pt;text-indent: 0pt;text-align: left;">{{ $data1['nama_customer'] }}</p>
        <p style="padding-top: 9pt;padding-left: 41pt;text-indent: 0pt;text-align: left;">{{ $data1['kota'] }}</p>
        <p style="text-indent: 0pt;text-align: left;"><br /></p>
        <p style="text-indent: 0pt;text-align: left;"><br /></p>
        <p style="padding-left: 41pt;text-indent: 0pt;text-align: left;">Dengan hormat,</p>
        <p style="padding-top: 9pt;padding-left: 77pt;text-indent: 0pt;text-align: left;">Bersama ini kami sampaikan Price List dengan muatan via Container perincian sbb:</p>
        <p style="text-indent: 0pt;text-align: left;"><br /></p>
        <table style="border-collapse:collapse;margin-left:87.1125pt" cellspacing="0">
            <tr style="height:15pt">
                <td style="width:88pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
                    <p class="s2" style="text-indent: 0pt;line-height: 13pt;text-align: center;">ESTATE</p>
                </td>
                <td style="width:144pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
                    <p class="s2" style="text-indent: 0pt;line-height: 13pt;text-align: center;">OA KAPAL KAYU</p>
                </td>
                <td style="width:144pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
                    <p class="s2" style="text-indent: 0pt;line-height: 13pt;text-align: center;">OA CONTAINER</p>
                </td>
            </tr>

            @foreach ($data2 as $key => $item)
            <tr style="height:15pt">
                <td style="width:88pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
                    <p style="text-indent: 0pt;text-align: center;">{{ $item['estate'] }}<br /></p>
                </td>
                <td style="width:100pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;" bgcolor="#FFFFFF">
                    <p class="s3" style="text-indent: 0pt;line-height: 12pt;text-align: center;">Rp {{ $item['oa_kpl_kayu'] }} ,-/KG</p>
                </td>
                <td style="width:100pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt;" bgcolor="#FFFFFF">
                    <p class="s3" style="text-indent: 0pt;line-height: 12pt;text-align: center;">Rp {{ $item['oa_container'] }} ,-/KG</p>
                </td>
            </tr>
            @if ($key == 25)
            @php
            break;
            @endphp
            @endif
            @endforeach
        </table>
    </table>
    @if (count($data2) > 0 && count($data2) < 10) {
    <p style="padding-top: 15pt"></p>
    @elseif(count($data2) >10 && count($data2) < 50)
    <p style="padding-top: 165pt"></p>
    @endif
    @if (count($data2) > 26)
    <table style="border-collapse:collapse;margin-left:87.1125pt" cellspacing="0">
            <tr style="height:15pt">
                <td style="width:88pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
                    <p class="s2" style="text-indent: 0pt;line-height: 13pt;text-align: center;">ESTATE</p>
                </td>
                <td style="width:144pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
                    <p class="s2" style="text-indent: 0pt;line-height: 13pt;text-align: center;">OA KAPAL KAYU</p>
                </td>
                <td style="width:144pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
                    <p class="s2" style="text-indent: 0pt;line-height: 13pt;text-align: center;">OA CONTAINER</p>
                </td>
            </tr>

            @foreach ($data2 as $key => $item)
            @if ($key <= 26)
            @php
            continue;
            @endphp
            @endif
            <tr style="height:15pt">
                <td style="width:88pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
                    <p style="text-indent: 0pt;text-align: center;">{{ $item['estate'] }}<br /></p>
                </td>
                <td style="width:100pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;" bgcolor="#FFFFFF">
                    <p class="s3" style="text-indent: 0pt;line-height: 12pt;text-align: center;">Rp {{ $item['oa_kpl_kayu'] }} ,-/KG</p>
                </td>
                <td style="width:100pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt;" bgcolor="#FFFFFF">
                    <p class="s3" style="text-indent: 0pt;line-height: 12pt;text-align: center;">Rp {{ $item['oa_container'] }} ,-/KG</p>
                </td>
            </tr>
          
            @endforeach
        </table>
    @endif
    @if (count($data2) > 29)
    <p style="padding-top: 165pt"></p>
    @endif
      
        <p style="text-indent: 0pt;text-align: left;"><br /></p>
        <p style="padding-top: 8pt;padding-left: 41pt;text-indent: 0pt;text-align: left;">Ketentuan :</p>
        <?php
        $lines = explode("\n", $data1['ketentuan']);

        $html = '<ol id="l1">';
        foreach ($lines as $line) {
            // Extract the list number and content
            preg_match('/^(\d+\.)\s+(.*)$/', $line, $matches);
            if (count($matches) === 3) {
                $listNumber = $matches[1];
                $listContent = $matches[2];
                $html .= '<li data-list-text="' . $listNumber . '">
        <p style="padding-left: 59pt;text-indent: -18pt;line-height: 13pt;text-align: left;">' . $listContent . '</p>
    </li>';
            }
        }
        $html .= '</ol>';

        echo $html;
        ?>
        <br>
        <br>
        <table width="787" style="color: black; font-family: 'Times New Roman', serif; font-style: normal; font-weight: normal; text-decoration: none; font-size: 11pt; margin: 0pt;padding-left: 41pt">
            <thead>
                <tr>
                    <th style="width: 20%"></th>
                    <th style="width: 0%"></th>
                    <th style="width: 60%"></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="padding-bottom: 90px;">Hormat kami,</td>
                    <td></td> <!-- Sel kosong untuk kolom 2 -->
                    <td style="padding-bottom: 90px;">Hormat kami,</td> <!-- Kosongkan tanda tangan pertama -->
                </tr>
                <tr>
                    <td style="padding-top: 10px;">{{ $data1['nama_customer'] }}</td>
                    <td></td> <!-- Sel kosong untuk kolom 2 -->
                    <td style="padding-top: 10px;">
                        PT. Adhipramana Bahari Perkasa
                    </td>
                    <!-- Tempatkan tanda tangan pertama di sini -->
                </tr>
                <tr>
                    <td>{{ $data1['nama_pic'] }}</td>
                    <td></td>
                    <td> Bp. Donny Limanta</td>
                </tr>
            </tbody>
        </table>
</body>

</html>