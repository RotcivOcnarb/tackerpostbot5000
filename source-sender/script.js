function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#blah')
                    .attr('src', e.target.result)
            };

            reader.readAsDataURL(input.files[0]);
        }
    }
	

	
$(document).ready(function() {
	$('#myForm').on('submit', function(e) {
		//prevent the default submithandling
		//e.preventDefault();
		//send the data of 'this' (the matched form) to yourURL
		$.post('enviar.php', $(this).serialize());
	});
});
	