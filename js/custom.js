$(document).ready(function () {
	$(".navigation img").click(function () {
		$(this).addClass('active');
		$(this).siblings('img').removeClass('active');
		
		var id = $(this).attr('id');
		$("#"+id+"-panel").addClass('show');
		$("#"+id+"-panel").siblings('.nav-panel').removeClass('show');
		
	});
	
	$(".file-btn").click(function () {
		$("#file-modal").addClass('active');
	});
	
	$(".file-close").click(function () {
		$("#file-modal").removeClass('active');
	});
	
	$(".file-btn-search").click(function () {
	//	alert(1);
		$("#file-modal-search").addClass('active');
	});
	
	$(".file-close-search").click(function () {
		$("#file-modal-search").removeClass('active');
	});
	
	
});