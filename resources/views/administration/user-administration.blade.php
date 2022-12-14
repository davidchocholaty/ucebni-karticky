@extends('layouts.main')

<!-- **************************** -->
<!-- * Author: David Chocholaty * -->
<!-- * Login: xchoch09          * -->
<!-- **************************** -->

@section('content')
    <div class="container my-4">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ __('Správa uživatelů') }}
                    </div>

                    <div class="card-body">
                        <div class="row mt-5">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-body">
                                        <form action="" method="POST">
                                            @csrf

                                            <div class="row">
                                                <div class="col-md-5">
                                                    <div class="input-group mb-3">
                                                        <input type="text" class="form-control" placeholder="Vyhledat uživatele" id="search">
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                        <div style="height: 500px;overflow-y: scroll;">
                                            <table class="table table-striped d-table">
                                                <thead class="table-head-sticky">
                                                <tr>
                                                    <th>Pořadí</th>
                                                    <th>Foto</th>
                                                    <th>Tituly před</th>
                                                    <th>Jméno</th>
                                                    <th>Příjmení</th>
                                                    <th>Tituly za</th>
                                                    <th>Typ uživatele</th>
                                                    <th>Akce</th>
                                                </tr>
                                                </thead>
                                                <tbody id="users_table">
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ***************************** -->
            <!-- * Modal window for removing * -->
            <!-- * the user                  * -->
            <!-- ***************************** -->
            <div id="removingQuestion" class="modal fade" tabindex="-1" aria-labelledby="addMemberModalLabel" aria-hidden="true" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Upozornění</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>Opravdu si přejete smazat uživatele?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" id="remove-user-btn"  data-bs-dismiss="modal" value="">Ano</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Ne</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <script>
        /*
         * Searching the users on the keyup event in the search box.
         */
        $('#search').on('keyup', function(){
            search();
        });

        search();

        /*
         * Function for searching the users.
         */
        function search(){
            var keyword = $('#search').val();

            $.post('{{ route("user-administration.search") }}',
                {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    keyword:keyword,
                },
                function(data){
                    table_post_row(data);
                    console.log(data);
                });
        }

        /*
         * Function for showing the table row.
         */
        function table_post_row(res){
            let htmlView = '';
            if(res.result.length <= 0){
                htmlView += `
            <tr>
                <td colspan="8">Nebyli nalezeni žádní uživatelé.</td>
            </tr>`;
            }
            for(let i = 0; i < res.result.length; i++){
                if (res.result[i].degree_front === null) {
                    res.result[i].degree_front = '';
                }
                if (res.result[i].degree_after === null) {
                    res.result[i].degree_after = '';
                }

                var url = '{{ route("profile", ":id") }}';
                url = url.replace(':id', res.result[i].id);

                var user = '{{ ":id" }}';
                user = user.replace(':id', res.result[i].id);

                htmlView += `
            <tr class="clickable-row-hover" style="cursor:pointer;">
                <td class="clickable-row" data-href="` + url + `">`+ (i+1) +`</td>
                <td class="clickable-row" data-href="` + url + `">
                    <img src="` + res.result[i].photo + `" class="rounded-circle d-flex px-0" style="width: 40px; height: 40px;"
                        alt="Avatar"/>
                </td>
                <td class="clickable-row" data-href="` + url + `">`+res.result[i].degree_front+`</td>
                <td class="clickable-row" data-href="` + url + `">`+res.result[i].first_name+`</td>
                <td class="clickable-row" data-href="` + url + `">`+res.result[i].last_name+`</td>
                <td class="clickable-row" data-href="` + url + `">`+ res.result[i].degree_after  +`</td>
                <td class="clickable-row" data-href="` + url + `">`+res.result[i].account_type+`</td>
                <td>
                    <button type="button"
                        class="btn btn-outline-danger open-remove-member-dialog"
                        data-id="` + user + `"
                        data-bs-toggle="modal"
                        data-bs-target="#removingQuestion">Odebrat</button>
                </td>
            </tr>`;

            }
            $('#users_table').html(htmlView);
        }
    </script>
    <script>
        /*
         * Set the window location for the clickable row.
         */
        $(document).on("click", ".clickable-row", function() {
            window.location = $(this).data("href");
        });
    </script>
    <script>
        /*
         * Set the exercise identifier when opening the remove exercise modal window.
         */
        $(document).on("click", ".open-remove-member-dialog", function () {
            var user = $(this).data('id');

            $(".modal-footer #remove-user-btn").val( user );
        });

        /*
         * Event handler for the user removing.
         */
        $(document).on("click", "#remove-user-btn", function () {
            removeUser($(this).attr("value"));
        });

        /*
         * Function for removing the user.
         */
        function removeUser(user_id) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                data: {"user_id" : user_id},
                url: "{{ route('user-administration.remove-user') }}",
                type: "POST",
                dataType: 'text',
                success: function (data) {
                    if (data === '1') {
                        alert("Nepodařilo se odebrat uživatele.");
                    } else {
                        // Clear the searching text field.
                        document.getElementById('search').value = '';

                        // Search to remove the deleted row.
                        search();
                    }
                },
                error: function (data) {
                    console.log('Error: ', data);
                },
            });
        }
    </script>
@endsection
