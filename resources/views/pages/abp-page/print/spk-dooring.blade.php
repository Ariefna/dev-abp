<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Surat Penunjukan Kerja {{$DetailDooring->detailTracking->docTracking->po->detailPhs->penerima->ptPenerima->nama_penerima}}</title>
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

        table#rincian-tabel {
            width: 100%;
            border-collapse: collapse;
        }

        table#rincian-tabel,
        table#rincian-tabel th,
        table#rincian-tabel td {
            border: 1px solid black;
        }
        table#rincian-tabel td {
            text-align: center;
            padding-left: 8px;
            padding-right: 8px;
        }
        table#rincian-tabel th {
            font-size: 15px;
            padding-left: 8px;
            padding-right: 8px;
        }

    </style>
</head>
<body>
    <div id="bg-image">
        <div id="content">
            <p style="text-align: right">Surabaya, {{$tgl_spk}}</p>

            <table>
                <tr>
                    <td>Nomor</td>
                    <td>: {{$nomor}}</td>
                </tr>
                <tr>
                    <td>Hal</td>
                    <td>
                        : <b>Pembongkaran & Pengiriman Barang Dari Port {{$DetailDooring->detailTracking->docTracking->portOfDestination->nama_pod}} ke Estate</b>
                    </td>
                </tr>
            </table>

            <p style="width: 50%">
                Kepada Yth.
                <br>
                <b>{{$DetailDooring->detailTracking->docTracking->po->detailPhs->penerima->ptPenerima->nama_penerima}}</b>
                <br>
                {{$DetailDooring->detailTracking->docTracking->po->detailPhs->penerima->alamat}}
            </p>

            <p style="text-align: center; padding-top: 10px"><b>SURAT PENUNJUKAN KERJA / KONTRAK KERJA</b></p>

            <p style="text-indent: 30px; text-align: justify;">
                Dengan ini kami menunjuk 
                <b>{{$DetailDooring->detailTracking->docTracking->po->detailPhs->penerima->ptPenerima->nama_penerima}}</b>
                untuk melakukan pembongkaran & pengiriman
                pupuk ke estate sesuai data di bawah ini dengan uraian sebagai berikut:
            </p>

            <table id="detail">
                <tr>
                    <td style="width: 100px">Rincian Barang</td>
                    <td>:</td>
                    <td>
                        <table id="rincian-tabel">
                            <tr>
                                <th style="background-color: yellow">KEBUN</th>
                                <th style="background-color: yellow">PO KEBUN</th>
                                <th style="background-color: yellow">NO.PO</th>
                                <th style="background-color: yellow">TONASE PO</th>
                                <th style="background-color: yellow">COMODITY</th>
                            </tr>
                            @foreach ($DocDooring->detailDooring as $item)
                            <tr>
                                <td>{{$item->estate}}</td>
                                <td>{{$item->detailTracking->docTracking->po->po_kebun}}</td>
                                <td>{{$item->detailTracking->docTracking->po->po_muat}}</td>
                                <td style="text-align: right !important">{{number_format($item->qty_tonase, 0, ',', '.')}}</td>
                                <td>{{$item->detailTracking->docTracking->po->barang->nama_barang}}</td>
                            </tr>
                            @endforeach
                            <tr>
                                <th colspan="3" style="text-align: right"><b>TOTAL QTY</b></th>
                                <th style="text-align: right; padding-"><b>{{$DocDooring->detailDooring->sum('qty_tonase')}}</b></th>
                                <th></th>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>Pembayaran</td>
                    <td>:</td>
                    <td> 
                        50% saat proses dooring
                        <br>
                        50% saat BAP di terima di Surabaya 
                    </td>
                </tr>
                <tr>
                    <td>Nama Kapal</td>
                    <td>:</td>
                    <td>
                        {{$DetailDooring->detailTracking->kapal->kode_kapal}} {{$DetailDooring->detailTracking->kapal->nama_kapal}} TD: {{strtoupper($tgl_td)}}
                    </td>
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
                    <th>{{$DetailDooring->detailTracking->docTracking->po->detailPhs->penerima->ptPenerima->nama_penerima}}</th>
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
