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
            <th class="label-size" style="text-align: center" width="50%" colspan="2">Auditee</th>
            <th class="label-size" style="text-align: center" width="50%" colspan="3">Ketua Auditor</th>
        </tr>
        <tr>
            <td class="main-size" style="text-align: center" colspan="2">{{$audit->auditee->name}}</td>
            <td class="main-size" style="text-align: center" colspan="3">{{$audit->auditor->name}}</td>
        </tr>
        <tr>
            <th class="label-size" style="text-align: center">Distribusi Dokumen</th>
            <th class="label-size" style="text-align: center" >Auditee</th>
            <th class="label-size" style="text-align: center" >Auditor</th>
            <th class="label-size" style="text-align: center" >P4M</th>
            <th class="label-size" style="text-align: center" >Ruang Arsip</th>
        </tr>
    </table>

    {{-- Section 2 --}}
    <div class="break-point"></div>
    <table  border="1px" width = "100%" style="border-collapse: collapse; padding-top: 10px" class="main-table">
        <tr>
            <th class="label-size" style="text-align: center" rowspan="2">No </th>
            <th class="label-size" style="text-align: center" rowspan="2" width="25%">Referensi </th>
            <th class="label-size" style="text-align: center" rowspan="2" width="30%">Pertanyaan </th>
            <th class="label-size" style="text-align: center" colspan="2">Bukti </th>
        </tr>
        <tr>
            <th class="label-size" style="text-align: center">Ya / Tidak </th>
            <th class="label-size" style="text-align: center" width="30%">Keterangan </th>
        </tr>
        @foreach ($audit->results as $result)
        <tr>
            <td class="main-size" style="text-align: left"> </td>
            <td class="main-size" style="text-align: left">
                <div>
                    {{$result->instrumentOrigin->subTopic->topic->name}} 
                </div>
                <div>
                    {{$result->instrumentOrigin->subTopic->name}}
                </div>
            </td>
            <td class="main-size" style="text-align: left">{{$result->instrument}} </td>
            <td class="main-size" style="text-align: left">{{$result->approval ? 'Ya' : 'Tidak'}} </td>
            <td class="main-size" style="text-align: left">{{$result->description}}</td>
        </tr>
        @endforeach
    </table>
</div>