/*
 * Translated default messages for the jQuery validation plugin.
 * Locale: MY (Malay; Melayu)
 */
$.extend($.validator.messages, {
    required: "Medan ini diperlukan.",
    remote: "Sila betulkan medan ini.",
    email: "Sila masukkan alamat emel yang betul.",
    url: "Sila masukkan URL yang betul.",
    date: "Sila masukkan tarikh yang betul.",
    dateISO: "Sila masukkan tarikh(ISO) yang betul.",
    number: "Sila masukkan nombor yang betul.",
    digits: "Sila masukkan nilai digit sahaja.",
    creditcard: "Sila masukkan nombor kredit kad yang betul.",
    equalTo: "Sila masukkan nilai yang sama semula.",
    extension: "Sila masukkan nilai yang telah diterima.",
    maxlength: $.validator.format("Sila masukkan tidak lebih dari {0} aksara."),
    minlength: $.validator.format("Sila masukkan sekurang-kurangnya {0} aksara."),
    rangelength: $.validator.format("Sila masukkan antara {0} dan {1} panjang aksara."),
    range: $.validator.format("Sila masukkan nilai antara {0} dan {1} aksara."),
    max: $.validator.format("Sila masukkan nilai yang kurang atau sama dengan {0}."),
    min: $.validator.format("Sila masukkan nilai yang lebih atau sama dengan {0}.")
});


$.validator.addMethod("pattern", function(value, element, regexp) {
    return this.optional(element) || regexp.test(value);
}, "Sila masukkan format yang betul.");

$.validator.addMethod("npkp", function(value, element, regexp) {
    return this.optional(element) || /^(\d{2}(0[1-9]|1[0-2])(0[1-9]|[12]\d|3[01])(01|21|22|23|24|02|25|26|27|03|28|29|04|30|05|31|59|06|32|33|07|34|35|08|36|37|38 |39|09|40|10|41|42|43|44|11|45|46|12|47|48|49|13|50|51|52|53|14|54|55|56|57|15|58|16|82)\d{4})$/i.test(value);
}, "Sila masukkan format No/KP yang betul.");

$.validator.addMethod("integer", function(value, element) {
    return this.optional(element) || /^-?\d+$/.test(value);
}, "Sila masukkan nombor bulat sahaja.");

$.validator.addMethod("money", function(value, element) {
    // return this.optional(element) || /^\d{0,10}(\.\d{0,2})?$/.test(value);
    return this.optional(element) || /^\$(\d{1,3}(\,\d{3})*|(\d+))(\.\d{2})?$/.test(value);
}, "Sila masukkan format ringgit yang betul.");