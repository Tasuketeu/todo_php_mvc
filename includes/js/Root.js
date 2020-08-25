	$(document).ready(function(){
	//Отправляем POST запрос по нажатии на меню статуса
	$('#status').on('change', function() {
		var status_id = $(this).val();
		if(status_id){
			$.ajax({
				url: '/TestProject/edit.php',
				type:'POST',
				data: {
			"status" : status_id
			 },
			success: function(data){
			console.log(data)
			}
			});
		}
	})
});