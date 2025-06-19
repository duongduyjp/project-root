@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Quản lý Từ vựng</h4>
                    <a href="{{ route('vocabularies.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Thêm từ vựng mới
                    </a>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if($vocabularies->count() > 0)
                        @php
                            $groupedVocabularies = $vocabularies->groupBy('topic_id');
                        @endphp
                        
                        @foreach($groupedVocabularies as $topicId => $topicVocabularies)
                            @php
                                $topic = $topicVocabularies->first()->topic;
                            @endphp
                            
                            <div class="mb-4">
                                <h5 class="text-primary">
                                    <i class="fas fa-folder"></i> 
                                    {{ $topic->name }}
                                    <span class="badge bg-secondary">{{ $topicVocabularies->count() }} từ</span>
                                </h5>
                                
                                <div class="row">
                                    @foreach($topicVocabularies as $vocabulary)
                                        <div class="col-md-4 col-lg-3 mb-3">
                                            <div class="card h-100">
                                                @if($vocabulary->image_path)
                                                    <a href="{{ route('vocabularies.show', $vocabulary) }}">
                                                        <img src="{{ asset('storage/' . $vocabulary->image_path) }}" class="card-img-top" alt="{{ $vocabulary->word }}" style="height: 150px; object-fit: cover;">
                                                    </a>
                                                @else
                                                    <a href="{{ route('vocabularies.show', $vocabulary) }}">
                                                        <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 150px;">
                                                            <i class="fas fa-image text-muted fa-2x"></i>
                                                        </div>
                                                    </a>
                                                @endif
                                                <div class="card-body">
                                                    <h6 class="card-title" style="font-size: 1.25rem;">{{ $vocabulary->word }}</h6>
                                                    @if($vocabulary->sentences)
                                                        <p class="card-text small text-muted">{{ nl2br($vocabulary->sentences) }}</p>
                                                    @endif
                                                </div>
                                                <div class="card-footer text-center">
                                                    <a href="{{ route('vocabularies.edit', $vocabulary) }}" class="btn btn-sm btn-outline-warning" title="Sửa từ vựng">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="text-center py-4">
                            <p class="text-muted">Chưa có từ vựng nào.</p>
                            <a href="{{ route('vocabularies.create') }}" class="btn btn-primary">Thêm từ vựng đầu tiên</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 