@extends('layouts.main')

<!-- ************************************* -->
<!-- * Authors: Tomas Bartu, Simon Vacek * -->
<!-- * Logins: xbartu11, xvacek10        * -->
<!-- ************************************* -->
@section('content')
    <!-- *********************** -->
    <!-- * Author: Tomas Bartu * -->
    <!-- * Section: Blade 1    * -->
    <!-- *********************** -->
    <script type="text/javascript">var exerciseId = 0;</script>
    <div class="container my-4">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">{{ __('Moje cvičení') }}</div>
                    @if($role === 'teacher')
                        <div class="card-body">
                            <div class="col-md-12">
                                <h2>Vámi vytvořená cvičení</h2>
                                @if($t_exercises->isEmpty())
                                    <div class="ps-3 pb-3 fs-5">
                                        Nemáte vytvořené žádné cvičení. <i
                                            class="bi bi-emoji-frown"></i>
                                        <form action="{{route('create-exercise')}}">
                                            <button type="submit"
                                                    class="mt-2 ms-2 btn btn-primary btn-sm px-3 text-nowrap">
                                                <span class="ms-1 d-none d-sm-inline">Vytvořit cvičení</span>
                                            </button>
                                        </form>
                                    </div>
                                @endif
                                @foreach($t_exercises as $record)
                                    <div class="card mb-3">
                                        <div class="card-header d-flex align-items-center">
                                            <div class="col-6">
                                                <div class="d-flex align-items-center gap-1">
                                                    <div> {{ $record->name }}</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="d-flex">
                                                <div class="col-6">
                                                    <div>Počet kartiček: {{ $record->pocet }}</div>
                                                    <div>Téma: {{ $record->topic }}</div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="d-flex justify-content-end gap-3">
                                                        <button type="button"
                                                                class="btn btn-outline-secondary btn-sm px-3 text-nowrap"
                                                                data-bs-toggle="modal" data-bs-target="#shareModal"
                                                                onclick="exercise_id = {{$record->id}}; share();">
                                                            Sdílet <i class="bi bi-share-fill"></i>
                                                        </button>
                                                        <button type="button"
                                                                class="btn btn-outline-secondary btn-sm px-3 text-nowrap"
                                                                data-bs-toggle="modal" data-bs-target="#exampleModal"
                                                                onclick="exerciseId = {{$record->id}}; assign();">
                                                            Zadat <i class="bi bi-collection"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr class="my-2"/>
                                            <div class="pb-3">Popis:</div>
                                            <div>{{ $record->description }}</div>
                                            <div class="d-flex pt-3 gap-2">
                                                <div class="col-8 d-flex gap-3">
                                                    <a href="{{route('myexercises.edit', ['id' => $record->id])}}">
                                                        <button type="button"
                                                                class="btn btn-outline-secondary btn-sm px-3 text-nowrap">
                                                            Upravit <i class="bi bi-pencil-fill"></i></button>
                                                    </a>
                                                    <button type="button"
                                                            class="btn btn-outline-secondary btn-sm px-3 text-nowrap"
                                                            data-bs-toggle="modal" data-bs-target="#statModal"
                                                            onclick="exerciseId = {{$record->id}}; searchForStat();">
                                                        Zobrazit statistiky <i class="bi bi-bar-chart-line-fill"></i>
                                                    </button>
                                                    <a href="{{route('flashcard.show', ['id' => $record->id])}}">
                                                        <button type="button"
                                                                class="btn btn-outline-secondary btn-sm px-3 text-nowrap">
                                                            Zobrazit <i class="bi bi-eye-fill"></i></button>
                                                    </a>
                                                </div>
                                                @if($record->pocet == 0)
                                                    <div class="col-4 d-flex justify-content-end text-danger">
                                                        Ve cvičení nejsou zatím žádné kartičky.
                                                    </div>
                                                @else
                                                    <div class="col-4 d-flex justify-content-end">
                                                        <a href="{{route('flashcardPractise.show', ['id' => $record->id])}}">
                                                            <button type="button"
                                                                    class="btn btn-primary btn-sm px-3 me-3 text-nowrap">
                                                                Spustit <i class="bi bi-arrow-return-right"></i>
                                                            </button>
                                                        </a>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                <h2>Ostatní dostupná cvičení</h2>
                                @if($t_sharedExercises->isEmpty())
                                    <div class="ps-3 pb-3 fs-5">
                                        Nikdo s Vámi zatím nesdílí cvičení. <i
                                            class="bi bi-emoji-frown"></i>
                                    </div>
                                @endif
                                @foreach($t_sharedExercises as $record)
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
                                                    <div>Skupina: {{ $record->g_name }}</div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="d-flex justify-content-end gap-3">
                                                        <button type="button"
                                                                class="btn btn-outline-secondary btn-sm px-3 text-nowrap"
                                                                data-bs-toggle="modal" data-bs-target="#exampleModal"
                                                                onclick="exerciseId = {{$record->id}}; assign();">
                                                            Zadat <i class="bi bi-collection"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr class="my-2"/>
                                            <div class="pb-3">Popis:</div>
                                            <div>{{ $record->description }}</div>
                                            <div class="d-flex pt-3 gap-2">
                                                <div class="col-8 d-flex gap-3">
                                                    <button type="button"
                                                            class="btn btn-outline-secondary btn-sm px-3 text-nowrap"
                                                            data-bs-toggle="modal" data-bs-target="#statModal"
                                                            onclick="exerciseId = {{$record->id}}; searchForStat();">
                                                        Zobrazit statistiky <i class="bi bi-bar-chart-line-fill"></i>
                                                    </button>
                                                    <a href="{{route('flashcard.show', ['id' => $record->id])}}">
                                                        <button type="button"
                                                                class="btn btn-outline-secondary btn-sm px-3 text-nowrap">
                                                            Zobrazit <i class="bi bi-eye-fill"></i></button>
                                                    </a>
                                                </div>
                                                <div class="col-4 d-flex justify-content-end">
                                                    <a href="{{route('flashcardPractise.show', ['id' => $record->id])}}">
                                                        <button type="button"
                                                                class="btn btn-primary btn-sm px-3 me-3 text-nowrap">
                                                            Spustit <i class="bi bi-arrow-return-right"></i></button>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>

                    @elseif($role === 'student')
                        <div class="card-body">
                            <div class="col-md-12">
                                @foreach($s_exercises as $record)
                                    <div class="card mb-3">
                                        <div class="card-header d-flex align-items-center">
                                            <div class="col-6">
                                                <div class="d-flex align-items-center gap-1">
                                                    <div class="col-6"> {{ $record->e_name }} </div>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="d-flex justify-content-end">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="d-flex">
                                                <div class="col">
                                                    <div>Počet kartiček: {{ $record->count }} </div>
                                                    <div>Téma: {{ $record->topic }}</div>
                                                    <div>Skupina: {{ $record->g_name }}</div>
                                                </div>
                                            </div>
                                            <hr class="my-2"/>
                                            <div class="pb-3">Popis:</div>
                                            <div> {{ $record->description }} </div>
                                            <div class="d-flex pt-3 gap-2">
                                                <div class="col-8 d-flex gap-3">
                                                    <form method="POST"
                                                          action="{{ route('myexercises.user-statistics') }}">
                                                        @csrf

                                                        <input type="hidden" name="user_id" id="user_id"
                                                               value="{{ Auth::user()->id }}"/>
                                                        <input type="hidden" name="exercise_id_stat"
                                                               id="exercise_id_stat" value="{{ $record->id }}">
                                                        <button type="submit"
                                                                class="btn btn-outline-secondary btn-sm px-3 text-nowrap">
                                                            Zobrazit statistiky <i
                                                                class="bi bi-bar-chart-line-fill"></i></button>
                                                    </form>
                                                    <a href="{{route('flashcard.show', ['id' => $record->id])}}">
                                                        <button type="button"
                                                                class="btn btn-outline-secondary btn-sm px-3 text-nowrap">
                                                            Zobrazit <i class="bi bi-eye-fill"></i></button>
                                                    </a>
                                                </div>
                                                @if($record->count == 0)
                                                    <div class="col-4 d-flex justify-content-end text-danger">
                                                        Ve cvičení nejsou zatím žádné kartičky.
                                                    </div>
                                                @else
                                                    <div class="col-4 d-flex justify-content-end">
                                                        <a href="{{route('flashcardPractise.show', ['id' => $record->id])}}">
                                                            <button type="button"
                                                                    class="btn btn-primary btn-sm px-3 me-3 text-nowrap">
                                                                Spustit <i class="bi bi-arrow-return-right"></i>
                                                            </button>
                                                        </a>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!--   SHARE EXERCISE MODAL  -->
            <!-- *********************** -->
            <!-- * Author: Tomas Bartu * -->
            <!-- * Section: Modal 1    * -->
            <!-- *********************** -->
            <div class="modal fade" id="shareModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                 aria-hidden="true" style="--bs-modal-width: 75vw;">
                <div class="modal-dialog">
                    <div class="modal-content m-auto w-75">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Sdílet se skupinou učitelů</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row mt-2">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <form action="" method="POST">
                                                <div class="row align-items-center">
                                                    <div class="col-md-6">
                                                        <div class="input-group mb-3">
                                                            <input type="text" class="form-control"
                                                                   placeholder="Vyhledat skupinu" id="share">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <div class="form-check fs-5">
                                                            <label class="form-check-label">
                                                                Sdílená cvičení
                                                                <input class="form-check-input" type="checkbox"
                                                                       value="value" id="shared">
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                            <div class="container" id="shareGroupsBody" name="shareGroupsBody"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Zavřít</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ASSIGN EXERCISE MODAL -->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                 aria-hidden="true" style="--bs-modal-width: 75vw;">
                <div class="modal-dialog">
                    <div class="modal-content m-auto w-75">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Zadat skupině</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">

                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <form action="" method="POST">
                                                <div class="row align-items-center">
                                                    <div class="col-md-6">
                                                        <div class="input-group mb-3">
                                                            <input type="text" class="form-control"
                                                                   placeholder="Vyhledat skupiny" id="search">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <div class="form-check fs-5">
                                                            <label class="form-check-label">
                                                                Zadaná cvičení
                                                                <input class="form-check-input" type="checkbox"
                                                                       value="value" id="assigned">
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                            <div class="container" id="searchedGroupsBody" name="searchedGroupsBody">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Zavřít</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- * End of section: Modal 1  * -->
            <!-- **************************** -->

            <!-- EXERCISE STATISTICS MODAL -->
            <!-- *********************** -->
            <!-- * Author: Simon Vacek * -->
            <!-- * Section: Modal 2    * -->
            <!-- *********************** -->
            <div class="modal fade" id="statModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                 aria-hidden="true" style="--bs-modal-width: 75vw;">
                <div class="modal-dialog">
                    <div class="modal-content m-auto w-75">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Zobrazit statistiky skupiny</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row mt-5">

                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <form action="" method="POST">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="input-group mb-3">
                                                            <input type="text" class="form-control"
                                                                   placeholder="Vyhledat skupiny" id="statSearch">
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                            <div class="container" id="statisticsBody" name="statisticsBody">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Zavřít</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- * End of section: Modal 2  * -->
            <!-- **************************** -->
        </div>
    </div>
    <!-- * End of section: Blade 1  * -->
    <!-- **************************** -->

    <script src="https://code.jquery.com/jquery-3.4.1.min.js"
            integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>

    <!-- Scripts for displaying groups in share exercise modal window -->
    <!-- *********************** -->
    <!-- * Author: Tomas Bartu * -->
    <!-- * Section: Script 1   * -->
    <!-- *********************** -->
    <script>
        $('#share').on('keyup', function () {
            share();
        });

        $('#shared').change(function () {
            share()
        });

        function share() {
            let keyword = $('#share').val();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                data: {"exercise_id": exercise_id, "keyword": keyword, "owner_id": {{ Auth::id() }}},
                url: "{{ route('myexercises.share') }}",
                type: "POST",
                dataType: 'json',
                success: function (data) {
                    postGroupsShare(data);
                },
                error: function (data) {
                    console.log('Error:', data);
                }
            });
        }

        function postGroupsShare(res) {
            isShared = JSON.parse(res.isShared);
            htmlView = '';
            let j = 0;

            if (res.result.length === 0) {
                htmlView += `
                <div class="text-center fs-3">Bohužel nemáte cvičení komu nasdílet.
                    <i class="bi bi-emoji-frown"></i>
                </div>`
                $('#shareGroupsBody').html(htmlView);
                return;
            }

            for (let i = 0; i < res.result.length; i++) {
                console.log(j);

                if (!(document.getElementById("shared").checked)) {
                    if (i % 3 === 0) {
                        htmlView += `
                        <div class="row mb-3 gap-3">`
                    }
                } else {
                    if (isShared[i].shared === "0")
                        continue;

                    if (j % 3 === 0) {
                        htmlView += `
                        <div class="row mb-3 gap-3">`
                    }
                }

                if (!(document.getElementById("shared").checked && isShared[i].shared === "0")) {
                    htmlView += `
                    <div class="col">
                        <div class="card m-auto" style="width: 18rem;">
                            <img src="` + res.result[i].photo + `" class="card-img-top" style="height: 215px" alt="Foto skupiny">
                            <div class="card-body">
                                <h5 class="card-title" title="` + res.result[i].name + `" style="text-overflow: ellipsis; white-space: nowrap; overflow: hidden">` + res.result[i].name + `</h5>
                                <p class="card-text" title="` + res.result[i].description + `" style="text-overflow: ellipsis; white-space: nowrap; overflow: hidden">` + res.result[i].description + `</p>`
                    if (isShared[i].shared === "1") {
                        htmlView += `<button class="btn btn-danger"
                                onclick="deleteExercise(` + res.result[i].id + `);">Odstranit sdílení</button>`
                    } else {
                        htmlView += `<button class="btn btn-primary"
                                onclick="shareExercise(` + res.result[i].id + `);">Sdílet</button>`
                    }
                    htmlView += `</div>
                        </div>
                    </div>
                `
                }

                if (!(document.getElementById("shared").checked)) {
                    if ((i + 1) % 3 === 0 || i === (res.result.length + 1))
                        htmlView += `</div>`
                } else {
                    if ((j + 1) % 3 === 0 || i === (res.result.length + 1)) {
                        htmlView += `</div>`
                    }
                }

                if (isShared[i].shared === "1")
                    j++;

            }
            $('#shareGroupsBody').html(htmlView);
        }

        function shareExercise(group_id) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                data: {"exercise_id": exercise_id, "group_id": group_id},
                url: "{{ route('myexercises.store-share') }}",
                type: "POST",
                dataType: 'text',
                success: function (data) {
                    if (data === '0') {
                        alert("Neporařilo se nasdílet skupinu.");
                    }
                    share();
                },
                error: function (data) {
                    console.log('Error:', data);
                }
            });
        }

        function deleteExercise(group_id) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                data: {"exercise_id": exercise_id, "group_id": group_id},
                url: "{{ route('myexercises.delete-share') }}",
                type: "POST",
                dataType: 'text',
                success: function (data) {
                    if (data === '0') {
                        alert("Neporařilo se odstranit sdílení skupiny.");
                    }
                    share();
                },
                error: function (data) {
                    console.log('Error:', data);
                }
            });
        }
    </script>
    <!-- * End of section: Script 1 * -->
    <!-- **************************** -->

    <!-- Scripts for displaying groups in assign exercise modal window -->
    <!-- *********************** -->
    <!-- * Author: Simon Vacek * -->
    <!-- * Section: Script 2   * -->
    <!-- *********************** -->
    <script>
        $('#search').on('keyup', function () {
            assign();
        });

        function assign() {
            var keyword = $('#search').val();
            $.post('{{ route("myexercises.search") }}',
                {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    keyword: keyword,
                    owner_id: {{Auth::id()}},
                    exercise_id: exerciseId,
                    assigned: $('#assigned').prop('checked').toString()
                },
                function (data) {
                    postGroupsAssign(data);
                });
        }

        $('#assigned').change(function () {
            assign();
        });

        function assignExercise(exercise_id, group_id) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                data: {"exercise_id": exercise_id, "group_id": group_id},
                url: "{{ route('myexercises.store-assignment') }}",
                type: "POST",
                dataType: 'text',
                success: function (data) {
                    if (data === '0') {
                        alert("Neporařilo se zadat cvičení skupině.");
                    }
                    assign();
                },
                error: function (data) {
                    console.log('Error:', data);
                }
            });
        }

        function unassignExercise(exercise_id, group_id) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                data: {"exercise_id": exercise_id, "group_id": group_id},
                url: "{{ route('myexercises.unassign-exercise') }}",
                type: "POST",
                dataType: 'text',
                success: function (data) {
                    if (data === '0') {
                        alert("Neporařilo se odstranit zadání skupině.");
                    }
                    assign();
                },
                error: function (data) {
                    console.log('Error:', data);
                }
            });
            assign();
        }


        // table row with ajax
        function postGroupsAssign(res) {
            if (res.result.length === 0) {
                htmlView = `
                <div class="text-center fs-3">Bohužel nemáte cvičení komu zadat.
                    <i class="bi bi-emoji-frown"></i>
                </div>`
                $('#searchedGroupsBody').html(htmlView);
                return;
            }

            htmlView = '<div class="row gap-3 m-2 d-flex flex justify-content-evenly align-items-start">';
            for (let i = 0; i < res.result.length; i++) {
                htmlView += `
                        <div class="card p-0 me-auto" style="width: 18rem;">
                            <img src="` + res.result[i].photo + `" class="card-img-top" style="height: 215px; width: calc(inherit - 1);" alt="Foto skupiny">
                            <div class="card-body">
                                <h5 class="card-title" style="text-overflow: ellipsis; white-space: nowrap; overflow: hidden" title="` + res.result[i].name + `">` + res.result[i].name + `</h5>`
                htmlView += `<p class="card-text" style="text-overflow: ellipsis; white-space: nowrap; overflow: hidden" title="`;
                if (res.result[i].description != null)
                    htmlView += res.result[i].description + `">` + res.result[i].description + `</p>`
                else
                    htmlView += `"><br /></p>`;

                if ($('#assigned').prop('checked')) {
                    htmlView += `<button class="btn btn-danger" onclick="unassignExercise(` + exerciseId + `,` + res.result[i].id + `)">Odstranit zadání</button>`
                } else {
                    htmlView += `<button class="btn btn-primary" onclick="assignExercise(` + exerciseId + `,` + res.result[i].id + `)">Zadat</button>`
                }

                htmlView += `
                        </div>
                    </div>
                `;
            }
            $('#searchedGroupsBody').html(htmlView);
        }
    </script>



    <!-- Scripts for displaying groups in show statistics modal window -->

    <script>
        $('#statSearch').on('keyup', function () {
            searchForStat();
        });

        function searchForStat() {
            var keyword = $('#statSearch').val();
            $.post('{{ route("myexercises.search-stat") }}',
                {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    keyword: keyword,
                    owner_id: {{Auth::id()}},
                    exercise_id: exerciseId
                },
                function (data) {
                    postGroupsStat(data);
                });
        }

        // table row with ajax
        function postGroupsStat(res) {
            if (res.result.length === 0) {
                htmlView = `
                <div class="text-center fs-3">Bohužel nemáte skupinu, které statistiky zobrazit.
                    <i class="bi bi-emoji-frown"></i>
                </div>`
                $('#statisticsBody').html(htmlView);
                return;
            }

            htmlView = '<div class="row gap-3 m-2 d-flex flex justify-content-evenly align-items-start">';
            for (let i = 0; i < res.result.length; i++) {
                htmlView += `
                        <div class="card p-0 me-auto" style="width: 18rem;">
                            <img src="` + res.result[i].photo + `" class="card-img-top" style="height: 215px; width: calc(inherit - 1);" alt="Foto skupiny">
                            <div class="card-body">
                                <h5 class="card-title" style="text-overflow: ellipsis; white-space: nowrap; overflow: hidden" title="` + res.result[i].name + `">` + res.result[i].name + `</h5>
                                <p class="card-text" style="text-overflow: ellipsis; white-space: nowrap; overflow: hidden" title="`
                if (res.result[i].description != null)
                    htmlView += res.result[i].description + `">` + res.result[i].description + `</p>`
                else
                    htmlView += `"><br /></p>`;

                htmlView += `<form method="GET" action="`
                htmlView += `{{route('group-statistics')}}`;
                htmlView += `">
                                    <input type="hidden" id="group_id" name="group_id" value="` + res.result[i].id + `" />
                                    <input type="hidden" id="exercise_id" name="exercise_id" value="` + exerciseId + `" />
                                    <input type="submit" class="btn btn-primary" value="Zobrazit" />
                                </form>
                            </div>
                        </div>
                `;

                console.log(htmlView);
            }
            $('#statisticsBody').html(htmlView);
        }
    </script>
    <!-- * End of section: Script 2 * -->
    <!-- **************************** -->
@endsection
