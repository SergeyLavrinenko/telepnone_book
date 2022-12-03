wideSearchFlag = true;
$(function () {
        $("#chkWideSearch").click(function () {
            if (wideSearchFlag) {
                $("#wide_search_box").removeClass("hidden");
                $("#search_field").prop("disabled", true);
                $("#search").prop("disabled", true);
                $("#search_btn").prop("disabled", true);
                $(".wide_search_fields").prop("disabled", false);
                $("#wide_arrow").css({'transform': 'rotate(180deg)'});
                $(".main-search").css({'background': '#aaaaaa'});
                $("#wide-main-box").css({'background': '#efefef'});
                wideSearchFlag = false;
            } else {
                $("#wide_search_box").addClass("hidden");
                $("#search_field").prop("disabled", false);
                $("#search").prop("disabled", false);
                $("#search_btn").prop("disabled", false);
                $(".wide_search_fields").prop("disabled", true);
                $("#wide_arrow").css({'transform': 'none'});
                $(".main-search").css({'background': 'transparent'});
                $("#wide-main-box").css({'background': '#ffffff'});
                wideSearchFlag = true;
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
function hide_update(id) {
	content = document.querySelectorAll(".content_td-" + id);
	lname = document.querySelector("#input-lname-" + id);
	fname = document.querySelector("#input-fname-" + id);
	mname = document.querySelector("#input-mname-" + id);
	streets = document.querySelector("#input-streets-" + id);
	building = document.querySelector("#input-building-" + id);
	apart = document.querySelector("#input-apart-" + id);
	pnone_number = document.querySelector("#input-phone_number-" + id);
  save_but = document.querySelector("#save-but-" + id);

	lname.classList.toggle("hidden");
	fname.classList.toggle("hidden");
	mname.classList.toggle("hidden");
	streets.classList.toggle("hidden");
	building.classList.toggle("hidden");
	apart.classList.toggle("hidden");
	pnone_number.classList.toggle("hidden");
  save_but.classList.toggle("hidden");

	content.forEach((item) => {item.classList.toggle("hidden")});


	//edit_but.classList.toggle("edit-img-press");
}