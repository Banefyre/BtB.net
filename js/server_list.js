$(document).ready(function(){

$('#talk').keypress(function(e) {
    if(e.which == 13)
	{
		$.ajax({
		url: "chat.php",
		method: "POST",
		data: { message : $(this).val() },
		success: function(res) {
			console.log(res);
		$('#talk').val("");
		}});
    }
});

setInterval(function (){
	$.ajax({
	url : 'chat.php',
	method: 'POST',
	data : { update : 'update' },
	success : function(res) {
	res = jQuery.parseJSON(res);
	$('.chatbox').empty();
	res.forEach(function(entry) {
		$('.chatbox').append('<div>' + entry['login'] + ' : ' + entry['message'] + '</div>');
	})}});
}, 1000);

});
