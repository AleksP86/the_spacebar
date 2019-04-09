$(document).ready(function()
{
	$('.js-like-article').on('click',function(e)
		{
			e.preventDefault();

			var link=$(e.currentTarget);
			link.toggleClass('fa-hearth-o').toggleClass('fa-hearth');
			$.ajax({
				method:"POST",
				url:link.attr('href')
			}).done(function(data)
			{
				$('.js-like-article-count').html(data.hearths);
			})
		});

	$('#submit_comment').on('click',function(e)
		{
			e.preventDefault();
			var com_mess=$('#articleText').val();
			
			var url=window.location.pathname;
			url=url.replace('%20',' ');
			
			$.ajax(
			{
				url:url+'/comment',
				type:"post",
				data:{'message':com_mess},
				dataType:'json',
				success: function(data)
				{
					console.log(data);
					//refresh page
					$('#articleText').val('');
					location.reload();
				},
				error: function()
				{
					console.log('ajax failed');
				}
			});
		});
});