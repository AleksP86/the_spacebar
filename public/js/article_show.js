$(document).ready(function()
{
	$('.js-like-article').on('click',function(e)
		{
			e.preventDefault();

			var link=$(e.currentTarget);
			link.toggleClass('fa-hearth-o').toggleClass('fa-hearth');

			//$('.js-like-article-count').html('TEST');

			$.ajax({
				method:"POST",
				url:link.attr('href')
			}).done(function(data)
			{
				$('.js-like-article-count').html(data.hearths);
			})

			//console.log(link.attr('href'));
			/*
			$.ajax({
				url:'/login/check',
				type:"post",
				data: {email:$('#user_email').val().trim()},
				dataType:'json',
				success: function(data)
				{

				}
			});
			*/
		});
});