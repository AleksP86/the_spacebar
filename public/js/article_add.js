$('#add_article_submit').on('click',function()
{
	//console.log('clicked');
	var title=$('#title').val();
	var text=$('#text_box').val();

	//console.log(title);
	//console.log(text);

	//console.log($('#upl_img').val());
	
	$.ajax({
		url:'../add_article',
		type:'POST',
		data:{title:title, text:text},
		success: function(data)
		{
			//console.log('ajax success');
			//console.log(data);
			$('#message_article').html("Article saved.");
			$('#title').val('');
			$('#text_box').val('');
			location.reload();
		},
		error: function()
		{
			console.log('ajax failed');
		}
	});
	
});

$('#add_quote_submit').on('click',function()
{
	var author=$('#author').val();
	var quote=$('#quote_box').val();
	var link=$('#link_box').val();

	//console.log(author);
	//console.log(quote);
	//$('#message_quote').html("Quote saved.");

	
	$.ajax({
		url:'../add_quote',
		type:'POST',
		data:{author:author, text:quote, link:link},
		success: function(data)
		{
			//console.log('ajax success');
			//console.log(data.reply);
			if(data.reply)
			{
				$('#author').val('');
				$('#quote_box').val('');
				$('#message_quote').html("Quote saved.");
			}
			else
			{
				$('#message_quote').html("Insuficient data.");
			}
			

		},
		error: function()
		{
			console.log('ajax failed');
		}
	});
	
});