@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">Sửa từ vựng: {{ $vocabulary->word }}</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('vocabularies.update', $vocabulary) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="form-group mb-3">
                            <label for="topic_id">Chủ đề <span class="text-danger">*</span></label>
                            <select class="form-control @error('topic_id') is-invalid @enderror" 
                                    id="topic_id" name="topic_id" required>
                                <option value="">Chọn chủ đề</option>
                                @foreach($topics as $topic)
                                    <option value="{{ $topic->id }}" 
                                            {{ old('topic_id', $vocabulary->topic_id) == $topic->id ? 'selected' : '' }}>
                                        {{ $topic->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('topic_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="word">Từ tiếng Anh <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('word') is-invalid @enderror" 
                                   id="word" name="word" value="{{ old('word', $vocabulary->word) }}" 
                                   placeholder="Ví dụ: weather" required>
                            @error('word')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="sentences">Câu ví dụ</label>
                            <textarea class="form-control @error('sentences') is-invalid @enderror" 
                                      id="sentences" name="sentences" rows="3"
                                      placeholder="Nhập các câu ví dụ, mỗi câu một dòng.">{{ old('sentences', $vocabulary->sentences) }}</textarea>
                            @error('sentences')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="image">Hình ảnh</label>
                            @if($vocabulary->image_path)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/' . $vocabulary->image_path) }}" 
                                         alt="Current image" class="img-thumbnail" style="max-height: 150px;">
                                    <p class="text-muted small">Hình ảnh hiện tại</p>
                                </div>
                            @endif
                            <input type="file" class="form-control @error('image') is-invalid @enderror" 
                                   id="image" name="image" accept="image/*">
                            <small class="form-text text-muted">
                                Hỗ trợ: JPEG, PNG, JPG, GIF. Kích thước tối đa: 2MB. 
                                Để giữ nguyên hình ảnh hiện tại, không chọn file mới.
                            </small>
                            @error('image')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Cập nhật từ vựng
                            </button>
                            <a href="{{ route('vocabularies.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Quay lại
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 