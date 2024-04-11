function getClients() {
    var initMessage = document.getElementById('init_message');
    initMessage.style.display = 'none';

    var content = document.getElementById('content');
    content.style.display = 'block';

    $.ajax({
        type: "GET",
        dataType: "json",
        url: "http://localhost/api/clients",
        data: {},
        success: function (response) {
            hideError()
            var $tbody = $("#clients_table_body")

            $.each(response, function (index, item) {
                var $tr = $('<tr id="client_' + item.id + '"><td>' + item.id + '</td><td><a href="#" onclick="getClientCars(' + item.id + ')">' + item.name + '</a></td><td>' + item.card_number + '</td></tr>');
                $tbody.append($tr);
            });

            $('#clients_table_body').append($tbody);
        },
        error: function (response) {
            var $carsContainer = $('#client_cars')
            $carsContainer.remove();

            showError(response.responseJSON.error)
        }
    });
}

function getClientCars(clientId) {
    $.ajax({
        type: "GET",
        dataType: "json",
        url: "http://localhost/api/client/" + clientId + "/cars",
        data: {},
        success: function (response) {
            hideError()
            var $carsContainer = $('#client_cars')
            $carsContainer.remove();

            var $table = $('<table class="table table-secondary m-0" id="client_cars"><thead><tr><th>Autó sorszáma</th><th>Autó típusa</th><th>Regisztrálás időpontja</th><th>Saját márkás</th><th>Balesetek száma</th><th>Szervíznapló</th><th>Szervíz időpontja</th></tr></thead><tbody></tbody></table>');

            $.each(response, function (index, item) {
                var $tr = $('<tr id="car_' + item.car_id + '"><td><a class="py-0" href="#" onclick="getServices(' + item.car_id + ',' + clientId + ')">' + item.car_id + '</a></td><td>' + item.type + '</a></td><td>' + item.registered + '</td><td>' + item.ownbrand + '</td><td>' + item.accident + '</td><td>' + item.log_number + '</td><td>' + item.event_time + '</td></tr>');
                $table.append($tr);
            });

            $table.insertAfter($('#client_' + clientId));
        },
        error: function (response) {
            var $carsContainer = $('#client_cars')
            $carsContainer.remove();

            showError(response.responseJSON.error)
        }
    });
}

function getServices(carId, clientId) {
    $.ajax({
        method: "GET",
        dataType: "json",
        url: "http://localhost/api/services",
        contentType: "application/json",
        data: {"client_id": clientId, "car_id": carId},
        success: function (response) {
            hideError()
            var $carsContainer = $('#client_services')
            $carsContainer.remove();

            var $table = $('<table class="table table-info m-0" id="client_services"><thead><tr><th>Alkalom sorszáma</th><th>Esemény neve</th><th>Esemény időpontja</th><th>Munkalap azonosító</th></tr></thead><tbody></tbody></table>');

            $.each(response, function (index, item) {
                var $tr = $('<tr><td>' + item.log_number + '</td><td>' + item.event + '</a></td><td>' + item.event_time + '</td><td>' + item.document_id + '</td></tr>');
                $table.append($tr);
            });

            $table.insertAfter($('#car_' + carId));
        },
        error: function (response) {
            var $carsContainer = $('#client_services')
            $carsContainer.remove();

            showError(response.responseJSON.error)
        }
    });
}

function findClient(filter, type) {
    var data = {}
    data[type] = filter

    $.ajax({
        method: "GET",
        dataType: "json",
        url: "http://localhost/api/client",
        contentType: "application/json",
        data: data,
        success: function (response) {
            var $clientSearchContainer = $('#client_search')
            $clientSearchContainer.remove();

            var $table = $('<table class="table table-dark" id="client_search"><thead><tr><th>Ügyfél azonosítója</th><th>Név</th><th>Okmányazonosító</th><th>Autó darabszám</th><th>Szervíznapló darabszám</th></tr></thead><tbody></tbody></table>');

            $.each(response, function (index, item) {
                var $tr = $('<tr><td>' + item.id + '</td><td>' + item.name + '</a></td><td>' + item.card_number + '</td><td>' + item.car_count + '</td><td>' + item.services_count + '</td></tr>');
                $table.append($tr);
            });

            $table.insertAfter($('#search_form'));
        },
        error: function (response) {
            var $clientSearchContainer = $('#client_search')
            $clientSearchContainer.remove();

            showError(response.responseJSON.error)
        }
    });
}

function showError(errorMsg) {
    var errordiv = document.getElementById('errorDiv');
    errordiv.style.display = 'block';

    var errorUl = document.getElementById('errorUl');
    var listItem = document.createElement('li');
    listItem.textContent = errorMsg;
    errorUl.innerHTML = '';

    errorUl.appendChild(listItem);
}

function hideError() {
    var errordiv = document.getElementById('errorDiv');
    errordiv.style.display = 'none';
}

$(document).ready(function () {
    initDatabase()

    var form = document.querySelector('form');

    form.addEventListener('submit', function (event) {
        event.preventDefault();

        var nameInput = document.querySelector('input[name="name"]');
        var cardNumberInput = document.querySelector('input[name="card_number"]');

        if (nameInput.value.trim() !== '' && cardNumberInput.value.trim() !== '') {
            showError('Only one of the inputs are fillable!');
            return;
        }

        if (nameInput.value.trim() === '' && cardNumberInput.value.trim() === '') {
            showError('Either name or card_number is required!');
            return;
        }

        if (!/^[a-zA-Z0-9]*$/.test(cardNumberInput.value.trim())) {
            showError('Invalid Card number format!');
            return;
        }

        hideError()

        if (nameInput.value.trim() !== '') {
            findClient(nameInput.value.trim(), nameInput.name)
        }

        if (cardNumberInput.value.trim() !== '') {
            findClient(cardNumberInput.value.trim(), cardNumberInput.name)
        }
    });
})

function initDatabase() {
    $.ajax({
        type: "POST",
        dataType: "json",
        url: "http://localhost/api/check-database",
        data: {},
        success: function () {
        },
        error: function (response) {
            console.log();

            if (response.status == 200) {
                getClients();
            } else {
                showError("Database inicialization failed!")
            }
        }
    });
}