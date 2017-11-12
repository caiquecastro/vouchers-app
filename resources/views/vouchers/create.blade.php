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
                        <select name="offer_id" id="offer" class="form-control">
                            @foreach ($offers as $offer)
                                <option value="{{ $offer->id }}">
                                    {{ $offer->name }} ({{ $offer->discount }}% OFF)
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="offer">Expires at</label>
                        <input type="datetime-local" class="form-control" name="expires_at">
                    </div>

                    <button type="submit" class="btn btn-primary">Generate</button>
                </form>
            </div>
        </div>
    </div>
@endsection