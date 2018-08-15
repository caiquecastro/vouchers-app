@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">Generate Vouchers</h2>
            </div>
            <div class="card-body">
                <form action="/vouchers" method="POST">
                    @if ($errors->any())
                        <div class="alert alert-danger">There were errors on your request to create the offer</div>
                    @endif

                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="offer_name">Offer Name</label>
                        <input name="offer_name"
                               type="text"
                               id="offer_name"
                               class="form-control{{ $errors->has('offer_name') ? ' is-invalid' : '' }}"
                               value="{{ old('offer_name') }}"
                        >
                        @if ($errors->has('offer_name'))
                            <div class="invalid-feedback">
                                {{ $errors->first('offer_name') }}
                            </div>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="offer_discount">Offer Discount</label>
                        <input name="offer_discount"
                               type="text"
                               id="offer_discount"
                               class="form-control{{ $errors->has('offer_discount') ? ' is-invalid' : '' }}"
                               value="{{ old('offer_discount') }}"
                        >
                        @if ($errors->has('offer_discount'))
                            <div class="invalid-feedback">
                                {{ $errors->first('offer_discount') }}
                            </div>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="expires_at">Expires at</label>
                        <input type="datetime-local"
                               class="form-control{{ $errors->has('expires_at') ? ' is-invalid' : '' }}"
                               name="expires_at"
                               id="expires_at"
                               value="{{ old('expires_at') }}"
                        >
                        @if ($errors->has('expires_at'))
                            <div class="invalid-feedback">
                                {{ $errors->first('expires_at') }}
                            </div>
                        @endif
                    </div>

                    <button type="submit" class="btn btn-primary">Generate</button>
                </form>
            </div>
        </div>
    </div>
@endsection