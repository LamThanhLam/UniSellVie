@extends('layouts.app')

@section('content')

<div class="container-fluid pt-4 px-4">
    <div class="col-sm-12 col-xl-10">
        <div class="bg-secondary rounded h-100 p-4">    
            <h1>Add New Game</h1>

            @if ($errors->any())
                <div>
                    <strong>Error:</strong>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('products.store') }}" method="POST">
                @csrf
                <div class="row mb-3">
                    <label for="title" class="col-sm-2 col-form-label">Titile:</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}" required>
                    </div>
                    @error('title') <span class="error">{{ $message }}</span> @enderror
                </div>
                
                <!-- Calendar area -->
                <div class="row mb-3">
                    <label for="releaseDate" class="col-sm-2 col-form-label">Release date:</label>
                    
                    <div class="col-md-6 p-0"> 
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
                    </div>
                    @error('releaseDate') <span class="error text-danger">{{ $message }}</span> @enderror
                </div>

                <script>
                    $(document).ready(function() {
                        // Initiate Datepicker, only allow picking date
                        $('#datetimepicker').datetimepicker({
                            format: 'MM/DD/YYYY', // example: 11/04/2025
                            viewMode: 'days', // Start at date picking mode
                            useCurrent: false, // Not picking current date
                            closeOnSelect: false,
                            sideBySide: false, // Turn off the mode of picking date and hour at the same time

                            buttons: {
                                showToday: true,  // Add "Today" button
                                showClear: true,  // Add "Delete" button
                                showClose: true, // Add "Close" button (work like a confirm button)
                                showToggle: false, // Turn off toggle Date/Time
                                showTime: false,   // Turn off display button off Time
                            },
                            icons: {
                                date: 'fa fa-calendar',
                                up: 'fa fa-arrow-up',
                                down: 'fa fa-arrow-down',
                                previous: 'fa fa-chevron-left',
                                next: 'fa fa-chevron-right',
                                today: 'fa fa-crosshairs',
                                clear: 'fa fa-trash'
                            },
                            // This is an important option to erase hour
                            // Tempus Dominus will automatically filter out the hour if the format does not carry hour/minute
                        });
                    });
                </script>
                <!-- End of calendar area -->

                <div class="row mb-3">
                    <label for="developer" class="col-sm-2 col-form-label">Developer:</label>
                    <input type="text" class="form-control" id="developer" name="developer" value="{{ old('developer') }}" required>
                    @error('developer') <span class="error">{{ $message }}</span> @enderror
                </div>
                <div class="row mb-3">
                    <label for="publisher" class="col-sm-2 col-form-label">Publisher:</label>
                    <input type="text" class="form-control" id="publisher" name="publisher" value="{{ old('publisher') }}" required>
                    @error('publisher') <span class="error">{{ $message }}</span> @enderror
                </div>
                <div class="row mb-3">
                    <label for="description" class="col-sm-2 col-form-label">Description:</label>
                    <textarea id="description" class="form-control" name="description">{{ old('description') }}</textarea>
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
                    <label for="content" class="col-sm-2 col-form-label">About This Game</label>
                    <textarea name="content" class="form-control" id="content" class="form-control" rows="8">{{ $product->content ?? '' }}</textarea>
                </div>

                <div class="form-group">
                    <label for="system_requirements" class="col-sm-2 col-form-label">System Requirements</label>
                    <textarea name="system_requirements" class="form-control" id="system_requirements" class="form-control" rows="4">{{ $product->system_requirements ?? '' }}</textarea>
                </div>
                <div class="form-group">
                    <label for="price" class="col-sm-2 col-form-label">Price</label>
                    <input type="number" class="form-control" step="0.01" name="price" id="price" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-primary">Add the game</button>
                <a href="{{ route('products.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>

@endsection