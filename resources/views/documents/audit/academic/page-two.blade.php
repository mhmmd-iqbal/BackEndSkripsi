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
    {{-- Section 2 --}}
    <div class="break-point"></div>
    <table  border="1px" width = "100%" style="border-collapse: collapse; padding-top: 10px" class="main-table">
        <tr>
            <th class="label-size" style="text-align: center">Audit</th>
            <th class="label-size" style="text-align: center" colspan="2">Tipe Audit</th>
            <th class="label-size" style="text-align: center" colspan="2">Standar Yang Digunakan</th>
        </tr>
        <tr>
            <td class="main-size" style="text-align: center">{{$audit->audit_title}} </td>
            <td class="main-size" style="text-align: center" colspan="2">{{$audit->audit_type}}</td>
            <td class="main-size" style="text-align: center" colspan="2">{{$audit->audit_standart}}</td>
        </tr>
        <tr>
            <th class="label-size" style="text-align: center">Nama Program Studi</th>
            <th class="label-size" style="text-align: center" colspan="2">Ruang Lingkup</th>
            <th class="label-size" style="text-align: center" colspan="2">Tanggal Audit</th>
        </tr>
        <tr>
            <td class="main-size" style="text-align: center">{{$audit->department->major->name}}</td>
            <td class="main-size" style="text-align: center" colspan="2">{{$audit->scope_type === 'academic' ? 'Akademik' : 'Non Akademik'}} </td>
            <td class="main-size" style="text-align: center" colspan="2">{{date('d M Y', strtotime($audit->created_at))}} </td>
        </tr>
        <tr>
            <th class="label-size" style="text-align: center" >Distribusi Dokumen</th>
            <th class="label-size" style="text-align: center" >Auditee</th>
            <th class="label-size" style="text-align: center" >Auditor</th>
            <th class="label-size" style="text-align: center" >P4M</th>
            <th class="label-size" style="text-align: center" >Ruang Arsip</th>
        </tr>
    </table>

    {{-- Section 3 --}}
    <div class="break-point"></div>
    <table  border="1px" width = "100%" style="border-collapse: collapse; padding-top: 10px" class="main-table">
        <tr>
            <th style="text-align: left; padding-left: 5px" class="label-size" width="30%">Jadwal Pelaksanaan Audit</th>
            <td style="text-align: left; padding-left: 5px" class="main-size">{{date('d M Y H:i:s', strtotime($audit->audit_at))}}</td>
        </tr>
        <tr>
            <th style="text-align: left; padding-left: 5px" class="label-size">Ketua Auditor</th>
            <td style="text-align: left; padding-left: 5px" class="main-size"{{$audit->auditor->name}}></td>
        </tr>
        <tr>
            <th style="text-align: left; padding-left: 5px" class="label-size" valign="top" height="20%">Anggota Auditor</th>
            <td style="text-align: left; padding-left: 5px" class="main-size" valign="top">
                <ol>
                @foreach ($audit->auditor_member_list as $auditor_member_list)
                    <li class="main-size">{{$auditor_member_list}}</li>
                @endforeach
                </ol>
            </td>
        </tr>
        <tr>
            <th style="text-align: left; padding-left: 5px" class="label-size">Auditee</th>
            <td style="text-align: left; padding-left: 5px" class="main-size">{{$audit->auditee->name}} </td>
        </tr>
    </table>
</div>