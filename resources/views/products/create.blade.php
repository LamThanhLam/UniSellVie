@extends('layouts.app')

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="col-12">
        <div class="bg-secondary rounded h-100 p-4"> 
            <h1 class="mb-4">Add New Game</h1>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Error:</strong> Please check the input information again.
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('products.store') }}" method="POST">
                @csrf
                
                <div class="row">
                    <div class="col-md-6">
                        {{-- 1. TITLE --}}
                        <div class="form-group mb-3">
                            <label for="title" class="form-label">Title:</label>
                            <input type="text" class="form-control bg-dark border-0" id="title" name="title" value="{{ old('title') }}" required>
                            @error('title') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        {{-- 2. RELEASE DATE (DATE PICKER) --}}
                        <div class="form-group mb-3">
                            <label for="releaseDate" class="form-label">Release date:</label>
                            <div class="col-md-8 p-0"> 
                                <div class="input-group date" id="datetimepicker" data-target-input="nearest">
                                    <input type="text" 
                                        class="form-control datetimepicker-input bg-dark border-0" 
                                        name="releaseDate" 
                                        value="{{ old('releaseDate') }}" 
                                        data-target="#datetimepicker" 
                                        required/>
                                    <div class="input-group-append" 
                                        data-target="#datetimepicker" 
                                        data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>
                                @error('releaseDate') <span class="error text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        {{-- 3. DEVELOPER --}}
                        <div class="form-group mb-3">
                            <label for="developer" class="form-label">Developer:</label>
                            <input type="text" class="form-control bg-dark border-0" id="developer" name="developer" value="{{ old('developer') }}" required>
                            @error('developer') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        {{-- 4. PUBLISHER --}}
                        <div class="form-group mb-3">
                            <label for="publisher" class="form-label">Publisher:</label>
                            <input type="text" class="form-control bg-dark border-0" id="publisher" name="publisher" value="{{ old('publisher') }}" required>
                            @error('publisher') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        {{-- 5. PRICE --}}
                        <div class="form-group mb-3">
                            <label for="price" class="form-label">Price</label>
                            <input type="number" class="form-control bg-dark border-0" step="0.01" name="price" id="price" value="{{ old('price') }}" required>
                            @error('price') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div> {{-- End col-md-6 Left Side --}}
                    
                    <div class="col-md-6">
                        {{-- 6. PLATFORMS CHECKBOXES --}}
                        <div class="form-group mb-3">
                            <label><strong>Platforms:</strong></label><br>
                            @foreach ($platforms as $platform)
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="platform_ids[]" value="{{ $platform->id }}" {{ in_array($platform->id, old('platform_ids', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label">{{ $platform->name }}</label>
                                </div>
                            @endforeach
                            @error('platform_ids') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>

                        {{-- 7. GENRES CHECKBOXES --}}
                        <div class="form-group mb-3">
                            <label><strong>Genres:</strong></label><br>
                            @foreach ($genres as $genre)
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="genre_ids[]" value="{{ $genre->id }}" {{ in_array($genre->id, old('genre_ids', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label">{{ $genre->name }}</label>
                                </div>
                            @endforeach
                            @error('genre_ids') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>

                        {{-- 8. SHORT DESCRIPTION --}}
                        <div class="form-group mb-3">
                            <label for="description" class="form-label">Short Description:</label>
                            <textarea name="description" class="form-control bg-dark border-0" rows="3">{{ old('description') }}</textarea>
                            @error('description') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        
                        {{-- 9. ABOUT THIS GAME (Content) --}}
                        <div class="form-group mb-3">
                            <label for="content" class="form-label">About This Game (Detailed Content):</label>
                            <textarea name="content" class="form-control bg-dark border-0" rows="6">{{ old('content') }}</textarea>
                            @error('content') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        
                        {{-- 10. SYSTEM REQUIREMENTS --}}
                        <div class="form-group mb-3">
                            <label for="system_requirements" class="form-label">System Requirements:</label>
                            <textarea name="system_requirements" class="form-control bg-dark border-0" rows="4">{{ old('system_requirements') }}</textarea>
                            @error('system_requirements') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div> {{-- End col-md-6 Right Side --}}
                </div> {{-- End row --}}

                {{-- CONFIRMATION --}}
                <button type="submit" class="btn btn-primary mt-4">Add the game</button>
                <a href="{{ route('products.index') }}" class="btn btn-secondary mt-4">Cancel</a>
            </form>
            
            <script>
                $(document).ready(function() {
                    $('#datetimepicker').datetimepicker({
                        format: 'MM/DD/YYYY', 
                        viewMode: 'days', 
                        useCurrent: false,
                        closeOnSelect: false,
                        sideBySide: false,
                        buttons: { showToday: true, showClear: true, showClose: true },
                        icons: {
                            date: 'fa fa-calendar', up: 'fa fa-arrow-up', down: 'fa fa-arrow-down',
                            previous: 'fa fa-chevron-left', next: 'fa fa-chevron-right',
                            today: 'fa fa-crosshairs', clear: 'fa fa-trash', close: 'fa fa-times'
                        },
                    });
                });
            </script>
        </div>
    </div>
</div>
@endsection