@extends('documents.main')
@section('content')

@include('documents.audit.page-one', [
    'audite'        => $audit,
    'header'        => ['FORM LAPORAN', 'AUDIT MUTU INTERNAL', 'PROGRAM STUDI'],
    'no_document'   => '' 
    ])
@include('documents.audit.page-two',[
    'audite'    => $audit,
    'header'    => ['FORM PERENCANAAN AUIDT MUTU INTERNAL', 'PROGRAM STUDI'],
    'no_document'   => '-00'
    ])
@include('documents.audit.page-three', [
    'audite'    => $audit,
    'header'    => ['FORM BORANG AUDIT AKADEMIK INTERNAL', 'PROGRAM STUDI', 'DAFTAR PERTANYAAN/CHECKLIST'],
    'no_document'   => '-01'
    ])
@include('documents.audit.page-four', [
    'audite'    => $audit,
    'header'    => ['FORM BORANG AUDIT AKADEMIK INTERNAL', 'PROGRAM STUDI', 'DESKRIPSI TEMUAN AUDIT DAN', 'PERMINTAAN TINDAKAN KOREKSI (PTK)'],
    'no_document'   => '-02'
])

@endsection