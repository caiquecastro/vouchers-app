@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">Generate Vouchers</h2>
            </div>
            <div class="card-body">
                <form action="/vouchers" method="POST">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="offer">Offer</label>
                        <select name="offer_id"
                                id="offer"
                                class="form-control{{ $errors->has('offer_id') ? ' is-invalid' : '' }}"
                        >
                            @foreach ($offers as $offer)
                                <option value="{{ $offer->id }}">
                                    {{ $offer->name }} ({{ $offer->discount }}% OFF)
                                </option>
                            @endforeach
                        </select>
                        @if ($errors->has('offer_id'))
                            <div class="invalid-feedback">
                                {{ $errors->first('offer_id') }}
                            </div>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="expires_at">Expires at</label>
                        <input type="datetime-local"
                               class="form-control{{ $errors->has('offer_id') ? ' is-invalid' : '' }}"
                               name="expires_at"
                               id="expires_at"
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