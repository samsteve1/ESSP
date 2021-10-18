@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <campaign-edit :campaign-resource="{{  $campaignResource}}"></campaign-edit>
    </div>
</div>
@endsection