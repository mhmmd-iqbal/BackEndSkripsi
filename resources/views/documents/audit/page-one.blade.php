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
    {{-- section 2 --}}
    <div class="break-point"></div>
    <table width="100%">
        <tr>
            <td class="label-size" width=10%>
                I
            </td>
            <td class="label-size">
                PENDAHULUAN
            </td>
        </tr>
    </table>

    <table style="border-collapse: collapse" border="1px" width="100%">
        <tr>
            <th class="label-size" width="20%" style="text-align: left; padding-left: 5px">Jurusan</th>
            <td colspan="3" class="main-size" style="text-align: left; padding-left: 5px">{{$audit->department->major->name}}</td>
        </tr>
        <tr>
            <th class="label-size" width="20%" style="text-align: left; padding-left: 5px">Program Studi</th>
            <td colspan="3" class="main-size" style="text-align: left; padding-left: 5px">{{$audit->department->name}}</td>
        </tr>
        <tr>
            <th class="label-size" width="20%" style="text-align: left; padding-left: 5px">Alamat</th>
            <td colspan="3" class="main-size" style="text-align: left; padding-left: 5px">Politeknik Negeri Lhokseumawe, Buket Rata, Lhokseumawe</td>
        </tr>
        <tr>
            <th class="label-size" width="20%" style="text-align: left; padding-left: 5px">Kaprodi</th>
            <td class="main-size" style="text-align: left; padding-left: 5px">{{$audit->auditee->name}}</td>
            <td colspan="2" class="main-size" style="text-align: left; padding-left: 5px">{{$audit->auditee->phone}}</td>
        </tr>
        <tr>
            <th class="label-size" width="20%" style="text-align: left; padding-left: 5px">Tanggal Audit</th>
            <td colspan="3" class="main-size" style="text-align: left; padding-left: 5px">{{date('d M Y H:i:s', strtotime($audit->audit_at))}}</td>
        </tr>
        <tr>
            <th class="label-size" width="20%" style="text-align: left; padding-left: 5px">Ketua Auditor</th>
            <td colspan="3" class="main-size" style="text-align: left; padding-left: 5px">{{$audit->auditor->name}}</td>
        </tr>
        <tr>
            <th class="label-size" width="20%" style="text-align: left; padding-left: 5px">Tanda Tangan Ketua Auditor</th>
            <td></td>
            <td class="label-size" width="20%" style="text-align: left; padding-left: 5px">Tanda Tangan Ketua Auditor</td>
            <td></td>
        </tr>
    </table>

    {{-- section 3 --}}
    <div class="break-point"></div>
    <table width="100%">
        <tr>
            <td class="label-size" width=10%>
                II
            </td>
            <td class="label-size">
                TEMUAN POSITIF (TP)
            </td>
        </tr>
    </table>
    <ol>
        @foreach ($audit->positive_issue as $positive_issue)
            <li class="main-size">{{$positive_issue}}</li>
        @endforeach
    </ol>
   
    {{-- section 4 --}}
    <div class="break-point"></div>
    <table width="100%">
        <tr>
            <td class="label-size" width=10%>
                III
            </td>
            <td class="label-size">
                RINGKASAN TEMUAN AUDIT
            </td>
        </tr>
    </table>

    <table style="border-collapse: collapse" border="1px" width="100%">
    <tr>
            <th class="label-size" rowspan="2">No</th>
            <th class="label-size" rowspan="2">Uraian Temuan</th>
            <th class="label-size" colspan="3">Kategori Temuan</th>
            <th class="label-size" rowspan="2">Nomer PTK</th>
    </tr>
    <tr>
            <th class="label-size">OB</th>
            <th class="label-size">KTS Mi</th>
            <th class="label-size">KTS Ma</th>
    </tr>
    @php
        $no = 1;
        @endphp
    @foreach ($audit->reject as $reject)
        <tr>
            <td class="main-size" align="center">{{$no++}}</td>
            <td class="main-size" style="padding-left: 5px">{{$reject->finding_description}} </td>
            <td class="main-size" align="center">{{$reject->category === 'observasi' ? 'V' : ''}} </td>
            <td class="main-size" align="center">{{$reject->category === 'kts_minor' ? 'V' : ''}} </td>
            <td class="main-size" align="center">{{$reject->category === 'kts_mayor' ? 'V' : ''}} </td>
            <td class="main-size" style="padding-left: 5px"></td>           
        </tr>
    @endforeach
    </table>

    {{-- section 5 --}}
    <div class="break-point"></div>
    <table width="100%">
        <tr>
            <td class="label-size" width=10%>
                IV
            </td>
            <td class="label-size">
                KESIMPULAN AUDIT
            </td>
        </tr>
    </table>
    <ol>
        @foreach ($audit->conclusion as $conclusion)
            <li class="main-size">{{$conclusion}}</li>
        @endforeach
    </ol>

    {{-- section 6 --}}
    <div class="break-point"></div>
    <table width="100%">
        <tr>
            <td class="label-size" width=10%>
                V
            </td>
            <td class="label-size">
                LAMPIRAN AUDIT
            </td>
        </tr>
    </table>
    <ol>
        <li class="main-size">
            {{$audit->document_no}}-00
        </li>
        <li class="main-size">
            {{$audit->document_no}}-01
        </li>
        <li class="main-size">
            {{$audit->document_no}}-02
        </li>
        <li class="main-size">
            {{$audit->document_no}}-03
        </li>
        <li class="main-size">
            {{$audit->document_no}}-04
        </li>
        <li class="main-size">
            {{$audit->document_no}}-05
        </li>
    </ol>
</div>