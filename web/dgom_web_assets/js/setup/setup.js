var loader = ".js-loader";

function iniciarLadda(a) {
    var r = Ladda.create(a);
    return r.start(), r
}

function detenerLadda(a) {
    a.stop()
}

function validarFormulario(a) {
    return !a.find(".has-error").length
}

function enviarDataAjaxWithLadda(a, r, e, o, n) {
    var t = iniciarLadda(n);
    $.ajax({
        url: a,
        method: e,
        data: r,
        success: function(a) {
            toastr.success(o)
        },
        error: function(a, r, e) {
            var o = a.responseText;
            toastr.warning("Ocurrio un problema al procesar la información:" + o.Message)
        }
    }).always(function() {
        detenerLadda(t)
    })
}

function enviarDataAjaxLoader(a, r, e, o) {
    mostrarLoader(), $.ajax({
        url: a,
        method: e,
        data: r,
        success: function(a) {
            toastr.success(o)
        },
        error: function(a, r, e) {
            var o = a.responseText;
            toastr.warning("Ocurrio un problema al procesar la información:" + o.Message)
        }
    }).always(function() {
        ocultarLoader()
    })
}

function mostrarLoader() {
    $(loader).show()
}

function ocultarLoader() {
    $(loader).hide()
}

var toastr = {};

toastr.options = {
    closeButton: !0,
    debug: !1,
    newestOnTop: !1,
    progressBar: !1,
    preventDuplicates: !1,
    onclick: null,
    showDuration: "300",
    hideDuration: "1000",
    timeOut: "5000",
    extendedTimeOut: "1000",
    showEasing: "swing",
    hideEasing: "linear",
    showMethod: "fadeIn",
    hideMethod: "fadeOut"
}, $(document).on("beforeSubmit", "form.ajax", function() {
    var a = $(this),
        r = a.attr("action"),
        e = a.serialize(),
        o = a.find(".ladda-button").get(0);
    if (validarFormulario(a)) return enviarDataAjaxWithLadda(r, e, "POST", "Información procesada", o), !1
    }), $(document).on("click", ".js-change-ajax", function() {
        var a, r = $(this).parents("form"),
            e, o;
        enviarDataAjaxLoader(r.attr("action"), r.serialize(), "POST", "Datos procesados")
    });
//# sourceMappingURL=core-min.js.map