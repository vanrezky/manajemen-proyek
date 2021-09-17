"use strict";

function showLoading(active = false) {
	if (active) {
		Swal.fire({
			title: "Please Wait !",
			html: "data uploading", // add html attribute if you want or remove
			allowOutsideClick: false,
			onBeforeOpen: () => {
				Swal.showLoading();
			},
		});
	} else {
		Swal.close();
	}
}

function deleteData(btn) {
	Swal.fire({
		title: "Konfirmasi Ulang",
		text: "Yakin menghapus data?",
		icon: "warning",
		showCancelButton: true,
		reverseButtons: true,
	}).then((result) => {
		if (result.isConfirmed) {
			$.ajax({
				type: "post",
				url: $(btn).attr("href"),
				data: $("#form-delete").serialize(),
				dataType: "json",
				beforeSend: function () {
					$(btn).addClass("disabled");
				},
				complete: function () {
					$(btn).removeClass("disabled");
				},
				success: function (response) {
					if (response.success) {
						Swal.fire("Sukses..", response.message, "success").then(() => {
							location.reload();
						});
					} else {
						Swal.fire("Opps..", response.message, "error");
					}
				},
			});
		}
	});
}

function error_message(array) {
	$.each(array, function (index, value) {
		if (value) {
			$("#" + index).addClass("is-invalid");
			$(".feed" + index).html(value);
		} else {
			$("#" + index).removeClass("is-invalid");
			$(".feed" + index).html("");
		}
	});
}
