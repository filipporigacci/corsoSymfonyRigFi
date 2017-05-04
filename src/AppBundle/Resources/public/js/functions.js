 $(document).ready(function(){
    $(".nav").children("li").click(function() {
        $(".nav").children("li").removeClass();
        $(this).attr('class','active');
    });
});

function init(route) {
    myApp.setRoute(route);
    loadIndexIntoPanel(route);
}

function changeTab(nomeScheda) {
    myApp.setNomeScheda(nomeScheda);
    loadShowIntoPanel('scheda');
}

function loadShowIntoPanel(route) {
    myApp.resetPanel();
    console.log(route);
    $.ajax({
        url: Routing.generate(route + '_index'),
        type: 'GET',
        success: function (data) {
            myApp.updatePanel(data);
        },
        error: function (jqXHR) {
            if (401 === jqXHR.status) {
            }
            myApp.hideFormModal();
            myApp.createNotifyError(jqXHR.responseText);
        }
    });
}

function loadIndexIntoPanel(route) {
    myApp.resetPanel();
    console.log(route);
    var prefix = myApp.getRoutePrefix();
    $.ajax({
        url: Routing.generate(prefix + '_index'),
        type: 'GET',
        success: function (data) {
            myApp.updatePanel(data);
        },
        error: function (jqXHR) {
            if (401 === jqXHR.status) {
            }
            myApp.hideFormModal();
            myApp.createNotifyError(jqXHR.responseText);
        }
    });
}
function loadShowIntoPanelByUrl(url) {

    $.ajax({
        url: url,
        type: 'GET',

        success: function (data) {

            myApp.updatePanel(data);

        },
        error: function (jqXHR) {
            if (401 === jqXHR.status) {
            }
            myApp.hideFormModal();
            myApp.createNotifyError(jqXHR.responseText);
        }

    });


}

function adjustCssSelect2() {

    $('.select2.select2-container').css('width', '100%');
    $('.select2.select2-container').css('heigth', '100%');
    $('span.select2.select2-container').css('font-weight', 'bold');
}

// function prepareAddButtonsCollectionTable() {
//     $('.dynamicTable').sortable({
//         items: ".row:not(:first())",
//         stop: function (event, ui) {
//             updateNames($(this))
//         }
//     });
//     $('.addRow').on('click', function (e) {
//         e.preventDefault();
//         var $table = $(this).closest('.dynamicTable');
//         addTagForm($table);
//
//
//     });
// }

function gestisciPW(tipoChiamata) {

    $.ajax({
        url: Routing.generate('prescrivo', {

            'idCartella': myApp.getIdCartella(),
            'tipoChiamata': tipoChiamata
        }),
        type: 'GET',

        success: function (data) {

            var max_win_open =
                "width=" + window.screen.availWidth + "," +
                "height=" + window.screen.availHeight + "," +
                "left=0,top=0,menubar=no,toolbar=no,location=no,scrollbars=yes,status=no";

            window.open('http://antiblastici.aop.int:81/LaunchPW.aspx?ID=' + data, 'PrescrivoWeb', max_win_open);


        },
        error: function (jqXHR) {
            if (401 === jqXHR.status) {
            }
            myApp.hideFormModal();
            myApp.createNotifyError(jqXHR.responseText);
        }

    });

}

function printScheda(url){


    window.open(url);
}

function loadFormIntoModal(url) {
    $.ajax({
        url: url,
        type: 'GET',

        success: function (data) {

            myApp.updateFormModal(data);
            adjustCssSelect2();
            myApp.showFormModal();


        },
        error: function (jqXHR) {
            if (401 === jqXHR.status) {
            }
            myApp.hideFormModal();
            myApp.createNotifyError(jqXHR.responseText);
        }

    });
}

function loadFormModalClose(url) {


    $.ajax({
        url: url,
        type: 'GET',

        success: function (data) {

            myApp.updateFormModalClose(data);
            adjustCssSelect2();
            myApp.showFormModalClose();


        },
        error: function (jqXHR) {
            if (401 === jqXHR.status) {
            }
            myApp.hideFormModalClose();
            myApp.createNotifyError(jqXHR.responseText);
        }

    });
}

function loadConfirmModal(url) {
    $.ajax({
        url: url,
        type: 'GET',
        success: function (data) {
            myApp.updateConfirmModal(data);
            myApp.showConfirmModal();
        },
        error: function (jqXHR) {
            if (401 === jqXHR.status) {
            }
            myApp.hideConfirmModal();
            myApp.createNotifyError(jqXHR.responseText);
        }
    });
}

function confirmDeletion(o, event) {

    event.preventDefault();

    var id = $('#confirmDeleteId').attr('data');

    $.ajax({
        url: Routing.generate(myApp.getRoutePrefix() + '_delete', {
            'id': id
            //,
            //'nomeScheda': myApp.getNomeScheda(),
            //'idCartella': myApp.getIdCartella()
        }),
        type: 'DELETE',

        success: function () {

            myApp.hideConfirmModal();
            $(o).prop("disabled", false);
            $(o).button('reset');
            loadShowIntoPanel(myApp.getRoutePrefix());
            //$('.panel-body').html(data);
        },
        error: function (jqXHR) {
            if (401 === jqXHR.status) {
            }
            myApp.hideConfirmModal();
            myApp.createNotifyError(jqXHR.responseText);
        }

    });
}


function handleClick(o, event) {

    var $formModal = $('#formModal');
    var data = $formModal.find("form").serialize();
    var url = $formModal.find('form').attr('action');

    event.preventDefault();

    $(o).prop("disabled", true);
    $(o).button('loading');

    $.ajax({
        url: url,
        type: 'POST',
        data: data,
        success: function (data) {

            myApp.hideFormModal();
            $(o).prop("disabled", false);
            $(o).button('reset');
            // loadShowIntoPanel(myApp.getRoute());
            $('.panel-body').html(data);

        },
        error: function (jqXHR) {
            if (jqXHR.status == 409) {
                myApp.updateFormModal(jqXHR.responseText);

            } else if (401 === jqXHR.status) {
                window.location.reload();
            }
            else {
                myApp.hideFormModal();
                myApp.createNotifyError(jqXHR.responseText);
            }
            $(o).prop("disabled", false);
            $(o).button('reset');
        }
    });
}

function removeVersionsFromPagePagination() {

    var patt = new RegExp(/version=\d+[&]*/);
    var patt2 = new RegExp(/loadShowIntoPanelByUrl\('(.*)'\);/);

    $('#pagination').find('a').each(function (index, value) {
        var oldHref = patt2.exec($(value).attr('onclick'))[1];

        $(value).attr('onclick', "loadShowIntoPanelByUrl('" + oldHref.replace(patt, '').replace('&', '') + "');");
    });

}

function addPrototype(elementId) {


    var $table = $(elementId);
    var prototype = $table.data('prototype');

    var index = $table.find('tr:not(:first()):not(.empty)').length;

    // Replace '__name__' in the prototype's HTML to
    // instead be a number based on how many items we have
    var newRow = prototype.replace(/__name__/g, index);

    // increase the index with one for the next item
    $table.data('index', index + 1);

    // add a delete link to the new form
//        addTagFormDeleteLink($newFormLi);


    if (index == 0) {
        $table.find('.empty').remove();
    }

    $table.find('tbody').append(newRow);
    $('.select2entity[data-autostart="true"]').select2entity();
    adjustCssSelect2();
    enableDatePicker();

}




// function addTagForm(tag,table,elemento) {
 function addTagForm(tag,table,elemento) {
    var $table = $(table);
    var $collectionHolder = $(tag);
    var prototype = $collectionHolder.data('prototype');
    //count the current number of <tr> inputs
    var index = $table.find('tr:not(:first()):not(.empty)').length;

    // increase the index with one for the next item
    $table.data('index', index + 1);

    // Replace '__name__' and other tag in the prototype's HTML to instead be a number based on how many item's row  we have into the table
    var cerca ='>'+elemento+'<';
    var sostituisci =' selected>'+elemento+'<';
    var newRow = prototype.replace(cerca,sostituisci).replace('<div id="appbundle_gruppi_elencoPersone___name__">','<tr>').replace(/<div class="form-group">/g,'<td>').replace('</div></div>','</td></tr>').replace(/<\/div>/g,'</td>').replace(/__name__/g, index);
    // var newRow = prototype.replace('<div id="appbundle_gruppi_elencoPersone___name__">','<tr>').replace(/<div class="form-group">/g,'<td>').replace('</div></div>','</td></tr>').replace(/<\/div>/g,'</td>').replace(/__name__/g, index);

    //STUDIARE E ATTIVARE QUANTO SEGUE
    if (index == 0) {
        $table.find('.empty').remove();
    }

    $table.find('tbody').append(newRow);
    //STUDIARE E ATTIVARE QUANTO SEGUE
    // $('.select2entity[data-autostart="true"]').select2entity();
    // adjustCssSelect2();
    enableDatePicker();
}

function removeRow(event, o)
{
    event.preventDefault();
    $(o).closest('tr').remove();

}

function updateNames($table) {
    $table.find('.row:not(:first())').each(function (idx) {
        var $inp = $(this).find('input');
        $inp.each(function (index, value) {
            var newName = value.name.replace(/(\[\d\])/, '[' + idx + ']');
            var newId = value.name.replace(/(\[\d\])/, '[' + idx + ']');
            $(this).attr('id', newId)
                .attr('name', newName);

        })
    });
}


function subscribeSessionTimeoutModal(url) {
    var $myModal = $('#myModal');
    $myModal.on("shown.bs.modal", function () {
        setTimeout(function () {
            renewSessionTimeout(url);
        }, 1380000);
    });
}


function renewSessionTimeout(url) {

    var patt = new RegExp(/(\/cartelle\/cicot\/web\/(app|app_dev)+[.]php\/\w+\/\d+\/)\d+\//);
    var newUrl = patt.exec(url)[1] + "session";

    $.ajax({
        url: newUrl,
        type: 'get',

        success: function () {
            console.log("session renewed");
        },
        error: function () {
            console.log("error in session renew");
        }
    });
}


function buildPopover() {
    $('[data-toggle="popover"]').popover({html: true});
}


function enableDatePicker() {

    var $date = $('.date');
    $date.datepicker({
        format: "dd/mm/yyyy",
        weekStart: 1,
        maxViewMode: 3,
        todayBtn: "linked",
        clearBtn: true,
        language: "it",
        multidate: false,
        daysOfWeekHighlighted: "0,6",
        autoclose: true,
        todayHighlight: true,
        toggleActive: true,
        minDay: "today"

    });
    $date.each(function () {
        //$(this).attr('readonly', 'readonly');

        if ($(this).val() == undefined) {
            if ($(this).attr('value') != undefined) {
                $(this).datepicker('setDate', moment($(this).attr('value'), 'DD/MM/YYYY').format('DD/MM/YYYY'));
            }
            else {
                $(this).datepicker('setDate', moment().format('DD/MM/YYYY'));
            }
        }

        if ($(this).attr('min') != undefined) {
            $(this).datepicker('setStartDate', moment($(this).attr('min'), 'DD/MM/YYYY').format('DD/MM/YYYY'));
        }


        if ($(this).attr('max') != undefined) {
            $(this).datepicker('setEndDate', moment($(this).attr('max'), 'DD/MM/YYYY').format('DD/MM/YYYY'));
        }

    });


}


var myApp;
myApp = myApp || (function () {

        var route;
        var nomeScheda;
        var idCartella;
        var idDecorso;
        var $formModal = $('#formModal');
        var $formModalClose = $('#formModalClose');
        var $confirmModal = $('#confirmModal');
        var $panel = $('.panel-body');


        return {

            showConfirmModal: function () {
                $confirmModal.modal('show');
            },
            hideConfirmModal: function () {
                $confirmModal.modal('hide');
            },
            updateConfirmModal: function (data) {
                $confirmModal.find('#confirmModalContent').html(data);
                enableDatePicker();
            },
            showFormModal: function () {
                $formModal.modal('show');
            },
            showFormModalClose: function () {
                $formModalClose.modal('show');
            },
            hideFormModal: function () {
                $formModal.modal('hide');
            },
            hideFormModalClose: function () {
                $formModalClose.modal('hide');
            },
            updateFormModal: function (data) {
                $formModal.find('#formModalContent').html(data);
                enableDatePicker();
                $('#onco_anapazamm_idSchedario_specifico').chained('#onco_anapazamm_idSchedario_diagnClinica');
            },
            updateFormModalClose: function (data) {
                $formModalClose.find('#formModalContent').html(data);
                enableDatePicker();
                $('#onco_anapazamm_idSchedario_specifico').chained('#onco_anapazamm_idSchedario_diagnClinica');
            },
            updatePanel: function (data) {
                $panel.html(data);
                //removeVersionsFromPagePagination();
            },
            resetPanel: function () {
                $panel.html('');

            },
            getRoute: function () {
                return route;
            },
            getRoutePrefix: function () {
                var patt = new RegExp(/(.+)_.+/);
                var arrayMatches = patt.exec(route);
                return arrayMatches[1];
            },
            setRoute: function (o) {
                route = o;
            },
            getNomeScheda: function () {
                return nomeScheda;
            },
            setNomeScheda: function (o) {
                nomeScheda = o;
            },
            getIdCartella: function () {
                return idCartella;
            },
            setIdCartella: function (o) {
                idCartella = o;
            },
            getIdDecorso: function () {
                return idDecorso;
            },
            setIdDecorso: function (o) {
                idDecorso = o;
            },
            createNotifyError: function (message) {
                $.notify({
                    // options
                    title: "Attenzione si è verificato un errore:",
                    message: message

                }, {
                    // settings
                    type: "danger",
                    allow_dismiss: true,
                    newest_on_top: true,
                    showProgressbar: false,
                    placement: {
                        from: "bottom",
                        align: "center"
                    },
                    offset: 50,
                    spacing: 10,
                    z_index: 1031,
                    delay: 0,
                    //delay: 3000,
                    //delay: if delay is set higher than 0 then the notification will auto-close after the delay period is up. Please keep in mind that delay uses milliseconds so 5000 is 5 seconds.
                    timer: 1000,

                    animate: {
                        enter: 'animated fadeInDown',
                        exit: 'animated fadeOutUp'
                    },

                    onClosed: function () {
                        window.location.reload();
                    }


                });
            }


        }
    })
    ();
