<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Invoice DP</title>
    <style>
        @page{margin: 10px;}
        .toggle-code-snippet { margin-bottom: 0px; }
        body.dark .toggle-code-snippet { margin-bottom: 0px; }
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
    
        /* Firefox */
        input[type=number] {
            -moz-appearance: textfield;
        }
        .table-bordered{
            border: 1px solid black;
        }
        .headt{
            width: 50%;
        }
        .no-page-break {
            page-break-inside: avoid;
        }
        .tg  {border-collapse:collapse;border-spacing:0;}
        .tg td{border-color:black;border-style:solid;border-width:2px;font-family:Arial, sans-serif;font-size:14px;
        overflow:hidden;padding:1px 2px;word-break:normal;}
        .tg th{border-color:black;border-style:solid;border-width:1px;font-family:Arial, sans-serif;font-size:14px;
        font-weight:normal;overflow:hidden;padding:1px 2px;word-break:normal;}
        .tg .tg-sobq{border-color:inherit;font-family:"Arial Black", Gadget, sans-serif !important;font-size:26px;font-weight:bold;
        text-align:left;vertical-align:top}
        .tg .tg-c3ow{border-color:inherit;text-align:center;vertical-align:top}
        .tg .tg-wp8o{border-color:#000000;text-align:center;vertical-align:top}
        .tg .tg-r1gl{border-color:inherit;font-family:Arial, Helvetica, sans-serif !important;font-size:15px;text-align:left;
        vertical-align:top}
        .tg .tg-7btt{border-color:inherit;font-weight:bold;}
        .tg .tg-n6ju{border-color:inherit;font-weight:bold;text-align:center;vertical-align:top}
        .tg .tg-0pky{border-color:inherit;text-align:left;vertical-align:top}
        .tg .tg-fymr{border-color:inherit;font-weight:bold;text-align:left;vertical-align:top}
        .tg .tg-73oq{border-color:#000000;text-align:left;vertical-align:top}
    </style>
</head>
<body>
    <div class="no-page-break">
        {{-- new table --}}
        <table class="tg" width="100%">
            <thead>
              <tr>
                <th class="tg-sobq" style="border: none; font-family:'Arial Black'; font-size:18pt !important;" colspan="7">PT Adhipramana Bahari Perkasa</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td class="tg-r1gl" style="border: none; font-family: Calibri, sans-serif; font-size: 11pt !important;" colspan="7">Pergudangan Pakal Indah, Jl Raya Pakal no 16 Blok A7<br>Surabaya, Indonesia<br>Telp +6231 7433099</td>
              </tr>
              <tr>
                <td class="tg-7btt" style="font-size: 18pt !important;" colspan="3">Bill To</td>
                <td class="tg-n6ju" style="font-size: 18px;" colspan="4">Invoice</td>
              </tr>
              <tr>
                <td class="tg-0pky" style="font-weight: bold;" colspan="3" rowspan="3">{{ $data['nama_customer'] ?? '-' }}<br>{{ $data['kota_customer'] ?? '-'}}</td>
                <td class="tg-0pky" style="border: none;" colspan="2">INVOICE DATE</td>
                <td class="tg-fymr" style="border-left: none; border-bottom: none; border-top: none; text-align: right;font-weight: bold;" colspan="2">{{ $data['invoice_date'] ?? '-'}}</td>
              </tr>
              <tr>
                <td class="tg-0pky" style="border: none;" colspan="2">INVOICE NO</td>
                <td class="tg-fymr" style="border-left: none; border-bottom: none; border-top: none; text-align: right;font-weight: bold;" colspan="2">{{ $data['invoice_no'] ?? '-'}}</td>
              </tr>
              <tr>
                <td class="tg-0pky" style="border-left: none; border-top: none; border-right: none;" colspan="2">TERMS</td>
                <td class="tg-fymr" style="border-left: none; border-top: none; text-align: right;font-weight: bold;" colspan="2">{{ $data['terms'] ?? '-'}}</td>
              </tr>
              @php
    $pelayaranList = []; // Buat array sementara untuk melacak nilai $kapal['pelayaran']
@endphp
              @foreach ($data['kapal'] as $key => $kapal)
              @if (!in_array($kapal['pelayaran'], $pelayaranList))
              <tr>
                {{-- @if ($key == 0) --}}
                <td class="tg-0pky" style="border-right: none; border-bottom: none; border-top:none;">
                    @if ($key == 0)
                        NO PO #
                    @endif
                </td>
                <td class="tg-wp8o" style="border-right: none; border-bottom: none; border-left:none; border-top:none;">
                    @if ($key == 0)
                    :
                    @endif
                </td>
                <td class="tg-0pky" style="border-right: none; border-bottom: none; border-left:none; border-top:none; text-align:left;">
                    @if ($key == 0)
                        {{ $data['no_po'] ?? '-'}}
                    @endif
                </td>
                <td class="tg-0pky" style="border-right: none; border-bottom: none; border-left: none; border-top:none;" colspan="2">
                    @if ($key == 0)
                        Pelayaran
                    @endif
                </td>
                <td class="tg-c3ow" style="border-right: none; border-bottom: none; border-left:none; border-top:none;">
                    @if ($key == 0)
                    :
                    @endif
                </td>
                <td class="tg-0pky" style="border-bottom: none; border-left:none; border-top:none;">{{ $kapal['pelayaran'] }}</td>
              </tr>
              @endif
    @php
        $pelayaranList[] = $kapal['pelayaran']; // Tambahkan nilai ke dalam array sementara
    @endphp
              @endforeach
              <tr>
                <td class="tg-0pky" style="border-right: none; border-bottom: none; border-top: none;">Tujuan</td>
                <td class="tg-c3ow" style="border:none;">:</td>
                <td class="tg-0pky" style="border:none;">{{ $data['tujuan1'] ?? ''}} - {{ $data['tujuan2'] ?? ''}}</td>
                <td class="tg-0pky" style="border-right: none; border-bottom: none; border-top: none; border-left: none;" colspan="2">Tipe Job </td>
                <td class="tg-c3ow" style="border: none;">:</td>
                <td class="tg-0pky" style="border-left: none; border-bottom: none; border-top: none;">{{ $data['tipe_job'] }}</td>
              </tr>
              <tr>
              </tr>
              {{-- @foreach ($groupedData as $name => $group) --}}
              @foreach ($data['kapal'] as $key => $kapal)
              <tr>
                <td class="tg-0pky" style="border-right: none;border-top:none;border-bottom: none;">
                    @if ($key == 0)
                        VOY #
                    @endif
                </td>
                <td class="tg-c3ow" style="border: none;">
                    @if ($key == 0)
                        :
                    @endif
                </td>
                <td class="tg-0pky" style="border: none;">{{ $kapal['name'] }}</td>
                <td class="tg-0pky" style="border: none;" colspan="2">
                    @if ($key == 0)
                        ETD
                    @endif
                </td>
                <td class="tg-c3ow" style="border: none;">
                    @if ($key == 0)
                        :
                    @endif
                </td>
                <td class="tg-0pky" style="border-left: none;border-top:none;border-bottom: none;"></td>
              </tr>
              @endforeach
              {{-- @endforeach --}}
              <tr>
                <td class="tg-0pky" style="border-right: none;border-top:none;">Total</td>
                <td class="tg-c3ow" style="border-right: none;border-top:none; border-left: none;">:</td>
                <td class="tg-0pky" style="border-right: none;border-top:none; border-left: none;">{{ $data['total-cont'] }} KG</td>
                <td class="tg-0pky" style="border-right: none;border-top:none; border-left: none;" colspan="2">Stuff Date</td>
                <td class="tg-c3ow" style="border-right: none;border-top:none; border-left: none;">:</td>
                <td class="tg-0pky" style="border-left: none;border-top:none; border-left: none;"></td>
              </tr>
              <tr>
                <td class="tg-7btt" style="font-size: 18px;" colspan="3">Description</td>
                <td class="tg-n6ju" style="font-size: 18px;" colspan="4">Amount</td>
              </tr>
              @php
                $subtotal = 0;
                $dp_50 = 0;
                $ppn = 0;
              @endphp
              @foreach ($data['description'] as $desc)
                <tr>
		    <td class="tg-0pky" style="border-bottom: none; border-top: none; text-align:left;" colspan="3">{{ $desc['name'] }}</td>                    
                    <td class="tg-0pky" style="border-bottom: none; border-top: none; border-right: none; text-align:left;" colspan="2">Harga Cont</td>
                    <td class="tg-0pky" style="border-bottom: none; border-top: none; border-left:none; text-align:left;" colspan="2">{{ number_format($desc['total_tonase'] * $desc['harga_brg'], 0, ',', '') }}</td>
                </tr>
                @php
                    $subtotal += $desc['total_tonase'] * $desc['harga_brg'];
                    $dp_50 += $desc['total_dp'];
                    $ppn += $desc['total_ppn'];
                @endphp                
              @endforeach
              <tr>
                <td class="tg-0pky" style="border-bottom: none; border-top: none; border-right: none; text-align:left;" colspan="3"></td>
                <td class="tg-0pky" style="border-bottom: none; border-top: none; border-right: none; text-align:left;" colspan="2">Subtotal</td>
                <td class="tg-0pky" style="border-bottom: none; border-top: none; border-left:none; text-align:left;" colspan="2">{{ number_format($subtotal, 0, ',', '') }}</td>
              </tr>
              <tr>
                <td class="tg-0pky" style="border-bottom: none; border-top: none; border-right: none; text-align:left;" colspan="3"></td>
                <td class="tg-0pky" style="border-bottom: none; border-top: none; border-right: none; text-align:left;" colspan="2">DP 50%</td>
                <td class="tg-0pky" style="border-bottom: none; border-top: none; border-left:none; text-align:left;" colspan="2">{{ number_format($dp_50, 0, ',', '') }}</td>
              </tr>
              <tr>
                <td class="tg-0pky" style="border-bottom: none; border-top: none; border-right: none;text-align:left;" colspan="3"></td>
                <td class="tg-0pky" style="border-bottom: none; border-top: none; border-right: none;text-align:left;" colspan="2">PPN 1,1%</td>
                {{-- <td class="tg-0pky" style="border-bottom: none; border-top: none; border-left:none;text-align:left;" colspan="2">{{ (number_format(isset($desc['prosentase_ppn']) ? ($desc['prosentase_ppn'] * $subtotal / 100 + $dp_50) : 0, 0, ',', '')) }}</td> --}}
                <td class="tg-0pky" style="border-bottom: none; border-top: none; border-left:none;text-align:left;" colspan="2">{{ number_format($ppn, 0, ',', '') }}</td>
                {{-- <td class="tg-0pky" style="border-bottom: none; border-top: none; border-left:none;" colspan="2">Rp. {{ number_format($desc['total_ppn']) }}</td> --}}
              </tr>
              <tr>
                <td class="tg-0pky" style="border-bottom: none; border-top: none; border-right: none;text-align:left;" colspan="3"></td>
                <td class="tg-0pky" style="border-bottom: none; border-top: none; border-right: none;text-align:left;" colspan="2">Total Invoice</td>
                <td class="tg-0pky" style="border-bottom: none; border-top: none; border-left:none;text-align:left;" colspan="2">
                    <b>Rp. {{ number_format($dp_50 + $ppn, 0, ',', '.') }}</b>
                </td>
              </tr>
              <tr>
                <td colspan="3"></td>
                <td colspan="2"></td>
                <td colspan="2"></td>
              </tr>
              <tr>
                <td class="tg-73oq" style="border-bottom: none; border-right: none; border-left: none;" colspan="3">
                    <h5><b>
                        Note : <br/>
                        {{ $data['bank']['nama_bank'] }} <br />
                        a/c {{ $data['bank']['account_number'] }} <br />
                        a/n {{ $data['bank']['a/n'] }}<br />
                    </b></h5>
                </td>
                <td class="tg-0pky" style="border-bottom: none; border-right: none; border-left: none;" colspan="2"></td>
                <td class="tg-0pky" style="border-bottom: none; border-right: none; border-left: none;" colspan="2">
                    <p>
                        Surabaya, {{ date('d F Y', strtotime($data['invoice_date'])) }} <br/>
                        Hormat Kami,
                    </p>                    
                </td>
              </tr>
            </tbody>
        </table>
    </div>                
</body>
</html>