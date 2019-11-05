// universal ajax
function doAjax(typeArg, urlArg, dataArg){
	if (typeof data['model'] === 'undefined') {
		data['model'] = null
	}
	if (typeof data['action'] === 'undefined') {
		data['action'] = null
	}

	return $.ajax({
		type: typeArg,
		url: urlArg,
		data: dataArg
	});
}