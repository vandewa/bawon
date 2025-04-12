@extends('layouts.app')
@section('header')
    <div class="mb-2 row">
        <div class="col-sm-6">
            <h1 class="m-0">Rekap Laporan</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item active">Laporan</li>
                <li class="breadcrumb-item"><a href="#">Rekap Laporan</a></li>
            </ol>
        </div>
    </div>
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="card card-info card-outline card-tabs">
                    <form class="mt-2 form-horizontal" action="{{ route('store.triwulan') }}" method="post">
                        @csrf
                        <div class="card-header">
                            <h5>Triwulan</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-2 row">
                                <label for="inputEmail3" class="col-sm-3 col-form-label">Dari
                                    <small class="text-danger">*</small></label>
                                <div class="col-sm-9">
                                    <input type="date" class="form-control" name="start_date">
                                    @error('start_date')
                                        <span class="form-text text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-2 row">
                                <label for="inputEmail3" class="col-sm-3 col-form-label">Sampai
                                    <small class="text-danger">*</small></label>
                                <div class="col-sm-9">
                                    <input type="date" class="form-control" name="end_date">
                                    @error('end_date')
                                        <span class="form-text text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="mt-3 card-footer">
                            <button type="submit" class="btn btn-info">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-info card-outline card-tabs">
                    <form class="mt-2 form-horizontal" action="{{ route('store.global') }}" method="post">
                        @csrf
                        <div class="card-header">
                            <h5>Global</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-2 row">
                                <label for="inputEmail3" class="col-sm-12 col-form-label">Tahun
                                    <small class="text-danger">*</small>
                                </label>
                                <div class="col-sm-12">
                                    <input type="number" name="tahun" class="form-control" placeholder="Contoh:2024">
                                </div>
                            </div>
                        </div>
                        <div class="mt-3 card-footer">
                            <button type="submit" class="btn btn-info">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
