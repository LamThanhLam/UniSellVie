@extends('layouts.app')

@section('content')

    <div class="container">
        <h1>Add New Game</h1>

        @if ($errors->any())
            <div>
                <strong>Lỗi:</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('products.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="title">Titile:</label>
                <input type="text" id="title" name="title" value="{{ old('title') }}" required>
                @error('title') <span class="error">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label for="releaseDate">Release date:</label>
                <input type="date" id="releaseDate" name="releaseDate" value="{{ old('releaseDate') }}" required>
                @error('releaseDate') <span class="error">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label for="developer">Developer:</label>
                <input type="text" id="developer" name="developer" value="{{ old('developer') }}" required>
                @error('developer') <span class="error">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label for="publisher">Publisher:</label>
                <input type="text" id="publisher" name="publisher" value="{{ old('publisher') }}" required>
                @error('publisher') <span class="error">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label for="description">Description:</label>
                <textarea id="description" name="description">{{ old('description') }}</textarea>
                @error('description') <span class="error">{{ $message }}</span> @enderror
            </div>
            <div class="form-group mb-4">
                <label><strong>Platforms:</strong></label><br>
                @foreach ($platforms as $platform)
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" name="platform_ids[]" id="platform_{{ $platform->id }}" value="{{ $platform->id }}">
                        <label class="form-check-label" for="platform_{{ $platform->id }}">{{ $platform->name }}</label>
                    </div>
                @endforeach
                @error('platform_ids')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group mb-4">
                <label><strong>Genres:</strong></label><br>
                @foreach ($genres as $genre)
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" name="genre_ids[]" id="genre_{{ $genre->id }}" value="{{ $genre->id }}">
                        <label class="form-check-label" for="genre_{{ $genre->id }}">{{ $genre->name }}</label>
                    </div>
                @endforeach
                @error('genre_ids')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="content">About This Game</label>
                <textarea name="content" id="content" class="form-control" rows="8">{{ $product->content ?? '' }}</textarea>
            </div>

            <div class="form-group">
                <label for="system_requirements">System Requirements</label>
                <textarea name="system_requirements" id="system_requirements" class="form-control" rows="4">{{ $product->system_requirements ?? '' }}</textarea>
            </div>
            <div class="form-group">
                <label for="price">Price</label>
                <input type="number" step="0.01" name="price" id="price" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary">Add the game</button>
            <a href="{{ route('products.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>

@endsection