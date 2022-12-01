function hide_insert(id) {
	content = document.querySelector("#input-" + id);
	text = document.querySelector("#text-" + id);
	save = document.querySelector("#save-but-" + id);
	edit_but = document.querySelector("#edit-butt-" + id);
	console.log(content.classList);

	content.classList.toggle("hidden");
	text.classList.toggle("hidden");
	save.classList.toggle("hidden");
	edit_but.classList.toggle("edit-img-press");
}