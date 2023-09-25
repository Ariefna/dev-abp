<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>LOADING REPORT</title>

    <style>
        table#display {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
        }

        table#display,
        table#display td,
        table#display th {
            border: 1px solid black;
        }

    </style>
</head>
<body>
    <h1 style="text-align: center;">LOADING REPORT</h1>

    <table>
        <tr>
            <td>Loading</td>
            <td>: {{$DetailTracking->docTracking->portOfLoading->nama_pol}}</td>
        </tr>
        <tr>
            <td>Cargo</td>
            <td>: {{$DetailTracking->docTracking->po->barang->nama_barang}}</td>
        </tr>
        <tr>
            <td>Destination</td>
            <td>: {{$DetailTracking->docTracking->portOfDestination->nama_pod}}</td>
        </tr>
        <tr>
            <td>DARI PARTY</td>
            <td>: PO : {{$DetailTracking->docTracking->no_po}} {{$DetailTracking->docTracking->po->total_qty}} KG</td>
        </tr>

        {{-- space --}}
        <tr>
            <td style="padding-top: 10px"></td>
        </tr>

        <tr>
            <td>TD VESSEL</td>
            <td>: {{ date('d F Y', strtotime($DetailTracking->tgl_muat)) }}</td>
        </tr>
        <tr>
            <td>VESSEL</td>
            <td>: {{$DetailTracking->kapal->kode_kapal}} {{$DetailTracking->kapal->nama_kapal}} {{$DetailTracking->voyage}}</td>
        </tr>
        <tr>
            <td>DIMUAT</td>
            <td>: PO : {{$DetailTracking->docTracking->no_po}} {{$tbl_po->sum('qty_tonase')}} KG</td>
        </tr>
        <tr>
            <td>PO KEBUN</td>
            <td>: {{$DetailTracking->docTracking->po->po_kebun}}</td>
        </tr>
        <tr>
            <td>NAMA KEBUN</td>
            <td>: {{$DetailTracking->docTracking->po->detailPhs->penerima->ptPenerima->nama_penerima}}</td>
        </tr>
    </table>

    {{-- DISPLAY TABLE --}}
    <table id="display" style="padding-top: 10px;">
        <tr>
            <th>No</th>
            <th>Nopol</th>
            <th>Tanggal Muat</th>
            <th>Jenis Pupuk</th>
            <th>No Container</th>
            <th>Jumlah Bag</th>
            <th>Tonase (Kg)</th>
            <th>Timbangan (Kg)</th>
            <th>ESTATE</th>
            <th>PL</th>
        </tr>
        @foreach ($tbl_po as $item)
        <tr>
            <td>{{$loop->iteration}}</td>
            <td>{{$item->nopol}}</td>
            <td>{{$item->tgl_muat}}</td>
            <td>{{$item->nama_barang}}</td>
            @if($item->no_container !== null)
                <td>{{ $item->no_container }}</td>
            @else
                <td>-</td>
            @endif
            <td>{{$item->jml_sak}}</td>
            <td>{{$item->qty_tonase}}</td>
            <td>{{$item->qty_timbang}}</td>
            <td>{{$item->estate}}</td>
            <td>{{$item->no_pl}}</td>
        </tr>
        @endforeach
    </table>
</body>
</html>
