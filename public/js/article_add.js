$('#add_article_submit').on('click',function()
{
	//console.log('clicked');
	var title=$('#title').val();
	var text=$('#text_box').val();

	//console.log(title);
	//console.log(text);

	$.ajax({
		url:'../add_article',
		type:'POST',
		data:{title:title, text:text},
		success: function(data)
		{
			//console.log('ajax success');
			console.log(data);
		},
		error: function()
		{
			console.log('ajax failed');
		}
	});
});

$('#add_article_submit').on('click',function()
{
	var author=$('#author').val();
	var quote=$('#quote_box').val();

	console.log(author);
	console.log(qoute);
}