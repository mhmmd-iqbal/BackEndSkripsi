@foreach ($audit->reject as $reject)
<div class="wrapper-page">
    <header>
        <table border="1px" width = "100%" style="border-collapse: collapse; padding-top: 10px" class="main-table">
            <tr style="border-top: 1px solid black">
                <td width="20%" style="text-align: center">
                    <img src="{{ public_path('img/poltek.png')}}" width="80px" height="80px" />
                </td>
                <td colspan="2" style="text-align: center">
                    <div class="label-size">
                        KEMENTERIAN PENDIDIKAN DAN KEBUDAYAAN
                    </div>
                    <div class="title-size">
                        POLITEKNIK NEGERI LHOKSEUMAWE
                    </div>
                    <div class="main-size">
                        Jalan Banda Aceh-Medan Km. 280,3 Buketrata, Lhokseumawe, 24301 PO.BOX 90
                    </div>
                    <div class="main-size">
                        Telepon: (0645) 42785 Fax: 42785, Laman: www.pnl.ac.id
                    </div>
                </td>
            </tr>
            <tr>
                <td colspan="2" width="80%" style="text-align: center">
                    @foreach ($header as $item)
                    <div class="label-size">
                        {{$item}}
                    </div>
                    @endforeach
                </td>
                <td>
                    <table class="child-table" border="0">
                        <tr>
                            <td class="main-size" style="padding-right: 20px">No. Dok</td>
                            <td class="main-size">:</td>
                            <td class="main-size">{{$audit->document_no}}{{$no_document}}</td>
                        </tr>
                        <tr>
                            <td class="main-size" style="padding-right: 20px">Revisi</td>
                            <td class="main-size">:</td>
                            <td class="main-size"></td>
                        </tr>
                        <tr>
                            <td class="main-size" style="padding-right: 20px">Tgl Eff</td>
                            <td class="main-size">:</td>
                            <td class="main-size">{{date('d M Y', strtotime($audit->created_at))}} </td>
                        </tr>
                        <tr>
                            <td class="main-size" style="padding-right: 20px">Jlh Hal</td>
                            <td class="main-size">:</td>
                            <td class="main-size"></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </header>
    {{-- Looping For Each Temuan For This Audit Form --}}
    {{-- Section 2 --}}
    <div class="break-point"></div>
    <table  border="1px" width = "100%" style="border-collapse: collapse; padding-top: 10px" class="main-table">
        <tr>
            <th style="text-align: left; padding-left: 5px" class="label-size" width="20%">Kategori Temuan</th>
            <td style="text-align: left; padding-left: 5px" class="main-size">{{ucwords(preg_replace('/\s+/', '_', $reject->category))}}</td>
        </tr>
        <tr>
            <th style="text-align: left; padding-left: 5px" class="label-size">PTK No</th>
            <td style="text-align: left; padding-left: 5px" class="main-size"></td>
        </tr>
        <tr>
            <th style="text-align: left; padding-left: 5px" class="label-size">Ka.Bag/Ka.Sub.Bag/Ka.UPT</th>
            <td style="text-align: left; padding-left: 5px" class="main-size">{{$reject->department->name}}</td>
        </tr>
    </table>

    <div class="break-point"></div>
    <table  border="1px" width = "100%" style="border-collapse: collapse; padding-top: 10px" class="main-table">
        <tr>
            <th style="text-align: left; padding-left: 5px" class="label-size" width="20%">Referensi</th>
            <td style="text-align: left; padding-left: 5px" class="main-size" >{{$reject->instrument_topic_name}} </td>
        </tr>
        <tr>
            <th style="text-align: left; padding-left: 5px" class="label-size" colspan="2">Deskripsi Temuan</th>
        </tr>
        <tr>
            <td style="text-align: left; padding-left: 5px" class="main-size" height="30px" valign="middle" colspan="2">{{$reject->finding_description}}</td>
        </tr>
        <tr>
            <th style="text-align: left; padding-left: 5px" class="label-size" colspan="2">Akar Penyebab</th>
        </tr>
        <tr>
            <td style="text-align: left; padding-left: 5px" class="main-size" height="30px" valign="middle" colspan="2">{{$reject->root_caused_description}} </td>
        </tr>
        <tr>
            <th style="text-align: left; padding-left: 5px" class="label-size" colspan="2">Akibat</th>
        </tr>
        <tr>
            <td style="text-align: left; padding-left: 5px" class="main-size" height="30px" valign="middle" colspan="2">{{$reject->consequence_description}} </td>
        </tr>
    </table>
    <div class="break-point"></div>
    <table  border="1px" width = "100%" style="border-collapse: collapse; padding-top: 10px" class="main-table">
        <tr>
            <th style="text-align: left; padding-left: 5px" class="label-size" colspan="3">Rencana Tindakan Perbaikan dan Jadual penyelesaian </th>
        </tr>
        <tr>
            <td style="text-align: left; padding-left: 5px" class="main-size" height="30px" valign="middle" colspan="3">{{$reject->action_plane ?? '-'}} </td>
        </tr>
        <tr>
            <th style="text-align: left; padding-left: 5px" class="label-size">Ketua Auditor</th>
            <th style="text-align: left; padding-left: 5px" class="label-size">Tanda Tangan</th>
            <th style="text-align: left; padding-left: 5px" class="label-size">Tanggal Audit</th>
        </tr>
        <tr>
            <td style="text-align: left; padding-left: 5px" height="30px" class="main-size">{{$reject->auditor_name}}</td>
            <td style="text-align: left; padding-left: 5px" height="30px" class="main-size">{{$reject->auditee_name}} </td>
            <td style="text-align: left; padding-left: 5px" height="30px" class="main-size">                {{date('d M Y H:i:s', strtotime($audit->audit_at))}}</td>
        </tr>
    </table>
</div>  
@endforeach