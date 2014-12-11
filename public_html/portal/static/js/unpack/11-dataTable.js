route("portal/users/status=list", function(){
	var sesseion = ((Math.random()).toString()).replace(/^\d\./, "");
	$('#dtableme', this)
	.on( 'draw.dt', function () {
		$(".dataTables_info").persian_nu();
		$(".dataTables_paginate a").persian_nu();
	})
	.dataTable( {
		"processing": true,
		"serverSide": true,
		"ajax": "users/status=api/session="+sesseion,
		language: {
			processing:     "درحال بارگذاری",
			search:         "جستجو:",
			lengthMenu:    "مقدار _MENU_ سطر",
			info:           "مقدار _START_ تا _END_ از _TOTAL_ سطر",
			infoEmpty:      "هیچ سطری یافت نشد",
			infoFiltered:   "(مقدار _MAX_ بدون فیلتر)",
			infoPostFix:    "",
			loadingRecords: "درحال بارگذاری...",
			zeroRecords:    "هیچ سطری یافت نشد",
			emptyTable:     "هیچ سطری یافت نشد",
			paginate: {
				first:      "نخست",
				previous:   "قبلی",
				next:       "بعدی",
				last:       "آخرین"
			},
			aria: {
				sortAscending:  ": مرتب سازی صعودی",
				sortDescending: ": مرتب سازی نزولی"
			}
		},
		"order": [[ 0, "asc" ]],
		"lengthMenu": [[10, 25, 50], [10, 25, 50]]
	});
});