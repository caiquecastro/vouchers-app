@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title">Vouchers</h6>
                <hr></hr>

                <div class="row text-center">
                    <div class="col">
                        {{ $totalVouchers }} <br>
                        <small>Total vouchers</small>
                    </div>
                    <div class="col">
                        {{ $usedVouchers }} <br>
                        <small>Used vouchers</small>
                    </div>
                    <div class="col">
                        {{ $unusedVouchers }}  <br>
                        <small>Unused vouchers</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-auto">
                        <a href="/vouchers/create" class="btn btn-primary">Add Voucher</a>
                    </div>
                    <div class="col-auto">
                        <form action="/">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-search" aria-hidden="true"></i>
                                </div>
                                <input type="text" class="form-control" name="q" placeholder="Search">
                            </div>
                        </form>
                    </div>
                    <div class="col-auto">
                        <button class="btn btn-default">
                            <i class="fa fa-cog" aria-hidden="true"></i>
                        </button>
                    </div>
                </div>
                
                <p class="mt-3">Found {{ $vouchers->total() }} results</p>

                <table class="table table-sm mt-3">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Code</th>
                            <th>Used</th>
                            <th>Recipient</th>
                            <th>Used at</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($vouchers as $voucher)
                        <tr>
                            <td></td>
                            <td>{{ $voucher->code }}</td>
                            <td>{{ $voucher->used_at ? 'Yes' : 'No' }}</td>
                            <td>{{ optional($voucher->recipient)->name }}</td>
                            <td>{{ $voucher->used_at }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                {{ $vouchers->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
@endsection