@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <h1>{{ $product->title }}</h1>
                <p><strong>Price:</strong> {{ number_format($product->price) }} $</p>
                </div>
        </div>

        <hr>
        <div class="card">
            <!-- <div class="card-header">
                {{ $product->title }}
            </div> -->
            <div class="card-body">
                <p><strong>Released date:</strong> {{ $product->releaseDate->format('m/d/Y') }}</p>
                <p><strong>Developer:</strong> {{ $product->developer }}</p>
                <p><strong>Publisher:</strong> {{ $product->publisher }}</p>
                <p><strong>Description:</strong> {{ $product->description }}</p>

                {{-- Display Platforms --}}
                <p>
                    <strong>Platforms:</strong>
                    @if ($product->platforms->count())
                        @foreach ($product->platforms as $platform)
                            <span class="badge bg-secondary">{{ $platform->name }}</span>
                        @endforeach
                    @else
                        <span>There is no assigned platform.</span>
                    @endif
                </p>

                {{-- Display Genres --}}
                <p>
                    <strong>Genres:</strong>
                    @if ($product->genres->count())
                        @foreach ($product->genres as $genre)
                            <span class="badge bg-info">{{ $genre->name }}</span>
                        @endforeach
                    @else
                        <span>There is no assigned genre.</span>
                    @endif
                </p>

                {{-- Display About This Game (Content) --}}
                <h2>About This Game</h2>
                <div>
                    {!! nl2br(e($product->content)) !!} {{-- Use nl2br to keep line break formatting --}}
                </div>

                {{-- Display system requirements --}}
                <h2>System Requirements</h2>
                <div>
                    {!! nl2br(e($product->system_requirements)) !!}
                </div>
                <p><strong>Price:</strong> {{ number_format($product->price, 2) }}</p>
            </div>
            <div class="card-footer">
                @can('update', $product)
                    <a href="{{ route('products.edit', $product->id) }}" class="btn btn-info btn-sm">
                    <i class="fa fa-pen me-0"></i> Update</a>
                @endcan
                {{-- Check if user has logged in --}}
                @auth 
                    @if ($isOwned)
                        {{-- If user have already owned this game --}}
                        <button class="btn btn-success btn-lg disabled" disabled>
                            <i class="fas fa-check"></i> Already owned
                        </button>
                    @else
                        {{-- If not purchased, display add to cart button --}}
                        <form action="{{ route('cart.store', $product->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-cart-plus"></i> Add to cart ({{ number_format($product->price, 0, ',', '.') }} $)
                            </button>
                        </form>
                    @endif
                @else
                    {{-- If users have not logged in, encourage them to login to purchase --}}
                    <a href="{{ route('login') }}" class="btn btn-primary btn-lg">
                        Login to purchase ({{ number_format($product->price, 0, ',', '.') }} $)
                    </a>
                @endauth
                <a href="{{ route('products.index') }}" class="btn btn-info btn-sm">Return</a>
            </div>
        </div>
    </div>
@endsection