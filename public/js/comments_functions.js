function DeleteComment(p)
{
	//console.log('delete comment '+p);
	// /admin/comment/delete
	//console.log(window.location.pathname);
	
	$.ajax({
		url:window.location.pathname+'/delete',
		type:'POST',
		data:{id:p},
		success: function(data)
		{
			//console.log('ajax success');
			//console.log(data);
			//hide button
			location.reload();
		},
		error: function()
		{
			//console.log('ajax failed');
		}
	});
}