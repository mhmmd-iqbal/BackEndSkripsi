@extends('documents.main')
@section('content')

@if ($audit->scope_type === 'academic')
@include('documents.audit.non-academic.page-one', [
    'audite'        => $audit,
    'header'        => ['FORM LAPORAN', 'AUDIT MUTU INTERNAL', 'PROGRAM STUDI'],
    'no_document'   => '' 
    ])
@include('documents.audit.academic.page-two',[
    'audite'    => $audit,
    'header'    => ['FORM PERENCANAAN AUIDT MUTU INTERNAL', 'PROGRAM STUDI'],
    'no_document'   => '-00'
    ])
@include('documents.audit.academic.page-three', [
    'audite'    => $audit,
    'header'    => ['FORM BORANG AUDIT AKADEMIK INTERNAL', 'PROGRAM STUDI', 'DAFTAR PERTANYAAN/CHECKLIST'],
    'no_document'   => '-01'
    ])
@include('documents.audit.academic.page-four', [
    'audite'    => $audit,
    'header'    => ['FORM BORANG AUDIT AKADEMIK INTERNAL', 'PROGRAM STUDI', 'DESKRIPSI TEMUAN AUDIT DAN', 'PERMINTAAN TINDAKAN KOREKSI (PTK)'],
    'no_document'   => '-02'
])  
@else
@include('documents.audit.non-academic.page-one', [
    'audite'        => $audit,
    'header'        => ['FORM LAPORAN', 'AUDIT MUTU INTERNAL', 'NON AKADEMIK'],
    'no_document'   => '' 
    ])
@include('documents.audit.non-academic.page-two',[
    'audite'    => $audit,
    'header'    => ['FORM PERENCANAAN AUIDT MUTU INTERNAL', 'NON AKADEMIK'],
    'no_document'   => '-00'
    ])
@include('documents.audit.non-academic.page-three', [
    'audite'    => $audit,
    'header'    => ['FORM BORANG AUDIT MUTU INTERNAL', 'NON AKADEMIK', 'DAFTAR PERTANYAAN/CHECKLIST'],
    'no_document'   => '-01'
    ])
@include('documents.audit.non-academic.page-four', [
    'audite'    => $audit,
    'header'    => ['FORM BORANG AUDIT MUTU INTERNAL', 'NON AKADEMIK', 'DESKRIPSI TEMUAN AUDIT DAN', 'PERMINTAAN TINDAKAN KOREKSI (PTK)'],
    'no_document'   => '-02'
])  
    
@endif

@endsection