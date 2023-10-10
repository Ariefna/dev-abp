<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Surat Penunjukan Kerja {{$DetailTracking->kapal->cPort->nama}}</title>
    <style>
        #bg-image {
            background-image: url('logo-abp.jpg');
            background-size: 100%;
            background-repeat: no-repeat;
            margin: -60px -60px -60px -60px;
            padding: 0;
            height: 110%;
        }

        #content {
            margin: 0px 50px 0px 50px;
            padding: 200px 0 0 0;
        }

        table#detail td {
            vertical-align: top;
        }

        table#detail {
            padding-left: 20px;
            padding-right: 10px;
        }

        table#ttd {
            width: 100%;
            text-align: center;
            padding-top: 10px;
        }

    </style>
</head>
<body>
    <div id="bg-image">
        <div id="content">
            <p style="text-align: right">Surabaya, {{$taggal_spk}}</p>

            <table>
                <tr>
                    <td>Nomor</td>
                    <td>: {{$nomor}}</td>
                </tr>
                <tr>
                    <td>Hal</td>
                    <td>
                        : Pemuatan & Pengiriman Barang
                        Dari Port {{$DetailTracking->docTracking->portOfLoading->nama_pol}}
                        ke Port {{$DetailTracking->docTracking->portOfDestination->nama_pod}}
                    </td>
                </tr>
            </table>

            <p style="width: 50%">
                Kepada Yth.
                <br>
                {{$DetailTracking->kapal->cPort->nama}}
                <br>
                {{$DetailTracking->kapal->cPort->alamat}}
            </p>

            <p style="text-align: center; padding-top: 10px"><b>SURAT PENUNJUKAN KERJA / KONTRAK KERJA</b></p>

            <p style="text-indent: 30px; text-align: justify;">
                Sehubungan dengan rencana pemuatan & pengiriman pupuk,
                maka dengan ini kami menunjuk {{$DetailTracking->kapal->cPort->nama}}
                untuk melakukan pemuatan & pengiriman pupuk menggunakan kapal 
                dari port {{$DetailTracking->docTracking->portOfLoading->nama_pol}} 
                ke pelabuhan {{$DetailTracking->docTracking->portOfDestination->nama_pod}},
                tonase dibagi 2 nama kapal sesuai data di bawah ini dengan uraian sebagai berikut:
            </p>

            <table id="detail">
                <tr>
                    <td style="width: 150px">Jenis Barang</td>
                    <td>:</td>
                    <td> {{$DetailTracking->docTracking->po->barang->nama_barang}}</td>
                </tr>
                <tr>
                    <td>Harga</td>
                    <td>:</td>
                    <td> 
                        @if ($DetailTracking->no_container == null)
                            Rp. {{number_format($DetailTracking->harga_hpp, 0, ',', '.')}},-KG
                            <br>
                        @else
                            Rp. {{number_format($DetailTracking->harga_hpp, 0, ',', '.')}},-KG
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>Nama Kapal & Tonase</td>
                    <td>:</td>
                    <td>
                        @foreach ($groupedData as $detailTracking)
                            @if ($detailTracking)
                            {{$detailTracking['kapal']}} {{$DetailTracking->voyage}} {{number_format($detailTracking['qty_tonase'] , 0, ',', '.')}} KG
                            @endif
                        @endforeach
                    </td>
                </tr>
                <tr>
                    <td>Total Qty</td>
                    <td>:</td>
                    <td>{{number_format($totalSum , 0, ',', '.')}} KG</td>
                </tr>
                <tr>
                    <td>Lain - Lain</td>
                    <td>:</td>
                    <td>
                        <ol type="A" style="margin: 0px;">
                            <li>Dilarang menggunakan gancu saat pembongkaran</li>
                            <li>Pihak transportir dimohon untuk membantu pengecekan barang sebagai berikut:</li>
                            <li>Jumlah barang / sak / warna karung sesuai dengan jumlah yang tertera didalam surat jalan</li>
                            <li>Barang tidak dalam kondisi BASAH dan karung TIDAK SOBEK</li>
                            <li>Info keberangkatan & Surat Ijin Berlayar max 1 hari sebelum kapal berangkat </li>
                            <li>Conosemen diberikan paling lambat 1 hari setelah selesai pemuatan digudang </li>
                            <li>Sparebag yang masuk harus tertera di dalam conosemen (jika tidak ada sparebag mohon di infokan ke pihak ekspedisi) </li>
                        </ol>
                    </td>
                </tr>
            </table>

            <p style="text-indent: 30px;">Demikian saya sampaikan kiranya pekerjaan dapat dilaksanakan dengan sebaik-baiknya dan penuh rasa tanggung jawab, atas perhatian dan kerjasamanya di ucapkan terima kasih.</p>

            <table id="ttd">
                <tr>
                    <td width="50%">Hormat kami,</td>
                    <td width="50%">Menyetujui</td>
                </tr>
                <tr>
                    <th>PT ADHIPRAMANA BAHARI PERKASA</th>
                    <th>{{$DetailTracking->kapal->cPort->nama}}</th>
                </tr>

                <tr>
                    <td style="padding-top: 60px"></td>
                </tr>

                <tr>
                    <td>BP DONNY LIMANTA </td>
                    <td></td>
                </tr>
            </table>
        </div>
    </div>
</body>
</html>
