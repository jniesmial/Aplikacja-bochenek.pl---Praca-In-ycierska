$(document).ready(function() {

   

    $('#email').blur(function() {
        var email = $(this).val();
        
        $.ajax({
            type: 'POST',
            url: 'sprawdz_email.php',
            data: { email: email },
            success: function(response) {
                if (response == "zajety") {
                    $('#emailKomunikat').html("Konto z tym adresem e-mail juz istnieje")
                    .css('margin-left', '15px');
                } else if(response == "dostepny") {
                    $('#emailKomunikat').html("") //Ten adres e-mail jest dostępny do rejestracji.
                    .css('margin-left', '0px');  
                }
                else {
                    $('#emailKomunikat').html(response);
                }

                sprawdzAktywacjePrzycisku();
            }
        });
    });

    $('#username').blur(function() {
        var username = $(this).val();

        $.ajax({
            type: 'POST',
            url: 'sprawdz_username.php',
            data: { username: username },
            success: function(response) {
                if (response == "zajety") {
                    $('#usernameKomunikat').html("Ta nazwa użytkownika jest zajęta")
                    .css('margin-left', '15px');
                } else if(response == "dostepny") {
                    $('#usernameKomunikat').html("") //Ta nazwa użytkownika jest dostępna.
                    .css('margin-left', '0px'); 
                }
                else {
                    $('#usernameKomunikat').html(response);
                }

                sprawdzAktywacjePrzycisku();
            }
        });
    });

    $('#confirm').keyup(function() {
        var password = $('#password').val();
        var confirm = $(this).val();
        
        if (password === confirm) {
            $('#hasloKomunikat').html("") //Hasła są zgodne.
            .css('margin-left', '0px'); 
        } else {
            $('#hasloKomunikat').html("Hasła nie są zgodne")
            .css('margin-left', '15px');
        }

        sprawdzAktywacjePrzycisku();
    });

    function sprawdzAktywacjePrzycisku() {
        var emailKomunikat = $('#emailKomunikat').text();
        var usernameKomunikat = $('#usernameKomunikat').text();
        var hasloKomunikat = $('#hasloKomunikat').text();

        // Aktywuj przycisk "Submit" tylko, jeśli wszystkie komunikaty są puste.
        if (emailKomunikat === '' && usernameKomunikat === '' && hasloKomunikat === '') {
            $('#submitRegBtn').prop('disabled', false);
        } else {
            $('#submitRegBtn').prop('disabled', true);
        }
    }
    






    $('#emailLog').blur(function() {
        var email = $(this).val();
        
        $.ajax({
            type: 'POST',
            url: 'sprawdz_email.php',
            data: { email: email },
            success: function(response) {
                if (response == "zajety") {
                    $('#emailLogKomunikat').html("")
                    .css('margin-left', '0px');
                } else if(response == "dostepny") {
                    $('#emailLogKomunikat').html("Konto z tym adresem e-mail nie istnieje") //Ten adres e-mail jest dostępny do rejestracji.
                    .css('margin-left', '15px');  
                }
                else {
                    $('#emailLogKomunikat').html(response);
                }

                sprawdzAktywacjePrzycisku2();
            }
        });
    });

    function sprawdzAktywacjePrzycisku2() {
        var emailLogKomunikat = $('#emailLogKomunikat').text();

        // Aktywuj przycisk "Submit" tylko, jeśli email isnieje w bazie.
        if (emailLogKomunikat === '') {
            $('#submitLogBtn').prop('disabled', false);
        } else {
            $('#submitLogBtn').prop('disabled', true);
        }
    }













})

// ----------------------------- JAK TO NIBY DZIAŁA -----------------------------

    // // To jest selektor jQuery, który znajduje element HTML o id "email", czyli pole do
    // // wprowadzania adresu e-mail. Wywołuje funkcję obsługi, kiedy użytkownik kliknie 
    // // poza to pole (to zdarzenie nazywa się "blur").
    // $('#email').blur(function() {

    //     // Pobiera wartość wprowadzoną przez użytkownika do pola adresu e-mail i zapisuje ją 
    //     // w zmiennej "email". Zmienna "this" odnosi się do elementu, który wywołał zdarzenie(.blur), 
    //     // czyli pola adresu e-mail.
    //     var email = $(this).val();

    //     // To jest funkcja jQuery, która służy do wykonywania żądań AJAX, 
    //     // czyli asynchronicznych żądań HTTP do serwera.
    //     $.ajax({
    //         type: 'POST', //Określa, że chcemy wysłać żądanie POST, co jest odpowiednie do przekazywania danych do serwera.
    //         url: 'sprawdz_email.php', //Wskazuje adres URL pliku PHP, który będzie przetwarzać żądanie i sprawdzać dostępność adresu e-mail w bazie danych.
    //         data: {email: email }, //Przesyła dane do serwera. W tym przypadku przekazujemy adres e-mail z pola do wprowadzania.

    //         //Jest to funkcja wywoływana po udanym zapytaniu AJAX. Otrzymuje odpowiedź z serwera jako argument o nazwie "response".
    //         succes: function(response) {
    //             if (response == "zajęty") {
    //                 $('#emailKomunikat').html("Ten adres e-mail jest już wykorzystywany.");
    //             } else {
    //                 $('#emailKomunikat').html("Ten adres e-mail jest dostępny.");
    //             }
    //         }
    //     });
    // });