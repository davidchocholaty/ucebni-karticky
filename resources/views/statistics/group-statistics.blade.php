@extends('layouts.main')

@section('content')
    <div class="container my-4">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">
                        {{__('Statistiky cvičení')}}
                    </div>
                    <div class="card-body">
                        <div class="card-group">
                            <div class="card mb-3">
                                <div class="card-header d-flex align-items-center">
                                    <div>
                                        Cvičení: {{$exercise->name}}
                                    </div>
                                    <div class="ms-auto">
                                        <button class="btn btn-outline-secondary">Zpět na cvičení</button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row mb-1">
                                        Téma: {{$exercise->topic}}
                                    </div>
                                    <div class="row mb-1">
                                        Počet kartiček: {{$exercise->count}}
                                    </div>
                                    <div class="row mb-1">
                                        Popis: {{$exercise->description}}
                                    </div>
                                </div>
                            </div>

                            <div class="card mb-3">
                                <div class="card-header d-flex align-items-center">
                                    <div>
                                        Skupina: {{$group->name}}
                                    </div>
                                    <div class="ms-auto">
                                        <button class="btn btn-outline-secondary">Zpět na skupinu</button>
                                    </div>
                                </div>
                                <div class="card-body row">
                                    <div class="col-9">
                                        Popis: {{$group->description}}
                                    </div>
                                    <div class="col-3">
                                        <img src="{{asset($group->photo)}}" class="rounded-circle" style="width: 60px; height: 60px;" alt="Fotka skupiny" />
                                    </div>
                                </div>
                            </div>
                        </div>


                        <hr class="my-2">

                        <div class="card-group mt-3">
                            <div class="col-5 card">
                                <div class="card-header">Nejrychlejší pokusy</div>
                                <div class="card-body">
                                    @foreach($fastest_attempt as $attempt)
                                        <div class="card mb-2">
                                            <div class="card-body p-1">
                                                <p>Čas: {{$attempt->spend_time}}</p>
                                                <p>Úspěšnost: {{money_format('%.0i', $attempt->percentage)}}%</p>
                                                <p class="text-success">Počet správných odpovědí: {{$attempt->correct_answers_number}}</p>
                                                <p class="text-danger m-0">Počet špatných odpovědí: {{$attempt->wrong_answers_number}}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="col-5 card">
                                <div class="card-header">Nejúspěšnější pokusy</div>
                                <div class="card-body">
                                    @foreach($best_attempt as $attempt)
                                        <div class="card mb-2">
                                            <div class="card-body p-1">
                                                <p>Čas: {{$attempt->spend_time}}</p>
                                                <p>Úspěšnost: {{money_format('%.0i', $attempt->percentage)}}%</p>
                                                <p class="text-success">Počet správných odpovědí: {{$attempt->correct_answers_number}}</p>
                                                <p class="text-danger m-0">Počet špatných odpovědí: {{$attempt->wrong_answers_number}}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                        </div>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
