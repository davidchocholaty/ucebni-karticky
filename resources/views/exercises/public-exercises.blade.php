@extends(Auth::user() ? 'layouts.main' : 'layouts/app', ['activePage' => 'public-exercises', 'title' => 'Učební Kartičky'])
<!-- *********************** -->
<!-- * Author: Tomas Bartu * -->
<!-- * Login: xbartu11     * -->
<!-- *********************** -->
@section('content')
    <div class="container my-4">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">{{ __('Veřejně dostupná cvičení') }}</div>
                    <div class="card-body">
                        <div class="col-md-12">
                            @foreach($exercises as $record)
                                @if($record->pocet != 0)
                                <div class="card mb-3">
                                    <div class="card-header d-flex align-items-center">
                                        <div class="col-6">
                                            <div class="d-flex align-items-center gap-1">
                                                <div> {{ $record->e_name }}</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="d-flex">
                                            <div class="col-6">
                                                <div>Počet kartiček: {{ $record->pocet }}</div>
                                                <div>Téma: {{ $record->topic }}</div>
                                            </div>
                                        </div>
                                        <hr class="my-2"/>
                                        <div class="pb-3">Popis:</div>
                                        <div>{{ $record->description }}</div>
                                        <div class="d-flex pt-3 gap-2">
                                            <div class="col-8 d-flex gap-3">
                                                <a href="{{route('public-flashcard.show', ['id' => $record->id])}}">
                                                    <button type="button"
                                                            class="btn btn-outline-secondary btn-sm px-3 text-nowrap">
                                                        Zobrazit <i class="bi bi-eye-fill"></i>
                                                    </button>
                                                </a>
                                            </div>
                                            @if($record->pocet == 0)
                                                <div class="col-4 d-flex justify-content-end text-danger">
                                                    Ve cvičení nejsou zatím žádné kartičky.
                                                </div>
                                            @else
                                                <div class="col-4 d-flex justify-content-end">
                                                    <a href="{{route('public-flashcardPractise.show', ['id' => $record->id])}}">
                                                        <button type="button"
                                                                class="btn btn-primary btn-sm px-3 me-3 text-nowrap">
                                                            Spustit
                                                            <i class="bi bi-arrow-return-right"></i>
                                                        </button>
                                                    </a>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
