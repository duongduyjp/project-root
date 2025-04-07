@extends('layouts.app')

@section('title', 'ホーム')

@section('content')
<div class="container">
    <h1>ホーム</h1>
    <div class="row mt-4">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">現場</h5>
                    <p class="card-text">現場管理システム</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">配車</h5>
                    <p class="card-text">配車管理システム</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">見積もり</h5>
                    <p class="card-text">見積もり管理システム</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">受注出荷</h5>
                    <p class="card-text">受注出荷管理システム</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 