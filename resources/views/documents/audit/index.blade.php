@extends('documents.main')
@section('content')

@include('documents.audit.page-one', $audit)
@include('documents.audit.page-two')
@include('documents.audit.page-three')
@include('documents.audit.page-four')

@endsection