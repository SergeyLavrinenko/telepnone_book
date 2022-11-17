

$(function () {
        $("#chkWideSearch").click(function () {
            if ($(this).is(":checked")) {
                $("#wide_search_box").removeClass("hidden");
                $("#search_field").prop("disabled", true);
                $("#search").prop("disabled", true);
                $("#search_btn").prop("disabled", true);
                $(".wide_search_fields").prop("disabled", false);
            } else {
                $("#wide_search_box").addClass("hidden");
                $("#search_field").prop("disabled", false);
                $("#search").prop("disabled", false);
                $("#search_btn").prop("disabled", false);
                $(".wide_search_fields").prop("disabled", true);
            }
        });
    });

$(function() {
  $('input[name="lname"]').on('input', function() {
    var idDataList = $(this).attr('list');
    var option = $('#' + idDataList + ' option[value="' + $(this).val() + '"]');
    var selectedId = option.length ? option.attr('data-id') : null;
    var hidden = $('input[name="lnameId"]');
    hidden.val(selectedId);
  });
});
$(function() {
  $('input[name="fname"]').on('input', function() {
    var idDataList = $(this).attr('list');
    var option = $('#' + idDataList + ' option[value="' + $(this).val() + '"]');
    var selectedId = option.length ? option.attr('data-id') : null;
    var hidden = $('input[name="fnameId"]');
    hidden.val(selectedId);
  });
});
$(function() {
  $('input[name="mname"]').on('input', function() {
    var idDataList = $(this).attr('list');
    var option = $('#' + idDataList + ' option[value="' + $(this).val() + '"]');
    var selectedId = option.length ? option.attr('data-id') : null;
    var hidden = $('input[name="mnameId"]');
    hidden.val(selectedId);
  });
});

function hide_insert() {
	content = document.querySelector(".insert_block");
	console.log(content.classList);

	content.classList.toggle("hidden");
}